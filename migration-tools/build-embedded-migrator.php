<?php

$template = file_get_contents('/tmp/bidrubeh-migrator-template.php');
$data = file_get_contents('/tmp/bidrubeh-content.json');
$uploads = file_get_contents('/tmp/bidrubeh-uploads.zip');

if (false === $template || false === $data || false === $uploads) {
    fwrite(STDERR, "Missing migrator build input.\n");
    exit(1);
}

$output = str_replace(
    array('__BIDROUBEH_DATA_B64__', '__BIDROUBEH_UPLOADS_B64__'),
    array(base64_encode($data), base64_encode($uploads)),
    $template
);

file_put_contents('/tmp/bidrubeh-content-migrator-embedded.php', $output);
echo strlen($output), PHP_EOL;

