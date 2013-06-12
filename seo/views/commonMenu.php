<?php

$menu= array(
    array('label' => 'Статические страницы'),
    array('label' => 'Страницы', 'url' => array('/seo/seoPages/admin')),
    array('label' => 'Группы слов', 'url' => array('/seo/seoWordGroup/index')),
    array('label' => 'Ссылки', 'url' => array('/seo/seoLinks/admin')),
    array('label' => 'Слова', 'url' => array('/seo/seoWord/admin')),
    array('label' => 'CSV', 'url' => array('/seo/seoWord/CsvUpload')),
    array('label' => 'Спарсить', 'url' => array('/seo/default/index')),
    array('label' => 'meta', 'url' => array('/seo/title')),
);

return $menu;
?>
