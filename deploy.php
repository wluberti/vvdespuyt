<?php

/**
 * This file is a VERY dirty hack and I'm not proud of it. The reason I did this
 * is that the hosting provider only supports FTPS as a (remote) transfer method
 * and the deploy sollution with Docker Actions takes up to an hour (!) to deploy.
 *
 * The sollution chosen in /.github/workflows/deploy.yml (zipping the vendor
 * directory and then removing it before SFTP'ing all the files to the webhosting)
 * brings down the deploy time to about 1 minute. Untill I find a better way...
 */

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    die('This file should only be run on the live server!' . PHP_EOL);
}

$filename = 'vendor.zip';

$zip = new ZipArchive;
if ($zip->open($filename) === TRUE) {
    echo $zip->extractTo('.');
    $zip->close();
    try {
        // Delete the unzipped vendor archive
        unlink($filename);
        // Delete this file (not needed anymore after everything is unzipped)
        unlink(__FILE__);
    } catch (Exception $exception) {
        print($exception->getMessage());
    }
} else {
    echo 'failed';
}
