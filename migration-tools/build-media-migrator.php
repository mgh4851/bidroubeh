<?php

$uploads = '/var/www/html/wp-content/uploads';
$entries = array();

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($uploads, FilesystemIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if (!$file->isFile()) {
        continue;
    }
    $relative = str_replace('\\', '/', substr($file->getPathname(), strlen($uploads) + 1));
    $entries[] = var_export($relative, true) . ' => ' . var_export(base64_encode(file_get_contents($file->getPathname())), true);
}

$template = <<<'PLUGIN'
<?php
/**
 * Plugin Name: Bidroubeh One-Time Media Migrator
 * Description: Restores the Bidroubeh media library files once.
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

function bidroubeh_media_migrator_activate() {
    if (get_option('bidroubeh_media_migration_completed')) {
        return;
    }

    $files = array(
__BIDROUBEH_MEDIA_FILES__
    );
    $upload = wp_upload_dir();

    foreach ($files as $relative => $encoded) {
        $target = $upload['basedir'] . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
        $directory = dirname($target);
        if (!is_dir($directory) && !wp_mkdir_p($directory)) {
            wp_die('Could not create media directory: ' . esc_html($directory));
        }
        $contents = base64_decode($encoded, true);
        if (false === $contents || false === file_put_contents($target, $contents)) {
            wp_die('Could not restore media file: ' . esc_html($relative));
        }
    }

    update_option('bidroubeh_media_migration_completed', count($files), false);
}

register_activation_hook(__FILE__, 'bidroubeh_media_migrator_activate');
PLUGIN;

$output = str_replace('__BIDROUBEH_MEDIA_FILES__', '        ' . implode(",\n        ", $entries), $template);
file_put_contents('/tmp/bidrubeh-media-migrator.php', $output);
echo count($entries), ' files, ', strlen($output), " bytes\n";

