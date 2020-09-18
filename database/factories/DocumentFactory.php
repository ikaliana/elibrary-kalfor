<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Document;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    //$filetypes = array('avi','mp4','mkv','wav','mp3','ogg','docx','pdf','xlsx','jpg','bmp','png','tif','shp');
    
    $filetypes = array(
    	array( 'ext' => 'avi', 'mime' => 'video/avi', 'type' => 'Video' ),
    	array( 'ext' => 'mp4', 'mime' => 'video/mp4', 'type' => 'Video' ),
    	array( 'ext' => 'mkv', 'mime' => 'video/x-matroska', 'type' => 'Video' ),
    	array( 'ext' => 'wav', 'mime' => 'audio/wav', 'type' => 'Audio' ),
    	array( 'ext' => 'mp3', 'mime' => 'audio/mpeg', 'type' => 'Audio' ),
    	array( 'ext' => 'ogg', 'mime' => 'audio/ogg', 'type' => 'Audio' ),
    	array( 'ext' => 'docx', 'mime' => 'application/vnd.openxmlformat', 'type' => null ),
    	array( 'ext' => 'pdf', 'mime' => 'application/pdf', 'type' => null ),
    	array( 'ext' => 'xlsx', 'mime' => 'application/vnd.openxmlformat', 'type' => null ),
    	array( 'ext' => 'jpg', 'mime' => 'image/jpeg', 'type' => 'Image' ),
    	array( 'ext' => 'bmp', 'mime' => 'image/bmp', 'type' => 'Image' ),
    	array( 'ext' => 'png', 'mime' => 'image/png', 'type' => 'Image' ),
    	array( 'ext' => 'tif', 'mime' => 'image/tif', 'type' => 'Map' ),
    	array( 'ext' => 'shp', 'mime' => 'application/octet-stream', 'type' => 'Map' ),
    );

    $randomType = $faker->randomElement($array = $filetypes);

    $type = $randomType['type'];
    $type_id = null;
    switch ($type) {
        case 'Audio':
            $doc = new \App\Models\Audio();
            $doc->duration = $faker->numberBetween($min = 0, $max = 900);
            $doc->save();
            $type_id = $doc->id;
            break;
        case 'Image':
            $doc = new \App\Models\Image();
            $doc->height = $faker->randomElement($array = array (640,800,1024,1280));
            $doc->width = $faker->randomElement($array = array (640,800,1024,1280));
            $doc->is_portrait = ($doc->height > $doc->width) ? 1 : 0;
            $doc->save();
            $type_id = $doc->id;
            break;
        case 'Map':
            $doc = new \App\Models\Map();
            $doc->datasource = $faker->url;
            $doc->save();
            $type_id = $doc->id;
            break;
        case 'Video':
            $doc = new \App\Models\Video();
            $doc->height = $faker->randomElement($array = array (640,800,1024,1280));
            $doc->width = $faker->randomElement($array = array (640,800,1024,1280));
            $doc->duration = $faker->numberBetween($min = 0, $max = 900);
            $doc->save();
            $type_id = $doc->id;
            break;
    }

    return [
        'user_id' => 1,
        'gallery_id' => 0,
        'name' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        // 'filename' => $faker->creditCardNumber.'.'.$faker->randomElement($array = $filetypes),
        // 'fileformat' => $faker->mimeType,
        'filename' => $faker->creditCardNumber.'.'.$randomType['ext'],
        'fileformat' => $randomType['mime'],
        'uploaded_date' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
        'description' => $faker->text($maxNbChars = 500),
        'category' => $faker->numberBetween($min = 0, $max = 3),
        'visibility' => 1,
        'license' => $faker->uuid,
        'filesize' => 1,
        'attributes_type' => $type,
        'attributes_id' => $type_id
    ];
});
