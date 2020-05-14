<?php
$zip = new ZipArchive;
if ($zip->open('vendor.zip') === TRUE) {
    echo $zip->extractTo('.');
    $zip->close();
} else {
    echo 'failed';
}
