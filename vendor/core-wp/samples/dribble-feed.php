<?

/* Post Type
   ------------------------------------------------------------------------------------ */
add_action( 'init', 'register_cpt_shot' );

function register_cpt_shot() {

    $labels = array(
        'name' => _x( 'Dribble Shots', 'shot' ),
        'singular_name' => _x( 'Dribbble Shot', 'shot' ),
        'add_new' => _x( 'Add New', 'shot' ),
        'add_new_item' => _x( 'Add New Dribbble Shot', 'shot' ),
        'edit_item' => _x( 'Edit Dribbble Shot', 'shot' ),
        'new_item' => _x( 'New Dribbble Shot', 'shot' ),
        'view_item' => _x( 'View Dribbble Shot', 'shot' ),
        'search_items' => _x( 'Search Dribble Shots', 'shot' ),
        'not_found' => _x( 'No dribble shots found', 'shot' ),
        'not_found_in_trash' => _x( 'No dribble shots found in Trash', 'shot' ),
        'parent_item_colon' => _x( 'Parent Dribbble Shot:', 'shot' ),
        'menu_name' => _x( 'Dribble Shots', 'shot' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,

        'supports' => array( 'title', 'custom-fields' ),

        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,

        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'shot', $args );
}




/* Import Shots via RSS
   ------------------------------------------------------------------------------------ */

// grab the image src from teh description
function get_image($string) {
        preg_match_all('/<img[^>]+>/i',$string, $result);
        $img = array();
        foreach( $result[0] as $img_tag)
        {
                preg_match_all('/(src)=("[^"]*")/i',$img_tag, $img[$img_tag]);
        }
        return trim($img[$img_tag][2][0], '"');
}

// create an array of the feed items
include_once(ABSPATH . WPINC . '/feed.php');
$feed = fetch_feed('http://dribbble.com/tammyhart/shots.rss');
$feed = $feed->get_items(0);

$shots = array();
foreach ( $feed as $item ) :
$shots[$item->get_date('Ymd')] = array(
        'id'    => $item->get_date('Ymd'),
        'url'   => esc_url( $item->get_permalink() ),
        'date'  => $item->get_date('Y-m-d H:i:s'),
        'title' => esc_html( $item->get_title() ),
        'image' => get_image($item->get_description())
        );
endforeach;

// create posts from our array
foreach ($shots as $shot) {
        $shot_post = array(
                'post_type'     => 'shot',
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_title'    => $shot['title'],
                'post_date'     => $shot['date']
                );

        $shot_post_meta = array(
                'link_url'      => $shot['url'],
                'image'         => $shot['image']
                );

        $posts = get_posts(
                array(
                        'post_type'     => 'shot',
                        'meta_key'      => 'link_url',
                        'meta_value'=> $shot_post_meta['link_url']
                        )
                );

        if (count($posts) == 0) {
                $post_id = wp_insert_post($shot_post);
                add_post_meta($post_id, 'link_url', $shot_post_meta['link_url'], true);
                add_post_meta($post_id, 'image', $shot_post_meta['image'], true);
        }
}
?>