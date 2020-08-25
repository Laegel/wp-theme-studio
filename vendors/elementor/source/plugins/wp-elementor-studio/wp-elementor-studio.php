<?php

/**
 * Plugin Name:     WP Elementor Studio
 * Description:     Various tools to improve WP Elementor Studio experience
 * Version:         0.1.0
 */
define('TEMPLATE_POST_TYPE', 'templates');

define('WP_STUDIO_DIR', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'wp-elementor-studio');

require WP_STUDIO_DIR . DIRECTORY_SEPARATOR . 'setup.php';
require WP_STUDIO_DIR . DIRECTORY_SEPARATOR . 'export.php';
require WP_STUDIO_DIR . DIRECTORY_SEPARATOR . 'customizer.php';





// add_action('wp_loaded', 'my_front_end_function');
// function my_front_end_function()
// {
//     if (is_admin()) {
//         return;
//     }

//     ob_start('html_compress');
// }

// function html_compress( $html )
// {
//     error_log('in');
//     return $html;
// }

function set_blank_theme($template)
{
    return 'blank';
}



// add_action('loop_start', function() {
// 	global $wp_scripts;
// 	global $wp_styles;
// 	var_dump($wp_styles);
// });



function get_template_item(string $slug)
{
    return get_page_by_path($slug, OBJECT, TEMPLATE_POST_TYPE);
}

function create_template_item(string $slug)
{
    $id = wp_insert_post(
        [
        'post_title' => $slug,
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => TEMPLATE_POST_TYPE,
        ]
    );
    update_post_meta($id, '_wp_page_template', 'elementor_header_footer');
}

// Force default user
add_filter(
    'determine_current_user', function () {
        return is_export_context() ? 0 : 1;
    }, 30, 3
);

trait To_Template
{
    protected function render()
    {
        echo parent::render_template();
    }
}

trait Widget_Utils
{
    protected function evaluate_template($props)
    {
        $template = self::$template;
        foreach ($props as $key => $value) {
            $template = str_replace("[[$key]]", $value, $template);
        }
        return $template;
    }

    protected function print_out($template)
    {
        eval("?>$template");
    }
}

add_action(
    'elementor/widgets/widgets_registered', function () {
        $widgets = [
            'Heading', 'Image'
        ];

        foreach ($widgets as $widget) {
            include dirname(__FILE__) . "/widgets/$widget.php";
            $parent = '\WP_Elementor_Studio\\' . $widget;
            eval(
                "class Patched_$widget extends $parent {
					use Widget_Utils;
					" . (defined('EXPORT_THEME_ENABLED') ? "use To_Template;" : "") . "
				}"
            );
            $class = "Patched_$widget";

            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new $class);
        }
    }
);

$styles_function = function () {
    wp_enqueue_style('wp-elementor-studio-widgets', WP_PLUGIN_URL . '/wp-elementor-studio/widgets/styles.css');
};

add_action('wp_enqueue_scripts', $styles_function);
add_action('admin_enqueue_scripts', $styles_function);



