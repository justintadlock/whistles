=== Whistles ===

Contributors: greenshady
Donate link: http://themehybrid.com/donate
Tags: widget, shortcode, jquery, tabs, toggle, accordion
Requires at least: 3.6
Tested up to: 3.7
Stable tag: 0.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tabs, toggles, accordions, and all that jazz. Bells and whistles done right.

== Description ==

Whistles was not born as "just another tabs plugin".  It was born out of the idea that we need to get rid of all other plugins like this and start from scratch.

It seems to me that tabs plugins have been clunky and extremely hard to use over the years.  Whistles seeks to rectify this by making it easy to manage tabs, toggles, accordions, and other things that need to be embedded into a page.

### So, what is Whistles? Are whistles? Can you whistle?

Whistles is a plugin that creates a new content type called "whistle" and a new taxonomy called "whistle group".  The plugin allows you to create individual whistles and organize them into whistle groups however you see fit.  Then, it allows you to embed whistle groups into posts using the `[whistles]` shortcode or adding it via the Whistles widget.

You can also decide how you want to display your whistles.  In the current version of the plugin, they can be displayed as:

* Tabs
* Toggles
* Accordions

The great thing about this method is that you're pretty much able to put whatever content you want into your whistles.  It's no different than writing a post or page.  You can insert text, images, media, and even other shortcodes.

### Features

* "Whistles" screen in the admin under "Appearance" for creating whistles.
* "Whistle Groups" screen in the admin under "Appearance" for organizing whistles.
* `[whistles]` shortcode for displaying whistles.
* "Add Whistles" media button above the post content editor for inserting whistles.
* "Whistles" widget under the "Appearance > Widgets" admin screen.

== Installation ==

1. Upload the `whistles` folder to your `/wp-content/plugins/` directory.
2. Activate the "Whistles" plugin through the "Plugins" menu in WordPress.
3. Visit "Appearance > Whistles" to create new whistles.

== Frequently Asked Questions ==

### Another tabs plugin?

I know what you're thinking.  But, I promise you this one is better.  It might not be the shiniest or the most glamorous, but it's the easiest for actual living, breathing human beings to use.  It's also probably the easiest to extend from a theme author point of view.  I call that a win+win.

### Why no look good with my theme?

With plugins like this, it's literally impossible for the plugin author to design something that will look good with every theme.  I actually created this plugin with theme authors in mind.  The code is extremely simple so that even the newest theme author could create custom styles for it.  Please ask your theme author to support this plugin in his or her theme.

### How do I customize the styles for this thing?

You can simply start overwriting styles via your theme's `style.css` file.

Or, you can put this within the theme setup function in your theme's `functions.php`:

	add_theme_support( 'whistles', array( 'styles' => true ) );

Then, copy the contents of this plugin's `/css/whistles.css` file into your active theme's `style.css` file.  You'll be in full control of the styles from that point forward.

### How do I overwrite the JavaScript?

This should go into your theme setup function within your theme's `functions.php`:

	add_theme_support( 'whistles', array( 'scripts' => true ) );

From that point, do your own thing.

### How do I modify...?

If there's anything else you want to customize, I'll assume you're a theme/plugin author at this point.  The code is well documented.  There are plenty of hooks.  Have at it!  I'm more than willing to help out with this on my [support forums](http://themehybrid.com/support) if you need the help.

### Can you help me?

Unfortunately, I cannot provide free support for this plugin to everyone.  I honestly wish I could.  My day job requires too much of my time for that, which is how I pay the bills and eat.  However, you can sign up for my [support forums](http://themehybrid.com/support) for full support of this plugin, all my other plugins, and all my themes for one price.

### Can you whistle?

Sure.  Can't everyone?  What a sad world it be without whistling.

== Screenshots ==

1. Add `[whistles]` shortcode media button popup
2. Manage Whistles admin screen
3. Accordions view
4. Tabs view
5. Toggles view

== Changelog ==

### Version 0.1.0

* Everything's new!