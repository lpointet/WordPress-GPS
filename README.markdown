(French version at the bottom / Version française en bas)

# About this plugin
WordPress GPS tries to guide people throughout the WordPress admin jungle. Tell it what you want to do and let it show you the way, with the pretty WP Pointers feature.

# Features
This plugin provides an admin panel with a scenario selection. It comes with some default scenarios, which will teach you for example how to:

* add a new post
* add a media
* add an user
* ...

Each scenario is defined with capabilities the user must have to play it: if the user doesn't have these capabilities, the scenario won't be in the select box.

# API
WordPress GPS provides some hooks to plugin writers:

* a filter to add, remove or order the default scenarios (_gb\_gps\_default\_scenarios_)
* a function to create a new "pointer": gb\_gps\_create\_pointer
* a single function to register a new scenario: _gb\_gps\_register\_scenario_

## gb\_gps\_create\_pointer

### Usage

    $pointer_config = array(
        'selector' => '#menu-posts',
        'post_type' => 'post',
        'content' => '<h3>title</h3><p>content</p>',
        'position' => array(
            'edge' => 'top',
            'align' => 'right',
        ),
    );

    $pointer = gb_gps_create_pointer($pointer_config);

### Parameters

**selector**
    (string) The DOM selector of the element on which the pointer will be attached.
      Default: ''

**post_type**
    (string) The post type slug differenciating some screens on which the pointer will be attached. For example, 'edit.php' hook could be on 'post' or 'page' post types.
      Default: '' (every post types)

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


# Contribute
Please feel free to send me pull requests, issues, evolution requests etc.

[Français]

# A propos de ce plugin
WordPress GPS essaie de guider les utilisateurs à travers la jungle de l'administration de WordPress. Dites-lui ce que vous souhaitez faire et laissez-le vous montrer le chemin, grâce à la jolie fonctionnalité des WP Pointers.

# Fonctionnalités
Ce plugin propose un panneau d'admin contenant une sélection de scénario. Il vient avec quelques scénarios par défaut, qui vont vous apprendre par exemple à :

* ajouter un nouvel article
* ajouter un média
* ajouter un utilisateur
* ...

Chaque scénario est défini avec des "capacités" que l'utilisateur doit avoir pour le jouer : si l'utilisateur n'a pas ces "capacités", le scénario n'apparaîtra pas dans la boîte de sélection.

# API
WordPress GPS propose quelques hooks pour les développeurs de plugin :

* un filtre pour ajouter, supprimer ou ordonner les scénarios par défaut (_gb\_gps\_default\_scenarios_)
* une fonction pour créer un nouveau "pointer" : gb\_gps\_create\_pointer
* une simple fonction pour enregistrer un nouveau scénario : _gb\_gps\_register\_scenario_

## gb\_gps\_create\_pointer

### Utilisation

    $pointer_config = array(
        'selector' => '#menu-posts',
        'post_type' => 'post',
        'content' => '<h3>titre</h3><p>contenu</p>',
        'position' => array(
            'edge' => 'top',
            'align' => 'right',
        ),
    );

    $pointer = gb_gps_create_pointer($pointer_config);

### Paramètres

**selector**
    (string) Le sélecteur DOM de l'élément sur lequel va être attaché le pointer.
      Par défaut : ''

**post_type**
    (string) Le slug du post type différenciant plusieurs écrans. Par exemple, le hook 'edit.php' peut être sur les post types 'post' ou 'page'.
      Par défaut : '' (tous les pos types)

**content**
    (string) Le contenu du pointer.
      Par défaut : ''

**position**
    (array) Un tableau d'arguments à passer à un Widget jQuery UI Position (cf. la documentation officielle : http://jqueryui.com/demos/position/#options).

## gb\_gps\_register\_scenario

### Utilisation

    $args = array(
        'pointers' => $pointers,
        'label' => $label,
        'description' => $description,
        'capabilities' => array('edit_post'),
    );

    gb_gps_register_scenario($args);

### Paramètres

**pointers**
    (array) Un tableau d'objets GBGPS\_Pointer avec la structure suivante : [ 'hook' => [ $pointer\_obj, $pointer\_obj2 ], 'hook2' => [ $pointer\_obj3 ] ], où "hook" est généralement le nom du script sur l'administration de WordPress ou le mot-clé "all".

**label**
    (string) Le libellé du scénario, qui apparaîtra dans la boîte de sélection.

**description**
    (string) La description du scénario, qui apparaîtra sur le panneau d'administration.

**capabilities**
    (array) Un tableau de "capacités" comme définies par WordPress ou même par des plugins ('edit_post' par exemple).

# Contribuez
N'hésitez pas à m'envoyer des pull requests, des problèmes rencontrés, des demandes d'évolution etc.