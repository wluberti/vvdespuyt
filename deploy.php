<?php
$zip = new ZipArchive;
if ($zip->open('archive.zip') === TRUE) {
    echo $zip->extractTo('.');
    $zip->close();
} else {
    echo 'failed';
}
