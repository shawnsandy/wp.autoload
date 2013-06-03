=== AL-Manager (WP.Autoload) ===
Contributors: shawnsandy.com
Donate link: http://autoloadmanger.shawnandy.com
Tags: autoload, OOP,
Requires at least: 3.0
Tested up to: 3.5
Stable tag: trunk

WP.Autoload (formerly PHP Autoload Manager) was created to allow me to easily extend the power of WordPress by using PHP’s autoload function to quickly add and use PHP classes / libraries in my WordPress projects without having to add tons of file include lines!

== Description ==

It’s a… Beta! It may not have taken nine months but I’m just as happy that it’s here; WP.Autoload V2.0 beta is now available on Github. Version 2.0 main focus was :

Improve auto loading functionality, speed and efficiency.
Offer multiple options for autoloading classes.
Encourage a WordPress (PHP 5.2) compliant naming standards Based on the Pear / Zend Framework conventions when / wherever possible.
Develop and create apps / tools that demonstrate and encourage developers to use and embrace object oriented php in WordPress.
The WP.Autoload class was added to help improve and provide additional options for effectively loading classes into projects. It uses the Zend Framework naming conventions for PHP classes to encourage the use PSR-0 compliant standards for classes.

I have also added several Modules and Components :

* Query : The Post_Query class is a part of the Post component kit, it allows you to quickly access and use WordPress WP_Query function to create custom WordPress queries.

`Post_Query::factory()->set_template_slug('tpl/views/cover')->query(array('posts_per_page' => 3, 'category_name' => 'al-manager,vendor,plugins,general'));`

* CustomType : The CustomType post-component significantly reduces the time spent creating and coding custom post types it is simple and easy to use, yet flexible enough to allow you customize your CPT(s) if you chose all without the downside of a plugin.

`Post_CustomTypes::factory('indie_shop')->register_post_type("My Shop");`

* Pointers : As like our other components Admin_Pointers makes it easy to use pointers in your themes and plugins, please use sparingly pointers are meant to guide not decorate.

`/** Updated method */
Admin_Pointers::factory('test_01','#menu-plugins')
         ->add_pointer(__('Test Pointer','textdomain),__('Hello I am a pointer this is easy to do!','textdomian'));`

* AdminBar : Adminbar_PostMenus creates links to post, pages and custom post_types for easy content navigation and editing.

`/**
 * Customize your Adminbar Post Menus
 *
 */
function apm_menus() {

    //create an post_type array(post_type, menu_title);
    $post_types  =  array('post' => 'Posts', 'page' => 'Pages','cwp_article' => 'Articles','cwp_faq' => "FAQ(s)");

    Adminbar_PostMenus::factory()->set_post_types($post_types)->create_nodes();

}
// run the function on init;

add_action('init', 'apm_menus');`

* More to come...

These provide working examples of some of the benefits of using object oriented programming in WordPress projects.

All the major bases have been covered as regards to the goals of V2.0, the beta has been switched to a new Github repository https://github.com/shawnsandy/wp.autoload and the website has been given a makeover for good measure.

== Installation ==
1. Install/Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

= Autoloading you classes =

Autoloading V2.0
In V2.0 the autoloading process is a lot more ubiquitous allowing developers to create and use any class that follows the Zend Framework naming conventions.

From now on classes meant to use WP.Autoload will start with the vendor, theme, library or plugin name as the root directory with an underscore following / separating each subsequent directory followed by the class name. Filenames will be given the class-name with ‘.php’ extension.

Now theme or plugin developers only need to ensure that classes follow these simple naming conventions :

Vendor_Folder_Class.php and filename would be Classname.php

The directory structure should look like this \Vendor\Folder\Classname.php

For example if you had a class named Hello stored in a classes folder in your plugin your class would be named — MyPlugin_Classes_Hello, the file would be Hello.php and your directory structure would look like this – \MyPlugin\Classes\Hello.php. The same would apply for themes.

Remember the naming conventions are whats important here, follow them an you will be safe.

Once you get that all you need to do is call instantiate your class :

$hello = new Hello();
$hello->say_hello();
I will add a more detailed tutorial soon, for now you can leave your thoughts and suggestions in the comments below.


== Screenshots ==

1. Post Query
2. Adminbar Component
3. Admin Pointers
4. Tweets
5. CustomTypes

== Frequently Asked Questions ==

= Why autoloading =

Many developers writing object-oriented applications create one PHP source file per class definition. One of the biggest annoyances is having to write a long list of needed includes at the beginning of each script (one for each class). In PHP 5, this is no longer necessary. You may define an __autoload() function which is automatically called in case you are trying to use a class/interface which hasn’t been defined yet. By calling this function the scripting engine is given a last chance to load the class before PHP fails with an error http://php.net/manual/en/language.oop5.autoload.php.


== Changelog ==

= 2.0 =
Plugin Renamed - WP.Autoload
Improve auto loading functionality, speed and efficiency.
Multiple options for autoloading classes
Encourage a WordPress (PHP 5.2) compliant naming standards for classes based on the PSR-0 when / wherever possible
Develop and create apps / tools that demonstrate and encourage developers to use and embrace object oriented php in WordPress.

= 0.1 Beta =

== Upgrade Notice ==

= 0.1 =

First release

== Arbitrary section ==

