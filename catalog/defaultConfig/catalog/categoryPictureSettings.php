<?php

//Move this file into application.config
//for implement new configuration in any new site
return array(
    'divId' => 'pictureBox',
    'nativeFilters' => array(
        'main' => true,
    ),
    'filtersTitles' => array(
        'main' => 'Основная',
    ),
    'imageFilters' => array(
        'main' => array(
            0 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 320,
                    'height' => 219,
                ),
            ),
        ),
    ),
//    'original' => array(
//        1 => array(
//            'filter' => 'WaterMark',
//            'param' => array(
//                'watermark' => '/images/watermark.png',
//            ),
//        ),
//    ),
);
?>
