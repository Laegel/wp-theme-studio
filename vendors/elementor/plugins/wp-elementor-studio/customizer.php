<?php

add_filter(
    'elementor/document/urls/exit_to_dashboard', function ($url) {
        return (isset($_GET['redirect']) ? $_GET['redirect'] : get_user_meta(1, 'redirect', true)) . '#themes';
    }
);

add_filter(
    'gettext', function ($translation, $text, $domain) {
        if ($text !== 'Exit To Dashboard' || $domain !== 'elementor') {
            return $translation;
        }
        return 'Retour à la liste des thèmes';
    }, 10, 3
);

add_action(
    'init', function () {
        update_option('elementor_disable_color_schemes', 'yes');
        update_option('elementor_disable_typography_schemes', 'yes');
    }, 100
);

add_action(
    'elementor/elements/categories_registered', function ( $elements_manager ) {

        $elements_manager->add_category(
            'templating',
            [
            'title' => __('Templating', 'wp-elementor-studio'),
            'icon' => 'fa fa-plug',
            ]
        );

    }
);
$meta_type = '_elementor_data';
add_filter(
    "get_{$meta_type}_metadata", function ($value, $post_id, $meta_key, $single) {
		error_log(json_encode([$value, $post_id, $meta_key, $single]));
		return $value;
    }, 100, 4
);
