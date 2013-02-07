<?php

//Move this file into application.config
//for implement new configuration in any new site
return array(
    'divId' => 'pictureBox',
    'nativeFilters' => array(
        'main' => true,
        'innerSmall' => true,
        'slider' => true,
        'one' => false,
        'two' => true,
        'three' => false,
        'big_watermark'=>true,
    ),
    'filtersTitles' => array(
        'main' => '320 219',
        'innerSmall' => '160 100',
        'slider' => '165 100',
        'one' => '441 329',
        'two' => '341 248',
        'three' => '232 172',
        'big_watermark'=>'водянка'
    ),
    'imageFilters' => array(
        'big_watermark'=>array(
            0 => array(
                'filter' => 'WaterMark',
                'param' => array(
                    'watermark' => '/images/watermark.png',
                ),
            ),
        ),
        'main' => array(
            0 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 320,
                    'height' => 219,
                ),
            ),
        ),
        'innerSmall' => array(
            0 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 160,
                    'height' => 100,
                ),
            ),
        ),
        'slider' => array(
            0 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 165,
                    'height' => 100,
                ),
            ),
        ),
        'one' => array(
            0 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 232,
                    'height' => 172,
                ),
            ),
        ),
        'two' => array(
            0 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 341,
                    'height' => 248,
                ),
            ),
        ),
        'three' => array(
            0 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 232,
                    'height' => 172,
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
