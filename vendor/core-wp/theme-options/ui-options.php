<?php
global $select_options, $radio_options;
if (!isset($_REQUEST['settings-updated']))
    $_REQUEST['settings-updated'] = false;
?>
<div class="wrap">
    <?php
    //$tab = isset($_GET['tab']) ? $_GET['tab'] : 'theme_desc';

    //cwp_theme_tabs($tab);
    ?>
    <div id="icon-themes" class="icon32"><br></div>
     <h2><?php _e('Theme Settings','corewp') ?></h2>
     <p>
      <?php if (false !== $_REQUEST['settings-updated']) : ?>
        <div class="updated fade"><p><strong><?php _e('Options saved', 'corewp'); ?></strong></p></div>
    <?php endif; ?>
     </p>

    <!--   <?php screen_icon(); echo "<h2>" . _e(' Theme Settings', 'corewp') . "</h2>"; ?>     -->

        <form method="post" action="options.php">
            <?php settings_fields('cwp_options'); ?>
            <?php $options = get_option('cwp_theme_options'); ?>

            <table class="form-table">


                <?php
                /**
                 * A sample text input option
                 */
                ?>
                <tr valign="top"><th scope="row"><?php _e('Support Key', 'corewp'); ?></th>
                    <td>
                        <input id="cwp_theme_options[supportkey]" class="regular-text" type="text" name="cwp_theme_options[supportkey]" value="<?php esc_attr_e(cwp::theme_options('supportkey')); ?>" />
                        <label class="description" for="cwp_theme_options[supportkey]"><?php _e('Your Support key', 'corewp'); ?></label>
                    </td>
                </tr>




                <?php
                /**
                 * Offline mode
                 */
                ?>
                <tr valign="top"><th scope="row"><?php _e('Offline Mode', 'corewp'); ?></th>
                    <td>
                        <input id="cwp_theme_options[offline]" name="cwp_theme_options[offline]" type="checkbox" value="1" <?php checked('1', cwp::theme_options('offline')); ?> />
                        <label class="description" for="cwp_theme_options[offline]"><?php _e('Go Offline', 'corewp'); ?></label>
                    </td>
                </tr>


                <?php
                /**
                 * Default pages
                 */
                ?>
                <tr valign="top"><th scope="row"><?php _e('Add default pages', 'corewp'); ?></th>
                    <td>
                        <input id="cwp_theme_options[defaultpages]" name="cwp_theme_options[defaultpages]" type="checkbox" value="1" <?php checked('1', cwp::theme_options('defaultpages')); ?> />
                        <label class="description" for="cwp_theme_options[defaultpages]">
                            <?php _e('Create default pages for theme', 'corewp'); ?></label>
                    </td>
                </tr>


                <?php
                /**
                 * Save options fro future use
                 */
                ?>
                <tr valign="top"><th scope="row"><?php _e('Save Theme Settings', 'corewp'); ?></th>
                    <td>
                        <input id="cwp_theme_options[saveoptions]" name="cwp_theme_options[saveoptions]" type="checkbox" value="1" <?php checked('1', cwp::theme_options('saveoptions')); ?> />
                        <label class="description" for="cwp_theme_options[saveoptions]">
                            <?php _e('Saves theme settings for future (re)use', 'corewp'); ?></label>
                    </td>
                </tr>







                <?php
                /**
                 * A theme admin select input option
                 */
                ?>
                <tr valign="top"><th scope="row"><?php _e('Select a Theme Admin', 'corewp'); ?></th>
                    <td>
                        <select name="cwp_theme_options[themeadmin]"  style="width: 200px">
                            <option></option>
                            <?php
                            $selected = cwp::theme_options('themeadmin');
                            $p = '';
                            $r = '';

                            //http://codex.wordpress.org/Function_Reference/get_users
                            $admins = get_users('blog_id=1&orderby=nicename&role=administrator');

                            foreach ($admins as $option) {
                                $label = $option->user_nicename;
                                if ($selected == $option->ID) // Make default first in list
                                    $p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr($option->ID) . "'>$label</option>";
                                else
                                    $r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr($option->ID) . "'>$label</option>";
                            }
                            echo $p . $r;
                            ?>
                        </select>
                        <label class="description" for="cwp_theme_options[selectinput]">
                            <?php _e('A Theme(s) admin user profile are used for themes socials links, contact info, about, etc', 'corewp'); ?></label>
                    </td>
                </tr>





                <?php
                /**
                 * A theme admin UI option
                 */
                ?>

<!--

                <tr valign="top"><th scope="row"><?php _e('Select the theme default Custom Option(s) ', 'corewp'); ?></th>
                    <td>
                        <?php if (post_type_exists('cwp_custom_options')) : ?>
                            <select name="cwp_theme_options[uidefault]" style="width: 200px">
                                <option></option>
                                <?php
                                $selected = cwp::theme_options('uidefault');
                                $p = '';
                                $r = '';

                                //http://codex.wordpress.org/Function_Reference/get_users



                                $options_q = query_posts(array('post_type' => 'cwp_custom_options',));


                                foreach ($options_q as $option) {
                                    $label = $option->post_title;
                                    if ($selected == $option->ID) // Make default first in list
                                        $p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr($option->ID) . "'>$label</option>";
                                    else
                                        $r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr($option->ID) . "'>$label</option>";
                                }
                                echo $p . $r;
                                wp_reset_postdata();
                                ?>
                            </select>
                            <label class="description" for="cwp_theme_options[selectinput]">
                                <?php _e('Select the default custom option for the theme UI, some options can be changed by', 'corewp'); ?></label>
                            <?php else : ?>
                            <?php $cwp_the_theme = wp_get_theme();
                            echo '<strong>Sorry theme ' . ucfirst($cwp_the_theme) . ', does not support Custom UI Options</strong>' ?>

                        <?php endif ?>
                    </td>
                </tr>-->


                <!--
                <?php
                /**
                 * A sample of radio buttons
                 */
                ?>
                                <tr valign="top"><th scope="row"><?php _e('Radio buttons', 'corewp'); ?></th>
                                    <td>
                                        <fieldset><legend class="screen-reader-text"><span><?php _e('Radio buttons', 'corewp'); ?></span></legend>
                <?php
                if (!isset($checked))
                    $checked = '';
                foreach ($radio_options as $option) {
                    $radio_setting = cwp::theme_options('radioinput');

                    if ('' != $radio_setting) {
                        if ($options['radioinput'] == $option['value']) {
                            $checked = "checked=\"checked\"";
                        } else {
                            $checked = '';
                        }
                    }
                    ?>
                                                        <label class="description"><input type="radio" name="cwp_theme_options[radioinput]" value="<?php esc_attr_e($option['value']); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label><br />
                    <?php
                }
                ?>
                                        </fieldset>
                                    </td>
                                </tr>
                -->
 <?php
                /**
                 * FBAPPID
                 */
                ?>

                <tr valign="top"><th scope="row"><?php _e('Facebook AppID', 'corewp'); ?></th>
                    <td>
                        <input id="cwp_theme_options[fbappid]" class="regular-text" type="text" name="cwp_theme_options[fbappid]" value="<?php esc_attr_e(cwp::theme_options('fbappid')); ?>" />
                        <label class="description" for="cwp_theme_options[fbappid]"><?php _e('Enter Facebook AppID', 'corewp'); ?></label>
                    </td>
                </tr>

                <?php
                /**
                 * Google analytice
                 */
                ?>

                <tr valign="top"><th scope="row"><?php _e('Analytics Key', 'corewp'); ?></th>
                    <td>
                        <input id="cwp_theme_options[gakey]" class="regular-text" type="text" name="cwp_theme_options[gakey]" value="<?php esc_attr_e(cwp::theme_options('gakey')); ?>" />
                        <label class="description" for="cwp_theme_options[gakey]"><?php _e('Enter your UA-XXXXX-X ID', 'corewp'); ?></label>
                    </td>
                </tr>




    <?php
    /**
     * Google search support
     */
    ?>
                <tr valign="top"><th scope="row"><?php _e('Google search box ', 'corewp'); ?></th>
                    <td>
                        <p>
                           <textarea id="cwp_theme_options[gsearchbox]" cols="100" rows="10" name="cwp_theme_options[gsearchbox]"><?php echo esc_textarea(cwp::theme_options('gsearchbox')); ?></textarea>
                        </p>
                        <label class="description" for="cwp_theme_options[gsearchbox]"><?php _e('Paste your Google search box code', 'corewp'); ?></label>
                    </td>
                </tr>


    <?php
    /**
     * Google search page integration
     *
     */
    ?>
                <tr valign="top"><th scope="row"><?php _e('Google search page', 'corewp'); ?></th>
                    <td>
                        <p>
                          <textarea id="cwp_theme_options[gsearchpage]" cols="100" rows="10" name="cwp_theme_options[gsearchpage]"><?php echo esc_textarea(cwp::theme_options('gsearchpage')); ?></textarea>
                        </p>

                        <label class="description" for="cwp_theme_options[gsearchpage]"><?php _e('Paste your Google search page code', 'corewp'); ?></label>
                    </td>
                </tr>


    <?php
    /**
     * Twitter
     *
     */
    ?>
                <tr valign="top"><th scope="row"><?php _e('Twitter Profile Widget', 'corewp'); ?></th>
                    <td>
                        <p>
                            <textarea id="cwp_theme_options[twitterwidget]" cols="100" rows="10" name="cwp_theme_options[twitterwidget]"> <?php echo esc_textarea(cwp::theme_options('twitterwidget')); ?></textarea>
                        </p>

                        <label class="description" for="cwp_theme_options[twitterwidget]"><?php _e('Paste your Twitter Profile Widget page code
                            <a href="https://twitter.com/about/resources/widgets/widget_profile" target="_blank">
                            https://twitter.com/about/resources/widgets/widget_profile</a>', 'corewp'); ?></label>
                    </td>
                </tr>



<!--       form         -->

            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Settings', 'corewp'); ?>" />
            </p>
        </form>

</div>

