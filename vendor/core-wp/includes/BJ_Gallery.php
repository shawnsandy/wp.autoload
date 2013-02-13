<?php
/**
 * The file description. *
 * @package BJ
 * @since BJ 1.0
 */

/**
 * Adds gallery to your posts
 * based on otto's photo gallery primer
 * @link http://ottopress.com/2011/photo-gallery-primer/
 * @example
 * <code>
  //load the gallery using a factory patern
  $bj_gallery = BJ_Gallery::factory();
  //set_ID if not in loop
  //set the number of thumbnails
  //set the theme thumbnail size and displays the thumbnails
  $bj_gallery->set_ID(478)
  ->set_post_per_page(3)
  ->thumbnails('thumbnail');
 * </code>
 */
class BJ_Gallery {

    private $ID = null,
            $order = 'ASC',
            $total_thumbnails,
            $post_type = 'post',
            $template_slug = 'gallery',
            $post_per_page = 4,
            $template_name;

    public function set_template_name($template_name) {
        $this->template_name = $template_name;
        return $this;
    }

    public function set_template_slug($template_slug) {
        $this->template_slug = $template_slug;
        return $this;
    }

    public function set_post_per_page($post_per_page) {
        $this->post_per_page = $post_per_page;
        return $this;
    }

    public function get_post_type() {
        return $this->post_type;
    }

    public function set_post_type($post_type) {
        $this->post_type = $post_type;
    }

    public function set_ID($ID) {
        $this->ID = $ID;
        return $this;
    }

    public function set_order($order) {
        $this->order = $order;
        return $this;
    }

    public function set_total_thumbnails($total_thumbnails) {
        $this->total_thumbnails = $total_thumbnails;
        return $this;
    }

    public function get_total_thumbnails() {
        return $this->total_thumbnails;
    }

    function __construct() {
        //parent::__construct();
        $this->set_template_slug('gallery');
    }

    public static function factory($template_slug = 'gallery', $post_per_page = 4) {
        $factory = new BJ_Gallery();
        $factory->set_template_slug($template_slug);
        $factory->set_post_per_page($post_per_page);
        return $factory;
    }

    public function gallery_thumbnails() {

        global $post;

        //if $ID NULL use the global post->ID
        if (!isset($this->ID))
            $this->ID = $post->ID;
        //get the post thumbnail ID
        $thumb_id = get_post_thumbnail_id($this->ID);
        //image query
        $images = new WP_Query(array(
                    'post_parent' => $this->ID,
                    'post_status' => 'inherit',
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'order' => $this->order,
                    'orderby' => 'menu_order ID',
                    'posts_per_page' => $this->post_per_page,
                    'post__not_in' => array($thumb_id),
                    'update_post_term_cache' => false,
                ));

        $imagedata = $images->posts;
        $this->total_thumbnails = $images->found_posts + 1;
        return $imagedata;
    }

    public function gallery() {

        global $post;

        //if $ID NULL use the global post->ID
        if (!isset($this->ID))
            $this->ID = $post->ID;
        //get the post thumbnail ID
        $thumb_id = get_post_thumbnail_id($this->ID);
        //image query
        $images = new WP_Query(array(
                    'post_parent' => $this->ID,
                    'post_status' => 'inherit',
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'order' => $this->order,
                    'orderby' => 'menu_order ID',
                    'posts_per_page' => $this->post_per_page,
                    'post__not_in' => array($thumb_id),
                    'update_post_term_cache' => false,
                ));

        if($images->have_posts()):
            while($images->have_posts()):
            $images->the_post();
            bj_layout::get_template_part($this->template_slug, $this->template_name);
            endwhile;
        endif;
    }

    /**
     * Display thumbnails from your gallery that links to full size image
     * @param string $thumbnail_size
     * @param string $class_name - css class for figure element
     */
    public function thumbnails($thumbnail_size = 'gallery-tumbnail', $link = null) {
        /*
         * @todo make link dynamic
         */

        $images = $this->gallery_thumbnails();
        foreach ($images as $image) {
            echo '<figure class="gallery-thumbnail"><a href="' . get_permalink($image->post_parent) . '">' . wp_get_attachment_image($image->ID, $thumbnail_size) . '</a></figure>';
        }
    }

    /**
     * Display thumbnails from your gallery that links to full size image
     * Uses twitter bootstrap thumbnails markup
     * @param string $thumbnail_size
     * @param string $colunm_span span4
     */
    public function thumbnail_gallery($thumbnail_size = 'gallery-tumbnail', $colunm_span = 'span4') {
        $images = $this->gallery_thumbnails();
        ?>
        <div class="row">
            <div class="span12">
                <ul class="thumbnails">
                    <li class="<?php echo $colunm_span ?>">
                        <div class="thumbnail">
                            <?php
                            foreach ($images as $image) {
                                echo '<figure class="gallery-thumbnail"><a href="' . get_permalink($image->ID) . '">' . wp_get_attachment_image($image->ID, $thumbnail_size) . '</a></figure>';
                                ?>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- ###### -->

            </div>
            <!-- ###### -->
            <?php
        }
    }

    /**
     *
     * @global type $post
     * @param type $ID
     * @param type $thumbnail_size
     * @param type $prev
     * @param type $next
     */
    public function carousel($ID = null, $thumbnail_size = 'medium', $prev = '<', $next = '>') {
        $images = $this->gallery_thumbnails();

        global $post;
        if (!isset($ID))
            $ID = $post->ID;

        add_action('wp_footer', array($this, 'gallery_carousel'));
        ?>
        <div id="bj-carousel" class="carousel slide">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="" alt="">
                    <p><?php echo get_the_post_thumbnail($ID, $thumbnail_size); ?></p>
                </div>
        <?php foreach ($images as $image): ?>
                    <div class="item">
                        <figure class="gallery-thumbnail">
            <?php echo wp_get_attachment_image($image->ID, $thumbnail_size); ?>
                        </figure>
                        <p class="imgage-caption">
            <?php echo wp_trim_words($image->post_excerpt, 30) ?>
                        </p>
                    </div>
        <?php endforeach; ?>

            </div>
            <a class="left carousel-control" href="#bj-carousel" data-slide="prev"><?php echo $prev ?></a>
            <a class="right carousel-control" href="#bj-carousel" data-slide="next"><?php echo $next ?></a>
        </div>
        <?php
    }

    public function gallery_carousel() {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $('.carousel').carousel();
            })
        </script>
        <?php
    }

    /**
     * Get exif data from photos
     * @global type $post
     * @param string $exif_info default is camera
     * @param type $post_id
     * @return type
     */
    public function exif_data($exif_info = 'camera', $post_id = null) {

        global $post;

        if (!isset($post_id))
            $post_id = $post->ID;

        $imagemeta = wp_get_attachment_metadata($post_id);

        if (empty($imagemeta))
            return;

        if ($exif_info == 'shutter_speed'):
            // shutter speed handler
            if ((1 / $imagemeta['image_meta']['shutter_speed']) > 1) {
                echo "1/";
                if (number_format((1 / $imagemeta['image_meta']['shutter_speed']), 1) == number_format((1 / $imagemeta['image_meta']['shutter_speed']), 0)) {
                    echo number_format((1 / $imagemeta['image_meta']['shutter_speed']), 0, '.', '') . ' sec';
                } else {
                    return number_format((1 / $imagemeta['image_meta']['shutter_speed']), 1, '.', '') . ' sec';
                }
            } else {
                return $imagemeta['image_meta']['shutter_speed'] . ' sec';
            }

        else:
            return $imagemeta['image_meta']["{$exif_info}"];
        endif;
    }

    /**
     * Displays the photo exif data in your theme
     * @param type $post_id
     */
    public function display_exif($post_id = null) {
        ?>
        <span class="exif created">Created: <?php echo date("d-M-Y", $this->exif_data('created_timestamp', $post_id)); ?></span>
        <span class="exif camera">Camera: <?php echo $this->exif_data('camera', $post_id) ?></span>
        <span class="exif focal-length">Focal Length: <?php echo $this->exif_data('focal_length', $post_id) ?></span>
        <span class="exif aperture">Aperture: <?php echo $this->exif_data('aperture', $post_id) ?></span>
        <span class="exif iso">ISO: <?php echo $this->exif_data('iso', $post_id) ?></span>
        <span class="exif shutter-speed">Shutter Speed: <?php echo $this->exif_data('shutter_speed', $post_id) ?></span>
        <?php
    }

    /**
     * Creates a loop for post-format-gallery / category gallery on gallery page(s)
     * @global type $query_string
     */
    public function gallery_loop() {
        //make sure the query string is available
        global $query_string;

        $args = wp_parse_args($query_string);

        $query = array(
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'post_format',
                    'terms' => array('post-format-gallery'),
                    'field' => 'slug',
                ),
                array(
                    'taxonomy' => 'category',
                    'terms' => array('gallery'),
                    'field' => 'slug',
                ),
            ),
            'paged' => $args['paged'],
            'post_type' => $this->post_type,
        );

        $this->set_query($query);

        $this->loop();
    }

}
