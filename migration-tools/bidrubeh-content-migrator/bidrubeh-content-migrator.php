<?php
/**
 * Plugin Name: Bidroubeh One-Time Content Migrator
 * Description: Imports the prepared local Bidroubeh site content, settings, menus, and uploads once.
 * Version: 1.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

function bidroubeh_migrator_replace_value($value, $source_url, $destination_url) {
    if (!is_string($value)) {
        return $value;
    }

    if (is_serialized($value)) {
        $decoded = maybe_unserialize($value);
        return maybe_serialize(bidroubeh_migrator_replace_recursive($decoded, $source_url, $destination_url));
    }

    return str_replace(
        array($source_url, rtrim($source_url, '/')),
        array($destination_url, rtrim($destination_url, '/')),
        $value
    );
}

function bidroubeh_migrator_replace_recursive($value, $source_url, $destination_url) {
    if (is_array($value)) {
        foreach ($value as $key => $item) {
            $value[$key] = bidroubeh_migrator_replace_recursive($item, $source_url, $destination_url);
        }
        return $value;
    }

    if (is_object($value)) {
        foreach (get_object_vars($value) as $key => $item) {
            $value->{$key} = bidroubeh_migrator_replace_recursive($item, $source_url, $destination_url);
        }
        return $value;
    }

    return is_string($value)
        ? str_replace($source_url, $destination_url, $value)
        : $value;
}

function bidroubeh_migrator_copy_tree($source, $destination) {
    if (!is_dir($source)) {
        return;
    }

    if (!is_dir($destination)) {
        wp_mkdir_p($destination);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        $target = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
        if ($item->isDir()) {
            wp_mkdir_p($target);
        } else {
            copy($item->getPathname(), $target);
        }
    }
}

function bidroubeh_migrator_activate() {
    global $wpdb;

    if (get_option('bidroubeh_migration_completed')) {
        return;
    }

    $data_json = base64_decode('__BIDROUBEH_DATA_B64__', true);
    $data = json_decode($data_json, true);
    if (!is_array($data) || empty($data['tables'])) {
        wp_die('Bidroubeh migration data is invalid.');
    }

    $source_url = rtrim($data['source_url'], '/');
    $destination_url = rtrim(home_url(), '/');

    $table_map = array(
        'terms' => $wpdb->terms,
        'termmeta' => $wpdb->termmeta,
        'term_taxonomy' => $wpdb->term_taxonomy,
        'posts' => $wpdb->posts,
        'postmeta' => $wpdb->postmeta,
        'comments' => $wpdb->comments,
        'commentmeta' => $wpdb->commentmeta,
        'term_relationships' => $wpdb->term_relationships,
    );

    $wpdb->query('START TRANSACTION');

    try {
        $wpdb->query("DELETE FROM {$wpdb->commentmeta}");
        $wpdb->query("DELETE FROM {$wpdb->comments}");
        $wpdb->query("DELETE FROM {$wpdb->term_relationships}");
        $wpdb->query("DELETE FROM {$wpdb->postmeta}");
        $wpdb->query("DELETE FROM {$wpdb->posts}");
        $wpdb->query("DELETE FROM {$wpdb->termmeta}");
        $wpdb->query("DELETE FROM {$wpdb->term_taxonomy}");
        $wpdb->query("DELETE FROM {$wpdb->terms}");

        foreach ($table_map as $key => $table_name) {
            foreach ($data['tables'][$key] as $row) {
                foreach ($row as $column => $value) {
                    $row[$column] = bidroubeh_migrator_replace_value($value, $source_url, $destination_url);
                }
                if (false === $wpdb->replace($table_name, $row)) {
                    throw new RuntimeException("Failed importing {$key}: {$wpdb->last_error}");
                }
            }
        }

        foreach ($data['options'] as $option) {
            $value = bidroubeh_migrator_replace_value($option['option_value'], $source_url, $destination_url);
            update_option($option['option_name'], maybe_unserialize($value), 'yes' === $option['autoload']);
        }

        $upload = wp_upload_dir();
        $upload_archive = base64_decode('__BIDROUBEH_UPLOADS_B64__', true);
        if (false === $upload_archive) {
            throw new RuntimeException('The embedded media archive is invalid.');
        }

        $temporary_archive = wp_tempnam('bidroubeh-uploads.zip');
        if (!$temporary_archive || false === file_put_contents($temporary_archive, $upload_archive)) {
            throw new RuntimeException('Could not prepare the media archive.');
        }

        $zip = new ZipArchive();
        if (true !== $zip->open($temporary_archive)) {
            @unlink($temporary_archive);
            throw new RuntimeException('Could not open the media archive.');
        }
        if (!$zip->extractTo($upload['basedir'])) {
            $zip->close();
            @unlink($temporary_archive);
            throw new RuntimeException('Could not extract the media archive.');
        }
        $zip->close();
        @unlink($temporary_archive);

        update_option('bidroubeh_migration_completed', gmdate('c'), false);
        $wpdb->query('COMMIT');
    } catch (Throwable $error) {
        $wpdb->query('ROLLBACK');
        wp_die('Bidroubeh migration failed: ' . esc_html($error->getMessage()));
    }

    wp_cache_flush();
    flush_rewrite_rules(false);
}

register_activation_hook(__FILE__, 'bidroubeh_migrator_activate');
