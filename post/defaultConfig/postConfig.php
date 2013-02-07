<?php

$picturesConfig = array(
    'divId' => 'pictureBox',
    'nativeFilters' => array(
        'small' => true,
        'inner_big' => true,
        'inner_small' => true,
         'big_watermark'=>true,
    ),
    'filtersTitles' => array(
        'small' => '180_110',
        'inner_big' => '582_288',
        'inner_small' => '101_61',
         'big_watermark'=>'водянка'
    ),
    'imageFilters' => array(
        'big_watermark' => array(
            0 => array(
                'filter' => 'WaterMark',
                'param' => array(
                    'watermark' => '/images/watermark.png',
                ),
            ),
        ),
        'small' => array(
            1 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 180,
                    'height' => 110,
                ),
            ),
        ),
        'inner_big' => array(
            1 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 582,
                    'height' => 288,
                ),
            ),
        ),
        'inner_small' => array(
            1 => array(
                'filter' => 'CropResize',
                'param' => array(
                    'width' => 101,
                    'height' => 61,
                ),
            ),
        ),
    ),
//        'original'=>array(
//            1 => array(
//                'filter' => 'WaterMark',
//                'param' => array(
//                    'watermark' => '/images/watermark.png',
//
//                ),
//            ),
//        ),
);
?>
