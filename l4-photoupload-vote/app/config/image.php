<?php

return [

//the folder that will hold original uploaded images
'upload_folder' => 'uploads/render',
//the folder that will hold original uploaded images
'upload_path' => public_path() . '/uploads/render',
//path for tmp upload location
'upload_path_tmp' => public_path() . '/uploads/render/tmp',
'upload_folder_tmp' => '/uploads/render/tmp',

//the folder that will hold thumbnails
'thumb_folder' => 'uploads/render/thumbs',
//the folder that will hold thumbnails
'thumb_path' => public_path() . '/uploads/render/thumbs',

//path for the user's profile avatar picture, used by browser
'avatar_folder' => '/uploads/avatar',
//path for the user's profile avatar picture, used by filesystem
'avatar_path' => public_path() . '/uploads/avatar',
//path for the tmp user's profile avatar picture
'avatar_path_tmp' => public_path() . '/uploads/avatar/tmp',

//size of user's profile avatar 
'avatar_width' => 160,

//width of the resized thumbnail
'thumb_width' => 240,
'thumb_height' => 170,

//width of rendered image
'render_width' => 400,
'render_height' => 300,
];
