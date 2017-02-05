=== Plugin Name ===
Contributors: lpointet
Tags: admin, help, tutorial, scenario, pointers, backend, plugin, training
Requires at least: 3.3.0
Tested up to: 4.7.2
Stable tag: 1.0.16
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Help people navigate through the WordPress backend thanks to the pretty WordPress Pointers.

== Description ==

# About this plugin
WordPress GPS tries to guide people throughout the WordPress admin jungle. Tell it what you want to do and let it show you the way, with the pretty WP Pointers feature.

# Features
This plugin provides an admin panel with a scenario selection. It comes with some default scenarios, which will teach you for example how to:

* add a new post
* add a media
* add an user
* ...

Each scenario is defined with capabilities the user must have to play it: if the user doesn't have these capabilities, the scenario won't be in the select box.

WordPress GPS is available on Github: https://github.com/lpointet/WordPress-GPS
Please feel free to send me pull requests, issues, evolution requests etc.

== Installation ==

1. Install WordPress GPS either via your 'Plugins' menu, or by uploading the files to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the 'GPS' menu and launch the scenario you want

== Frequently Asked Questions ==

= Is this possible to add scenarios to the existing ones? =

Of course it is, but only through the API for now.

== Screenshots ==

1. Choose the scenario you want to launch from its name and a little description
2. Follow the pointers!

== Changelog ==

= 1.0.16 =
* Fix typo in plugin description
* Add i18n headers (still for GlotPress translation)

= 1.0.15 =
* Try to enable GlotPress translation

= 1.0.14 =
* Fix old class names
* Fix old way to position pointers (offset)

= 1.0.13 =
* Removed useless capability check for displaying admin menu / props colouro
* Allow a pointer to be post_type specific / props colouro

= 1.0.11 =
* Added one more scenario : (de-)activate a plugin
* Updated POT file
* Updated French translations

= 1.0.10 =
* Fixed textdomain name & set English as default language

= 1.0.9 =
* Refactored pointers processing to be more concise in JS #WebPerf

= 1.0.8 =
* Fixed a bug with the POST requests checks that implied the whole admin was blocked

= 1.0.7 =
* Avoid a PHP Notice on admin POST requests

= 1.0.6 =
* Decommented a line commented for debug purposes...

= 1.0.5 =
* Replaced the WP banner at the right place

= 1.0.4 =
* Added some images (screenshots + WP banner)

= 1.0.3 =
* Updated the version number to display in the WordPress Extend "Download" button

= 1.0.2 =
* Added a function to the API to be more consistent
* Updated Docs

= 1.0 =
* First release of the plugin

== API ==

WordPress GPS provides some hooks to plugin writers:

* a filter to add, remove or order the default scenarios (_gb\_gps\_default\_scenarios_)
* a function to create a new "pointer": gb\_gps\_create\_pointer
* a single function to register a new scenario: _gb\_gps\_register\_scenario_

# gb\_gps\_create\_pointer

## Usage

    $pointer_config = array(
        'selector' => '#menu-posts',
        'content' => '<h3>title</h3><p>content</p>',
        'position' => array(
            'edge' => 'top',
            'align' => 'right',
        ),
    );

    $pointer = gb_gps_create_pointer($pointer_config);

## Parameters

**selector**
    (string) The DOM selector of the element on which the pointer will be attached.
      Default: ''

**content**
    (string) The content of the pointer.
      Default: ''

**position**
    (array) An array of arguments to pass to a jQuery UI Position Widget (see the documentation: http://jqueryui.com/demos/position/#options).

# gb\_gps\_register\_scenario

## Usage

    $args = array(
        'pointers' => $pointers,
        'label' => $label,
        'description' => $description,
        'capabilities' => array('edit_post'),
    );

    gb_gps_register_scenario($args);

## Parameters

**pointers**
    (array) An array of GBGPS\_Pointer with this structure: [ 'hook' => [ $pointer\_obj, $pointer\_obj2 ], 'hook2' => [ $pointer\_obj3 ] ], where "hook" is typically the script's name on the WordPress admin ('edit.php') or the keyword "all".

**label**
    (string) The scenario label, which will appear on the select box.

**description**
    (string) The scenario description, which will appear on the admin panel.

**capabilities**
    (array) An array of capabilities as defined by WordPress or even plugins ('edit_post' for example).