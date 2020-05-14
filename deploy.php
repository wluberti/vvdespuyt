<?php

$filename = 'vendor.zip';

$zip = new ZipArchive;
if ($zip->open($filename) === TRUE) {
    echo $zip->extractTo('.');
    $zip->close();
    try {
        unlink($filename);
        unlink(__FILE__);
    } catch (Exception $exception) {
        print($exception->getMessage());
    }
} else {
    echo 'failed';
}
