<?php
/**
 * Export the local Bidroubeh WordPress site's public/site-facing data.
 * Run inside the wp-app container after copying this file to /tmp.
 */

require '/var/www/html/wp-load.php';

global $wpdb;

$post_types = array(
    'post',
    'page',
    'attachment',
    'nav_menu_item',
    'wp_navigation',
    'wp_template',
    'wp_global_styles',
);
$post_statuses = array('publish', 'inherit', 'private', 'draft');

$type_placeholders = implode(',', array_fill(0, count($post_types), '%s'));
$status_placeholders = implode(',', array_fill(0, count($post_statuses), '%s'));
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE post_type IN ($type_placeholders) AND post_status IN ($status_placeholders)",
    array_merge($post_types, $post_statuses)
);
$posts = $wpdb->get_results($sql, ARRAY_A);
$post_ids = array_map('intval', wp_list_pluck($posts, 'ID'));

$select_for_ids = static function ($table, $column, $ids) use ($wpdb) {
    if (!$ids) {
        return array();
    }
    $id_list = implode(',', array_map('intval', $ids));
    return $wpdb->get_results("SELECT * FROM {$table} WHERE {$column} IN ({$id_list})", ARRAY_A);
};

$comments = $select_for_ids($wpdb->comments, 'comment_post_ID', $post_ids);
$comment_ids = array_map('intval', wp_list_pluck($comments, 'comment_ID'));

$option_names = array(
    'blogname',
    'blogdescription',
    'timezone_string',
    'gmt_offset',
    'date_format',
    'time_format',
    'start_of_week',
    'permalink_structure',
    'show_on_front',
    'page_on_front',
    'page_for_posts',
    'page_for_privacy_policy',
    'posts_per_page',
    'uploads_use_yearmonth_folders',
    'thumbnail_size_w',
    'thumbnail_size_h',
    'thumbnail_crop',
    'medium_size_w',
    'medium_size_h',
    'large_size_w',
    'large_size_h',
    'sidebars_widgets',
    'sticky_posts',
    'theme_mods_bidrubeh-municipality',
);
$option_placeholders = implode(',', array_fill(0, count($option_names), '%s'));
$options_sql = $wpdb->prepare(
    "SELECT option_name, option_value, autoload FROM {$wpdb->options} WHERE option_name IN ($option_placeholders) OR option_name LIKE 'widget\\_%'",
    $option_names
);

$export = array(
    'source_url' => home_url(),
    'generated_at' => gmdate('c'),
    'tables' => array(
        'terms' => $wpdb->get_results("SELECT * FROM {$wpdb->terms}", ARRAY_A),
        'termmeta' => $wpdb->get_results("SELECT * FROM {$wpdb->termmeta}", ARRAY_A),
        'term_taxonomy' => $wpdb->get_results("SELECT * FROM {$wpdb->term_taxonomy}", ARRAY_A),
        'posts' => $posts,
        'postmeta' => $select_for_ids($wpdb->postmeta, 'post_id', $post_ids),
        'comments' => $comments,
        'commentmeta' => $select_for_ids($wpdb->commentmeta, 'comment_id', $comment_ids),
        'term_relationships' => $select_for_ids($wpdb->term_relationships, 'object_id', $post_ids),
    ),
    'options' => $wpdb->get_results($options_sql, ARRAY_A),
);

$json = wp_json_encode($export, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if (false === $json) {
    fwrite(STDERR, "Could not encode export data.\n");
    exit(1);
}

file_put_contents('/tmp/bidrubeh-content.json', $json);
echo wp_json_encode(array(
    'posts' => count($posts),
    'postmeta' => count($export['tables']['postmeta']),
    'comments' => count($comments),
    'terms' => count($export['tables']['terms']),
    'options' => count($export['options']),
), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), PHP_EOL;

