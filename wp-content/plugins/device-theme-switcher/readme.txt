=== Plugin Name ===
Plugin Name: Device Theme Switcher
Contributors: jamesmehorter
Donate Link: http://www.jamesmehorter.com/donate/
Tags: Theme, Switch, Change, Mobile, Mobile Theme, Handheld, Tablet, Tablet Theme, Different Themes, Device Theme
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: 1.6

Set an additional theme for handhelds and another for tablets

== Description ==

Device Theme Switcher creates a new page in your WordPress Admin; 'Appearance > Device Themes', where you can set one theme for handheld devices, and another theme for tablet devices. Normal computer visitors are given the active theme set in 'Appearance > Themes'. This plugin is esspecially helpful if you're a theme developer that wants to create 3 tailored versions of your theme. WordPress child themes are supported. 

'Handheld' devices include Android, BlackBerry, iPod, iPhone, Windows Mobile, and other various 'hand held' smart phones. 'Tablet' devices include iPad, Android tablets, Kindle Fire and other large-screen hand helds.

**Please let us know if you have any questions or find any bugs. You can contact us by posting a new topic on the forum on the right of this page. If you like our plugin please vote it up!**

== Screenshots ==

1. View of the Device Theme Switcher Window and options. 
2. View of the two widgets in action.

== Installation ==

1) Download and active. After activation you'll have a new menu under 'Appearance' titled 'Device Themes'.

2) Set your normal website theme as you usually do in 'Appearance > Themes'. Then set your handheld and tablet themes under the new 'Appearnace > Device Themes' page.

== Frequently Asked Questions ==

= How do I display a link in my handheld theme for users to "View Full Website"? =

This plugin creates two widgets for doing just that! Or you can use the template tags below.

To display a link for users to "View the full website" place the following anywhere in your handheld and tablet themes.
`<?php if (class_exists('Device_Theme_Switcher')) : Device_Theme_Switcher::generate_link_to_full_website(); endif; ?>`

To display a link for users to "Return to the mobile website" place the following anywhere in your default/active website theme.
`<?php if (class_exists('Device_Theme_Switcher')) : Device_Theme_Switcher::generate_link_back_to_mobile(); endif; ?>`

The users chosen theme is stored in a PHP Session, so the user can browse around your website prior to clicking 'Return to mobile website'. You can use the theme links anywhere in your themes, like in header.php or footer.php. 

= How do I style the widget or template tag output?? =

Device Theme Switcher really just echo's an html anchor tag. Both links have a CSS class of 'dts-link'. The 'View Full Website' anchor tag also has a class of 'to-full-website' and the 'Return to the Mobile Website' link has an additional class of 'back-to-mobile' so you can style the link differently if you want

*Styling Example*
`.dts-link {
    font-size: 1.5em ;
}
    .dts-link.to-full-website {
        color: red ;
    }
    .dts-link.back-to-mobile {
    	color: blue ;
    }`

== Changelog ==

= Version 1.6 =
* Updated the plugin to use the new Theme API within WordPress 3.4
* Updated MobileESP Library to the latest verion (April 23, 2012) which adds support for BlackBerry Curve Touch, e-Ink Kindle, and Kindle Fire in Silk mode. And fixed many other bugs. 
* Updated the Device Theme Switcher widgets so they only display to the devices they should, e.g. The 'View Full Website' widget will only display in the handheld theme. 
* Revised readme language and added a WordPress Plugin Repository banner graphic. 

= Version 1.5 =
* Modified the way themes are deliveried so the process is more stable for users with odd WordPress setups, by detecting where their theme folders are located instead of assuming wp-content/themes

= Version 1.4 =
* Updated to the latest version of the MobileESP library which now detects some newer phones like the BlackBerry Bold Touch (9900 and 9930)

= Version 1.3 =
* Changed the admin page to submit to admin_url() for those who have changed /wp-admin/ 
* Added a warning suppresor to session_start() in case another plugin has already called it
* Updated language in the WordPress readme file

= Version 1.2 =
* Added the handheld and tablet theme choices to the WordPress Dashboard Right Now panel
* Update both GitHub and WordPress readme files to be better styled and versed
* Added two wigets for users to put in their themes
* Coding and efficiency improvments

= Version 1.1 =
* Bug fixes
* Efficency improvements
    
= Version 1.0 =
* First Public Stable Release
    
== Upgrade Notice ==

Auto Updating this plugin is OK. Your saved settings for this plugin will never be changed when updating. You can even deactivate / reactivate this plugin without ever losing those settings. Deleteing the plugin correctly (from within the Admin > Plugins page) is the only way to remove the plugin settings. 

== Credits ==

This plugin is powered by the MobileESP PHP library created by Anthony Hand (http://code.google.com/p/mobileesp/). 

This plugin is based on the concepts provided by Jonas Vorwerk's (http://www.jonasvorwerk.com/) Mobile theme switcher plugin, and Jeremy Arntz's (http://www.jeremyarntz.com/) Mobile Theme Switcher plugin. 

Copyright (C) 2011 James Mehorter