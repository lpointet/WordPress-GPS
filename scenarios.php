<?php
// Default scenarios
$scenarios = array(
    // Add a post
    'gb_gps_add_post_scenario' => array(
        'label' => GB_GPS_ADD_POST_SCENARIO_LABEL,
        'description' => GB_GPS_ADD_POST_SCENARIO_DESCRIPTION,
        'capabilities' => array('edit_posts'),
        'pointers' => array(
            // Hook
            'all' => array(
                // Pointers
                array(
                    'selector' => '#menu-posts',
                    'content' => '<h3>' . sprintf(GB_GPS_MENU_POINTER_TITLE, __('Posts')) . '</h3><p>' . sprintf(GB_GPS_MENU_POINTER_CONTENT, __('Posts'), __('posts')) . '</p>',
                    'position' => array(
                        'edge' => 'top',
                        'align' => 'right',
                    ),
                ),
            ),
            'edit.php' => array(
                array(
                    'selector' => '.add-new-h2',
                    'content' => '<h3>' . GB_GPS_ADD_FROM_LIST_POINTER_TITLE . '</h3><p>' . sprintf(GB_GPS_ADD_FROM_LIST_POINTER_CONTENT, __('post')) . '</p>',
                    'position' => array(
                        'edge' => 'top',
                        'offset' => '-40 0',
                    ),
                ),
            ),
        ),
    ),
    // Set a category to a post
    'gb_gps_add_cat_to_post' => array(
        'label' => GB_GPS_ADD_CAT_TO_POST_SCENARIO_LABEL,
        'description' => GB_GPS_ADD_CAT_TO_POST_SCENARIO_DESCRIPTION,
        'capabilities' => array('edit_posts'),
        'pointers' => array(
            // Hook
            'all' => array(
                // Pointers
                array(
                    'selector' => '#menu-posts',
                    'content' => '<h3>' . sprintf(GB_GPS_MENU_POINTER_TITLE, __('Posts')) . '</h3><p>' . sprintf(GB_GPS_MENU_POINTER_CONTENT, __('Posts'), __('posts')) . '</p>',
                    'position' => array(
                        'edge' => 'top',
                        'align' => 'right',
                    ),
                ),
            ),
            'edit.php' => array(
                array(
                    'selector' => '#title',
                    'content' => '<h3>' . GB_GPS_ADD_CAT_TO_POST_LIST_POINTER_TITLE . '</h3><p>' . GB_GPS_ADD_CAT_TO_POST_LIST_POINTER_CONTENT . '</p>',
                    'position' => array(
                        'edge' => 'bottom',
                        'align' => 'right',
                        'offset' => '-100 23',
                    ),
                ),
            ),
            'post.php' => array(
                array(
                    'selector' => '#categorydiv',
                    'content' => '<h3>' . GB_GPS_ADD_CAT_TO_POST_CATEGORY_POINTER_TITLE . '</h3><p>' . GB_GPS_ADD_CAT_TO_POST_CATEGORY_POINTER_CONTENT .'</p>',
                    'position' => array(
                        'edge' => 'bottom',
                        'offset' => '0 -5',
                    ),
                ),
            ),
        ),
    ),
    // Add an user
    'gb_gps_add_user' => array(
        'label' => GB_GPS_ADD_USER_SCENARIO_LABEL,
        'description' => GB_GPS_ADD_USER_SCENARIO_DESCRIPTION,
        'capabilities' => array('edit_users'),
        'pointers' => array(
            // Hook
            'all' => array(
                // Pointers
                array(
                    'selector' => '#menu-users',
                    'content' => '<h3>' . sprintf(GB_GPS_MENU_POINTER_TITLE, __('Users')) . '</h3><p>' . sprintf(GB_GPS_MENU_POINTER_CONTENT, __('Users'), GB_GPS_LOWER_CASE_USERS) . '</p>',
                    'position' => array(
                        'edge' => 'top',
                        'align' => 'right',
                    ),
                ),
            ),
            'users.php' => array(
                array(
                    'selector' => '.add-new-h2',
                    'content' => '<h3>' . GB_GPS_ADD_FROM_LIST_POINTER_TITLE . '</h3><p>' . sprintf(GB_GPS_ADD_FROM_LIST_POINTER_CONTENT, GB_GPS_LOWER_CASE_USER) . '</p>',
                    'position' => array(
                        'edge' => 'top',
                        'offset' => '-40 0',
                    ),
                ),
            ),
            'user-new.php' => array(
                array(
                    'selector' => '#user_login',
                    'content' => '<p>' . GB_GPS_LOGIN_FIELD_POINTER_CONTENT . '</p>',
                    'position' => array(
                        'edge' => 'left',
                        'offset' => '0 -30',
                    ),
                ),
                array(
                    'selector' => '#email',
                    'content' => '<p>' . GB_GPS_EMAIL_FIELD_POINTER_CONTENT . '</p>',
                    'position' => array(
                        'edge' => 'left',
                        'offset' => '0 -30',
                    ),
                ),
                array(
                    'selector' => '#pass1',
                    'content' => '<p>' . GB_GPS_PASSWORD_FIELD_POINTER_CONTENT . '</p>',
                    'position' => array(
                        'edge' => 'left',
                        'offset' => '0 -30',
                    ),
                ),
                array(
                    'selector' => '#role',
                    'content' => '<p>' . GB_GPS_ROLE_FIELD_POINTER_CONTENT . '</p>',
                    'position' => array(
                        'edge' => 'top',
                    ),
                ),
            ),
        ),
    ),
    // Add a media
    'gb_gps_add_media' => array(
        'label' => GB_GPS_ADD_MEDIA_SCENARIO_LABEL,
        'description' => GB_GPS_ADD_MEDIA_SCENARIO_DESCRIPTION,
        'capabilities' => array('upload_files'),
        'pointers' => array(
            // Hook
            'all' => array(
                // Pointers
                array(
                    'selector' => '#menu-media',
                    'content' => '<h3>' . sprintf(GB_GPS_MENU_POINTER_TITLE, __('Media')) . '</h3><p>' . sprintf(GB_GPS_MENU_POINTER_CONTENT, __('Media'), GB_GPS_LOWER_CASE_MEDIAS) . '</p>',
                    'position' => array(
                        'edge' => 'top',
                    ),
                ),
            ),
            'upload.php' => array(
                array(
                    'selector' => '.add-new-h2',
                    'content' => '<h3>' . GB_GPS_ADD_FROM_LIST_POINTER_TITLE . '</h3><p>' . sprintf(GB_GPS_ADD_FROM_LIST_POINTER_CONTENT, GB_GPS_LOWER_CASE_MEDIA) . '</p>',
                    'position' => array(
                        'edge' => 'top',
                        'offset' => '-40 0',
                    ),
                ),
            ),
            'media-new.php' => array(
                array(
                    'selector' => '#plupload-browse-button',
                    'content' => '<h3>' . GB_GPS_ADD_MEDIA_UPLOAD_POINTER_TITLE . '</h3><p>' . GB_GPS_ADD_MEDIA_UPLOAD_POINTER_CONTENT . '</p>',
                    'position' => array(
                        'edge' => 'top',
                        'offset' => '-25 0',
                    ),
                ),
            ),
        ),
    ),
);