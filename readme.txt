=== Plugin Name ===
Contributors: lpointet
Tags: admin, help, tutorial, scenario, pointers
Requires at least: 3.3.0
Tested up to: 3.4
Stable tag: 1.0
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

== Changelog ==

= 1.0 =
* First release of the plugin

== API ==

# API
WordPress GPS provides some hooks to plugin writers:

* a filter to add, remove or order the default scenarios (_gb\_gps\_default\_scenarios_)
* a class to create a new "pointer": GBGPS_Pointer
* a single function to register a new scenario: _gb\_gps\_register\_scenario_

## GBGPS_Pointer

### Usage

    $pointer_config = array(  
        'selector' => '#menu-posts',  
        'content' => '<h3>title</h3><p>content</p>',  
        'position' => array(  
            'edge' => 'top',  
            'align' => 'right',  
        ),  
    );

    $pointer = new GBGPS_Pointer($pointer_config);

### Parameters

**selector**  
    (string) The DOM selector of the element on which the pointer will be attached.  
      Default: ''

**content**  
    (string) The content of the pointer.  
      Default: ''

**position**
    (array) An array of arguments to pass to a jQuery UI Position Widget (see the documentation: http://jqueryui.com/demos/position/#options).

## gb\_gps\_register\_scenario

### Usage

    $args = array(  
        'pointers' => $pointers,  
        'label' => $label,  
        'description' => $description,  
        'capabilities' => array('edit_post'),  
    );

    gb_gps_register_scenario($args);

### Parameters

**pointers**  
    (array) An array of GBGPS\_Pointer with this structure: [ 'hook' => [ $pointer\_obj, $pointer\_obj2 ], 'hook2' => [ $pointer\_obj3 ] ], where "hook" is typically the script's name on the WordPress admin ('edit.php') or the keyword "all".

**label**  
    (string) The scenario label, which will appear on the select box.

**description**  
    (string) The scenario description, which will appear on the admin panel.

**capabilities**  
    (array) An array of capabilities as defined by WordPress or even plugins ('edit_post' for example).