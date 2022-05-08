<?php

function uploadFile($file) {
    $filenameWithExt = $file->getClientOriginalName();
    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    $extension = $file->getClientOriginalExtension();
    $savedFile = $filename.'_'.time().'.'.$extension;

    $file->storeAs('public/tmp-files', $savedFile);

    return $savedFile;
}