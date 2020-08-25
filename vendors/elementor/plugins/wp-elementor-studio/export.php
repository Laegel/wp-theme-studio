<?php

function is_export_context()
{
    return isset($_GET['export']) || defined('EXPORT_THEME_ENABLED');
}

add_action(
    'init', function () {
        add_rewrite_endpoint('export', EP_PERMALINK | EP_PAGES);
    }
);

add_action(
    'plugins_loaded', function () {
        if (!is_export_context()) {
            return;
        }
        add_filter('stylesheet', 'set_blank_theme');
        add_filter('template', 'set_blank_theme');
    }
);

add_action(
    'template_redirect', function () {
        if (!is_export_context()) {
            return;
		}
		header('Content-Type: text/plain');
        define('EXPORT_THEME_ENABLED', true);
        return;
    }
);


add_action(
    'admin_post_theme_export', function () {
		error_log('in!');

		// $current_theme = wp_get_theme();
        // define('EXPORT_THEME_ENABLED', true);
		// switch_theme('blank');
        // $archive = new ZipArchive();
        // $zipname = WP_PLUGIN_DIR . '/theme.zip';
        // $archive->open($zipname, ZipArchive::CREATE|ZipArchive::OVERWRITE);
		// $archive->addFromString('style.css', 'body {}');

        global $wpdb;
		$templates = new WP_Query(['post_type' => TEMPLATE_POST_TYPE, 'posts_per_page' => -1]);

		// $out = [];
		// while ($templates->have_posts()) {
		// 	$templates->the_post();
		// 	ob_start();
		// 	// require get_template_directory() . DIRECTORY_SEPARATOR . 'single.php';
		// 	get_template('single');
		// 	$out[] = ob_get_contents();
		// }
		// switch_theme($current_theme->get_stylesheet());
		// switch_theme('twentytwenty');

        // foreach ($templates->posts as $template) {
		// 	// var_dump($wpdb->get_results('SELECT * FROM wp_postmeta WHERE post_id = ' . $template->ID));
		// 	// ob_start();
		// 	$content = apply_filters('the_content', $template->post_content);
		// 	var_dump($content);
		// 	// $archive->addFromString($template->post_name . '.php', $php_template);
        // }
        // header('Content-Type: application/zip');
        // header('Content-disposition: attachment; filename=theme.zip');
        // header('Content-Length: ' . filesize($zipname));
		// readfile($zipname);
		wp_send_json(array_map(function($row) {
			return $row->post_name;
		}, $templates->posts));
    }
);
