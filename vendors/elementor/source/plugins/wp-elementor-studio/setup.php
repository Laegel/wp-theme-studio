<?php

add_action(
    'init', function () {

        $labels = [
        'name'                => _x('Template', 'Post Type General Name'),
        'singular_name'       => _x('Template', 'Post Type Singular Name'),
        'menu_name'           => __('Templates'),
        'all_items'           => __('All templates'),
        'view_item'           => __('View templates'),
        'add_new_item'        => __('Add template'),
        'add_new'             => __('Add'),
        'edit_item'           => __('Edit template'),
        'update_item'         => __('Update template'),
        'search_items'        => __('Search template'),
        'not_found'           => __('Not found'),
        'not_found_in_trash'  => __('Not found in trash'),
        ];

        $args = [
        'label'               => __('Templates'),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        'hierarchical'        => false,
        'public'              => true,
        'has_archive'         => true,
        'rewrite' => ['slug' => TEMPLATE_POST_TYPE],
        ];

        register_post_type(TEMPLATE_POST_TYPE, $args);

        if (!get_template_item('page')) {
            create_template_item('page');
        }

        $elementor_support = get_option('elementor_cpt_support');
        if (!in_array(TEMPLATE_POST_TYPE, $elementor_support)) {
            $elementor_support[] = TEMPLATE_POST_TYPE;
            update_option('elementor_cpt_support', $elementor_support);
        }
    }, 0
);
