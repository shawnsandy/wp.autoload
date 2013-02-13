<?php
/*
Plugin Name: ZillaShare
Plugin URI: http://www.themezilla.com/plugins/zillashare/
Description: Easily share your posts and pages on Twitter, Facebook, Pinterest and Google+
Version: 1.1
Author: ThemeZilla
Author URI: http://www.themezilla.com
*/

class ZillaShare {

    function __construct() 
    {	
    	add_action('admin_init', array(&$this, 'admin_init'));
        add_action('admin_menu', array(&$this, 'admin_menu'), 99);
        add_action('wp_print_styles', array(&$this, 'print_styles'));
        add_filter('the_content', array(&$this, 'the_content'));
        add_filter('the_excerpt', array(&$this, 'the_content'));
        add_shortcode('zilla_share', array(&$this, 'shortcode'));
        add_action('wp_footer', array(&$this, 'output_scripts'));
	}
	
	function admin_init()
	{
		register_setting( 'zilla-share', 'zilla_share_settings', array(&$this, 'settings_validate') );
		add_settings_section( 'zilla-share', '', array(&$this, 'section_intro'), 'zilla-share' );
		
		add_settings_field( 'text', __( 'Text', 'zilla' ), array(&$this, 'setting_text'), 'zilla-share', 'zilla-share' );
		add_settings_field( 'add_to_posts', __( 'Automatically show buttons on', 'zilla' ), array(&$this, 'setting_add_to_posts'), 'zilla-share', 'zilla-share' );
		add_settings_field( 'exclude_from', __( 'Exclude from Post/Page ID', 'zilla' ), array(&$this, 'setting_exclude_from'), 'zilla-share', 'zilla-share' );
		add_settings_field( 'disable_css', __( 'Disable CSS', 'zilla' ), array(&$this, 'setting_disable_css'), 'zilla-share', 'zilla-share' );
		add_settings_field( 'buttons', __( 'Services', 'zilla' ), array(&$this, 'setting_buttons'), 'zilla-share', 'zilla-share' );
		add_settings_field( 'twitter_options', __( 'Twitter Options', 'zilla' ), array(&$this, 'setting_twitter_options'), 'zilla-share', 'zilla-share' );
		add_settings_field( 'facebook_options', __( 'Facebook Options', 'zilla' ), array(&$this, 'setting_facebook_options'), 'zilla-share', 'zilla-share' );
		add_settings_field( 'google_options', __( 'Google Options', 'zilla' ), array(&$this, 'setting_google_options'), 'zilla-share', 'zilla-share' );
		add_settings_field( 'pinterest_options', __( 'Pinterest Options', 'zilla' ), array(&$this, 'setting_pinterest_options'), 'zilla-share', 'zilla-share' );
		add_settings_field( 'preview', __( 'Preview', 'zilla' ), array(&$this, 'setting_preview'), 'zilla-share', 'zilla-share' );
		add_settings_field( 'instructions', __( 'Shortcode and Template Tag', 'zilla' ), array(&$this, 'setting_instructions'), 'zilla-share', 'zilla-share' );
	}
	
	function admin_menu() 
	{
		$icon_url = plugins_url( '/images/favicon.png', __FILE__ );
		$page_hook = add_menu_page( __( 'ZillaShare Settings', 'zilla' ), __( 'ZillaShare', 'zilla' ), 'update_core', 'zilla-share', array(&$this, 'settings_page'), $icon_url );
		add_submenu_page( 'zilla-share', __( 'Settings', 'zilla' ), __( 'ZillaShare Settings', 'zilla' ), 'update_core', 'zilla-share', array(&$this, 'settings_page') );
		// ZillaFramework link
		add_submenu_page( 'zillaframework', __( 'ZillaShare', 'zilla' ), __( 'ZillaShare', 'zilla' ), 'update_core', 'zilla-share', array(&$this, 'settings_page') );
		
		add_action( 'admin_print_scripts-'. $page_hook, array(&$this, 'admin_print_scripts') );
		add_action( 'admin_print_styles-'. $page_hook, array(&$this, 'print_styles') );
	}
	
	function admin_print_scripts(){}
	
	function print_styles()
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['disable_css']) ) $options['disable_css'] = '0';
		
		if(!$options['disable_css']) wp_enqueue_style('zilla-share', plugins_url( '/styles/zilla-share.css', __FILE__ ));
	}
	
	function settings_page()
	{
		?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			<h2>ZillaShare Settings</h2>
			<p><?php _e('ZillaShare allows you to display social sharing links throughout your site. Customize the output of ZillaShare with this settings page. Select the services to be used, preferred stylings, and where to display.', 'zilla'); ?></p>
			<p><?php _e('Check out our other free <a href="http://www.themezilla.com/plugins/?ref=zillashare">plugins</a> and <a href="http://www.themezilla.com/themes/?ref=zillashare">themes</a>.', 'zilla'); ?></p>
			<?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] ){ ?>
			<div id="setting-error-settings_updated" class="updated settings-error"> 
				<p><strong><?php _e( 'Settings saved.', 'zilla' ); ?></strong></p>
			</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'zilla-share' ); ?>
				<?php do_settings_sections( 'zilla-share' ); ?>
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'zilla' ); ?>" /></p>
			</form>
		</div>
		<?php
	}
	
	function section_intro(){}
	
	function setting_text()
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['text']) ) $options['text'] = 'Hey, like this post? Why not share it with a buddy?';
		
		echo '<input type="text" name="zilla_share_settings[text]" class="regular-text" value="'. $options['text'] .'" />';
	}
	
	function setting_buttons()
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['show_twitter']) ) $options['show_twitter'] = '1';
		if( !isset($options['show_facebook']) ) $options['show_facebook'] = '1';
		if( !isset($options['show_google']) ) $options['show_google'] = '1';
		if( !isset($options['show_pinterest']) ) $options['show_pinterest'] = '1';
		
		echo '<input type="hidden" name="zilla_share_settings[show_twitter]" value="0" />
		<label><input type="checkbox" name="zilla_share_settings[show_twitter]" value="1"'. (($options['show_twitter']) ? ' checked="checked"' : '') .' />
		Twitter</label><br />
		<input type="hidden" name="zilla_share_settings[show_facebook]" value="0" />
		<label><input type="checkbox" name="zilla_share_settings[show_facebook]" value="1"'. (($options['show_facebook']) ? ' checked="checked"' : '') .' />
		Facebook</label><br />
		<input type="hidden" name="zilla_share_settings[show_google]" value="0" />
		<label><input type="checkbox" name="zilla_share_settings[show_google]" value="1"'. (($options['show_google']) ? ' checked="checked"' : '') .' />
		Google</label><br />
		<input type="hidden" name="zilla_share_settings[show_pinterest]" value="0" />
		<label><input type="checkbox" name="zilla_share_settings[show_pinterest]" value="1"'. (($options['show_pinterest']) ? ' checked="checked"' : '') .' />
		Pinterest <strong>(requires a post featured image to be set)</strong></label><br />';
	}
	
	function setting_twitter_options()
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['twitter_via']) ) $options['twitter_via'] = '';
		if( !isset($options['twitter_recommend']) ) $options['twitter_recommend'] = '';
		if( !isset($options['twitter_showcount']) ) $options['twitter_showcount'] = '1';
		if( !isset($options['twitter_largebutton']) ) $options['twitter_largebutton'] = '0';
		if( !isset($options['twitter_layout']) ) $option['twitter_layout'] = 'horizontal';
		
		echo '<label>Via @<input type="text" name="zilla_share_settings[twitter_via]" value="'. $options['twitter_via'] .'" /></label><br />
		<label>Recommend @<input type="text" name="zilla_share_settings[twitter_recommend]" value="'. $options['twitter_recommend'] .'" /></label><br />
		<input type="hidden" name="zilla_share_settings[twitter_showcount]" value="0" />
		<label><input type="checkbox" name="zilla_share_settings[twitter_showcount]" value="1"'. (($options['twitter_showcount']) ? ' checked="checked"' : '') .' />
		Show Count</label><br />
		<input type="hidden" name="zilla_share_settings[twitter_largebutton]" value="0" />
		<label><input type="checkbox" name="zilla_share_settings[twitter_largebutton]" value="1"'. (($options['twitter_largebutton']) ? ' checked="checked"' : '') .' />
		Large Button</label><br />';
		echo '<label>Layout <select name="zilla_share_settings[twitter_layout]">
		<option value="horizontal"'. (($options['twitter_layout'] == 'horizontal') ? ' selected="selected"' : '') .'>Horizontal</option>
		<option value="vertical"'. (($options['twitter_layout'] == 'vertical') ? ' selected="selected"' : '') .'>Vertical</option>
		</select></label><br />';
		
	}
	
	function setting_facebook_options()
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['facebook_layout']) ) $options['facebook_layout'] = 'button_count';
		if( !isset($options['facebook_verb']) ) $options['facebook_verb'] = 'like';
		if( !isset($options['facebook_colorscheme']) ) $options['facebook_colorscheme'] = 'light';
		
		echo '<label>Layout <select name="zilla_share_settings[facebook_layout]">
		<option value="button_count"'. (($options['facebook_layout'] == 'button_count') ? ' selected="selected"' : '') .'>Button Count</option>
		<option value="box_count"'. (($options['facebook_layout'] == 'box_count') ? ' selected="selected"' : '') .'>Box Count</option>
		</select></label><br />
		<label>Verb <select name="zilla_share_settings[facebook_verb]">
		<option value="like"'. (($options['facebook_verb'] == 'like') ? ' selected="selected"' : '') .'>Like</option>
		<option value="recommend"'. (($options['facebook_verb'] == 'recommend') ? ' selected="selected"' : '') .'>Recommend</option>
		</select></label><br />
		<label>Color Scheme <select name="zilla_share_settings[facebook_colorscheme]">
		<option value="light"'. (($options['facebook_colorscheme'] == 'light') ? ' selected="selected"' : '') .'>Light</option>
		<option value="dark"'. (($options['facebook_colorscheme'] == 'dark') ? ' selected="selected"' : '') .'>Dark</option>
		</select></label><br />';
	}
	
	function setting_google_options()
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['google_size']) ) $options['google_size'] = 'medium';
		if( !isset($options['google_annotation']) ) $options['google_annotation'] = '';
		
		echo '<label>Size <select name="zilla_share_settings[google_size]">
		<option value="small"'. (($options['google_size'] == 'small') ? ' selected="selected"' : '') .'>Small</option>
		<option value="medium"'. (($options['google_size'] == 'medium') ? ' selected="selected"' : '') .'>Medium</option>
		<option value=""'. (($options['google_size'] == '') ? ' selected="selected"' : '') .'>Standard</option>
		<option value="tall"'. (($options['google_size'] == 'tall') ? ' selected="selected"' : '') .'>Tall</option>
		</select></label><br />
		<label>Annotation <select name="zilla_share_settings[google_annotation]">
		<option value=""'. (($options['google_annotation'] == '') ? ' selected="selected"' : '') .'>Bubble</option>
		<option value="none"'. (($options['google_annotation'] == 'none') ? ' selected="selected"' : '') .'>None</option>
		</select></label><br />';
	}
	
	function setting_pinterest_options()
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['pinterest_count']) ) $options['pinterest_count'] = 'horizontal';
		
		echo '<label>Pin Count <select name="zilla_share_settings[pinterest_count]">
		<option value="horizontal"'. (($options['pinterest_count'] == 'horizontal') ? ' selected="selected"' : '') .'>Horizontal</option>
		<option value="vertical"'. (($options['pinterest_count'] == 'vertical') ? ' selected="selected"' : '') .'>Vertical</option>
		<option value="none"'. (($options['pinterest_count'] == 'none') ? ' selected="selected"' : '') .'>None</option>
		</select></label><br />';
	}
	
	function setting_add_to_posts()
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['add_to_posts']) ) $options['add_to_posts'] = '1';
		if( !isset($options['add_to_pages']) ) $options['add_to_pages'] = '0';
		if( !isset($options['add_to_other']) ) $options['add_to_other'] = '0';
		
		echo '<input type="hidden" name="zilla_share_settings[add_to_posts]" value="0" />
		<label><input type="checkbox" name="zilla_share_settings[add_to_posts]" value="1"'. (($options['add_to_posts']) ? ' checked="checked"' : '') .' />
		Single Post</label><br />
		<input type="hidden" name="zilla_share_settings[add_to_pages]" value="0" />
		<label><input type="checkbox" name="zilla_share_settings[add_to_pages]" value="1"'. (($options['add_to_pages']) ? ' checked="checked"' : '') .' />
		Pages</label><br />
		<input type="hidden" name="zilla_share_settings[add_to_other]" value="0" />
		<label><input type="checkbox" name="zilla_share_settings[add_to_other]" value="1"'. (($options['add_to_other']) ? ' checked="checked"' : '') .' />
		Blog Index Page, Archive Pages, and Search Results</label><br />';
		
		/* Custom Post Types -----
		$post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects', 'and');
		foreach($post_types as $key=>$post_type){
			if( !isset($options['add_to_'. $key]) ) $options['add_to_'. $key] = '0';
			echo '<input type="hidden" name="zilla_share_settings[add_to_'. $key .']" value="0" />
			<label><input type="checkbox" name="zilla_share_settings[add_to_'. $key .']" value="1"'. (($options['add_to_'. $key]) ? ' checked="checked"' : '') .' />
			'. $post_type->label .'</label><br />';
		}
		*/
	}
	
	function setting_exclude_from()
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['exclude_from']) ) $options['exclude_from'] = '';
		
		echo '<input type="text" name="zilla_share_settings[exclude_from]" class="regular-text" value="'. $options['exclude_from'] .'" />
		<p class="description">Comma separated list of post/page ID\'s (e.g. 4,7,87)</p>';
	}
	
	function setting_disable_css()
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['disable_css']) ) $options['disable_css'] = '0';
		
		echo '<input type="hidden" name="zilla_share_settings[disable_css]" value="0" />
		<label><input type="checkbox" name="zilla_share_settings[disable_css]" value="1"'. (($options['disable_css']) ? ' checked="checked"' : '') .' />
		I want to use my own CSS styles</label>';
	}
	
	function setting_preview()
	{
		echo '<div id="zilla-share-preview">'. $this->do_share( true, true ) .'</div>';
		$this->output_scripts();
	}
	
	function setting_instructions()
	{
		echo '<p>To use ZillaShare manually in your posts and pages you can use the shortcode:</p>
		<p><code>[zilla_share]</code></p>
		<p>To use ZillaShare manually in your theme template use the following PHP code:</p>
		<p><code>&lt;?php if( function_exists(\'zilla_share\') ) zilla_share(); ?&gt;</code></p>';
	}
	
	function settings_validate($input)
	{
		$input['text'] = trim(strip_tags($input['text']));
		$input['twitter_via'] = trim(strip_tags($input['twitter_via']));
		$input['twitter_recommend'] = trim(strip_tags($input['twitter_recommend']));
		$input['exclude_from'] = str_replace(' ', '', trim(strip_tags($input['exclude_from'])));
		
		return $input;
	}
	
	function the_content( $content )
	{	
	    // Don't show on custom page templates	
	    if(is_page_template()) return $content;
	    
		global $wp_current_filter;
		if ( in_array( 'get_the_excerpt', (array) $wp_current_filter ) ) {
			return $content;
		}
		
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['add_to_posts']) ) $options['add_to_posts'] = '0';
		if( !isset($options['add_to_pages']) ) $options['add_to_pages'] = '0';
		if( !isset($options['add_to_other']) ) $options['add_to_other'] = '0';
		if( !isset($options['exclude_from']) ) $options['exclude_from'] = '';
		
		$ids = explode(',', $options['exclude_from']);
		if(in_array(get_the_ID(), $ids)) return $content;
		
		if(is_singular('post') && $options['add_to_posts']) $content .= $this->do_share();
		if(is_page() && !is_front_page() && $options['add_to_pages']) $content .= $this->do_share();
		if((is_front_page() || is_home() || is_archive() || is_search()) && $options['add_to_other']) $content .= $this->do_share(true);
		
		/* Custom Post Types -----
		$post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects', 'and');
		foreach($post_types as $post_type=>$val){
			if( !isset($options['add_to_'. $post_type]) ) $options['add_to_'. $post_type] = '0';
			if(is_singular($post_type) && $options['add_to_'. $post_type]) $content .= $this->do_share();
		}
		*/
		
		return $content;
	}
	
	function shortcode( $atts )
	{
		extract( shortcode_atts( array(), $atts ) );
		$use_permalink = false;
		if( in_the_loop() ) $use_permalink = true;
		return $this->do_share( $use_permalink );
	}
	
	function do_share( $use_permalink = false, $is_preview = false )
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['text']) ) $options['text'] = 'Hey, like this post? Why not share it with a buddy?';
		if( !isset($options['show_twitter']) ) $options['show_twitter'] = '1';
		if( !isset($options['show_facebook']) ) $options['show_facebook'] = '1';
		if( !isset($options['show_google']) ) $options['show_google'] = '1';
		if( !isset($options['show_pinterest']) ) $options['show_pinterest'] = '1';
		if( !isset($options['twitter_via']) ) $options['twitter_via'] = '';
		if( !isset($options['twitter_recommend']) ) $options['twitter_recommend'] = '';
		if( !isset($options['twitter_showcount']) ) $options['twitter_showcount'] = '1';
		if( !isset($options['twitter_largebutton']) ) $options['twitter_largebutton'] = '0';
		if( !isset($options['twitter_layout']) ) $options['twitter_layout'] = 'horizontal';
		if( !isset($options['facebook_layout']) ) $options['facebook_layout'] = 'button_count';
		if( !isset($options['facebook_verb']) ) $options['facebook_verb'] = 'like';
		if( !isset($options['facebook_colorscheme']) ) $options['facebook_colorscheme'] = 'light';
		if( !isset($options['google_size']) ) $options['google_size'] = 'medium';
		if( !isset($options['google_annotation']) ) $options['google_annotation'] = '';
		if( !isset($options['pinterest_count']) ) $options['pinterest_count'] = 'horizontal';
		
		$permalink = get_permalink();
		if($is_preview) $permalink = 'http://www.themezilla.com';
		
		$output = '<div class="zilla-share">';
		if($options['text']) $output .= '<p class="zilla-text">'. $options['text'] .'</p>';
		if($options['show_twitter']) $output .= '<a href="https://twitter.com/share" class="twitter-share-button"';
		if($options['show_twitter'] && $options['twitter_via']) $output .= ' data-via="'. $options['twitter_via'] .'"';
		if($options['show_twitter'] && $options['twitter_recommend']) $output .= ' data-related="'. $options['twitter_recommend'] .'"';
		if($options['show_twitter'] && !$options['twitter_showcount']) $output .= ' data-count="none"';
		if($options['show_twitter'] && $options['twitter_largebutton']) $output .= ' data-size="large"';
		if($options['show_twitter'] && $options['twitter_showcount']) $output .= ' data-count="' . $options['twitter_layout'] . '"';
		if($options['show_twitter'] && $use_permalink) $output .= ' data-url="'. $permalink .'"';
		if($options['show_twitter'] && $use_permalink) $output .= ' data-text="'. get_the_title() .'"';
		if($options['show_twitter']) $output .= '>Tweet</a>';
		if($options['show_facebook']) $output .= '<div class="fb-like" data-send="false" data-show-faces="false" data-layout="'. $options['facebook_layout'] .'"';
		if($options['show_facebook'] && $options['facebook_verb'] == 'recommend') $output .= ' data-action="recommend"';
		if($options['show_facebook'] && $options['facebook_colorscheme'] == 'dark') $output .= ' data-colorscheme="dark"';
		if($options['show_facebook'] && $use_permalink) $output .= ' data-href="'. $permalink .'"';
		if($options['show_facebook']) $output .= '></div>';
		if($options['show_google']) $output .= '<div class="g-plusone"';
		if($options['show_google'] && $options['google_size']) $output .= ' data-size="'. $options['google_size'] .'"';
		if($options['show_google'] && $options['google_annotation']) $output .= ' data-annotation="'. $options['google_annotation'] .'"';
		if($options['show_google'] && $use_permalink) $output .= ' data-href="'. $permalink .'"';
		if($options['show_google']) $output .= '></div>';
		if( !$is_preview && $options['show_pinterest'] && has_post_thumbnail() && get_the_ID() ) {
			$post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
			$output .= '<a href="http://pinterest.com/pin/create/button/?url='. $permalink .'&media='. $post_thumb[0] .'" class="pin-it-button" count-layout="'. $options['pinterest_count'] .'"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';
		}
		if($options['show_pinterest'] && $is_preview) $output .= '<a href="http://pinterest.com/pin/create/button/?url='. $permalink .'&media=http://gti.themezilla.com/wp-content/themes/themezilla/images/logo.png" class="pin-it-button" count-layout="'. $options['pinterest_count'] .'"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';
		$output .= '</div>';
		
		return $output;
	}
	
	function output_scripts()
	{
		$options = get_option( 'zilla_share_settings' );
		if( !isset($options['show_twitter']) ) $options['show_twitter'] = '1';
		if( !isset($options['show_facebook']) ) $options['show_facebook'] = '1';
		if( !isset($options['show_google']) ) $options['show_google'] = '1';
		if( !isset($options['show_pinterest']) ) $options['show_pinterest'] = '1';
		
		$output = '<!-- Zilla Share Scripts -->'."\n";
		if($options['show_twitter']) $output .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
		if($options['show_facebook']) $output .= '<div id="fb-root"></div><script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, "script", "facebook-jssdk"));</script>';
		if($options['show_google']) $output .= '<script type="text/javascript">
	    (function() {
	      var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
	      po.src = "https://apis.google.com/js/plusone.js";
	      var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
	    })();
	    </script>';
	    if($options['show_pinterest']) $output .= '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>';
										  
		echo $output;
	}
	
}
global $zilla_share;
$zilla_share = new ZillaShare();

function zilla_share(){
	global $zilla_share;
	$use_permalink = false;
	if( in_the_loop() ) $use_permalink = true;
	echo $zilla_share->do_share( $use_permalink );
}

?>