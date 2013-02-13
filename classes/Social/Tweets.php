<?php

/**
 * Description of Twitter
 *
 * @author studio
 */
class Social_Tweets {

    private $username = 'WordPress',
            $api_request_url = null,
            $transient_name = 'al-tweet-list',
            $api_url = 'https://api.twitter.com/1/statuses/',
            $trans_lifetime = 60,
            $tweet_count = 5,
            $tweets,
            $cacheTime = 5;

    public function get_api_request_url() {
        return $this->api_request_url;
    }

    public function get_api_url() {
        return $this->api_url;
    }

    function __construct() {

    }

    public function get_tweets() {
        return $this->tweets;
    }

    public function set_tweets($tweets) {
        $this->tweets = $tweets;
    }

    public function set_username($username) {
        $this->username = $username;
        return $this;
    }

    public function set_api_request_url($query_string) {
        $this->api_request_url = $query_string;
        return $this;
    }

    public function set_transient_name($transient_name) {
        $this->transient_name = $transient_name;
        return $this;
    }

    public function set_api_url($api_url) {
        $this->api_url = $api_url;
        return $this;
    }

    public function set_trans_lifetime($trans_lifetime) {
        $this->trans_lifetime = $trans_lifetime;
        return $this;
    }

    public function set_tweet_count($tweet_count) {
        $this->tweet_count = $tweet_count;
        return $this;
    }

    public static function factory() {
        $factory = new Social_Tweets();
        return $factory;
    }

    public function load_tweets() {
        /**
         * @link http://www.problogdesign.com/wordpress/how-to-use-the-twitter-api-in-wordpress/ source / credits
         */
        // Do we already have saved tweet data? If not, lets get it.

        if (false === ( $this->tweets = get_transient($this->transient_name) )) :

            // Get the tweets from Twitter.
            $url = $this->api_request_url;
            $response = wp_remote_get($url);
//              $response = wp_remote_get("http://api.twitter.com/1/statuses/user_timeline.json?screen_name=WordPress&count=5&exclude_replies=false");
            // If we didn't find tweets, use the previously stored values.
            if (!is_wp_error($response) && $response['response']['code'] == 200) :
                // Get tweets into an array.
                //$tweets_json = json_decode($response['body'], true);
                $this->tweets = json_decode($response['body'], true);

                // Now update the array to store just what we need.
                // (Done here instead of PHP doing this for every page load)
                foreach ($this->tweets as $tweet) :
                    // Core info.
                    $name = $tweet['user']['name'];
                    $permalink = 'http://twitter.com/#!/' . $name . '/status/' . $tweet['id_str'];

                    /* Alternative image sizes method: http://dev.twitter.com/doc/get/users/profile_image/:screen_name */
                    $image = $tweet['user']['profile_image_url'];

                    // Message. Convert links to real links.
                    $pattern = '/http:(\S)+/';
                    $replace = '<a href="${0}" target="_blank" rel="nofollow">${0}</a>';
                    $text = preg_replace($pattern, $replace, $tweet['text']);

                    // Need to get time in Unix format.
                    $time = $tweet['created_at'];
                    $time = date_parse($time);
                    $uTime = mktime($time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year']);

                    // Now make the new array.
                    $tweets[] = array(
                        'text' => $text,
                        'name' => $name,
                        'permalink' => $permalink,
                        'image' => $image,
                        'time' => $uTime
                    );
                endforeach;

                // Save our new transient, and update the backup.
                set_transient($this->transient_name, $tweets, $this->trans_lifetime * $this->cacheTime);
                update_option('backup-' . $this->transient_name, $tweets);


            else : // i.e. Fetching new tweets failed.
                $this->tweets = get_option('backup-' . $this->transient_name); // False if there has never been data saved.
            endif;
        endif;
        return $this;
    }

    public function display_tweets() {

        //load up tweets
        $this->load_tweets();

        ob_start();
        if ($this->tweets) :
            ?>
            <ul class="bj-tweets">
            <?php foreach ($this->tweets as $tweet) : ?>
                    <li>
                        <a href="http://twitter.com/#!/<?php echo $tweet['name']; ?>" target="_blank">
                            <img src="<?php echo $tweet['image']; ?>" width="48" height="48" alt="" />
                        </a>
                        <div class="tweet-inner">
                            <p>
                <?php echo $tweet['name'] . ': ' . $tweet['text']; ?>
                                <span class="tweet-time"><?php echo human_time_diff($tweet['time'], current_time('timestamp')); ?> ago</span>
                            </p>
                        </div><!-- /tweet-inner -->
                    </li>
            <?php endforeach; ?>
            </ul>
            <?php else : ?>
            <p>Sorry no tweets found.</p>
        <?php endif; ?>

        <?php
        $tweets = ob_get_clean();
        return $tweets;
    }

    /**
     *
     * @param type $user
     * @param type $tweet_count
     * @param type $retweets
     */
    public static function show_tweets($user = null, $tweet_count = 5, $retweets = false) {
        if (!isset($user))
            $user = 'WordPress';
        $my_tweets = self::factory()
                ->set_transient_name($user . '-tweets')
                ->set_api_request_url('http://api.twitter.com/1/statuses/user_timeline.json?count=' . $tweet_count . '&screen_name=' . $user . '&include_rts=' . $retweets . 'false')
                ->load_tweets();
        echo $my_tweets->display_tweets();
    }

}