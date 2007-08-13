=== Site-Thumb ===
Tags: Website, Thumbnail, images, artViper
Current Version: 1.0 (initial version)
Contributors: Kay-Rules
Requires at least: 2.0
Tested up to: 2.2.1

For an up-to-date help and info, go to the plugin-help page: 
* http://digxy.com/blog/wp-plugins/site-thumb/

== Description ==

Site-Thumb enables you to display website thumbnail in your posts. Using artViper desigstudio website thumbnail as the default generator. However, you may also use your favourite generator.

== Features ==

1. Dynamically display website thumbnail which generated from 3rd party online thumbnail generator
2. Using artViper designstudio website thumbnail as the default generator which is FREE
3. Can be customized to use other online thumbnail generator
4. Support Cascading Style Sheet (CSS) for advanced style on displaying thumbnail

== Installation ==

1. Download the latest .zip package from http://www.digxy.com/blog/site-thumb/
2. Extract the package and put the /sitethumb/ folder into [wordpress_dir]/wp-content/plugins/
3. Go into the WordPress admin interface and activate the plugin

== Configuration ==
1. You may change Site-Thumb setting from `Options > Site-Thumb` menu 
2. Below are the details for each field
   * Thumbnail Generator	- URL address for the thumbnail generator (required)
							- Must use `{SITE}` tag for Site-Thumb to parse the website URL
   * Image Alt / Title		- Alternate Text for the image
   * Style					- Set your own CSS Style for the thumbnail images
   							- To enable this feature, make sure `wp_head()` function is triggered within the <head></head> section of your theme or you could just add one in `/[your_theme]/header.php`

== Frequently Asked Questions ==
= N/A =