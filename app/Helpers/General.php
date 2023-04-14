<?php

use Illuminate\Support\Facades\Config;
//it take the path where we need to store the uploaded photo, and the  photo name
function uploadImage($folder, $image)
{
    // to get the extention of the photo and convert it to smallcase
    $extension = strtolower($image->extension());
    //to rename the photo with random name
    $filename = time() . rand(100, 999) . '.' . $extension;
    //to change the name and store it really
    $image->getClintOrignalName = $filename;
    $image->move($folder, $filename);
    return $filename;
}
