<?php

$pBox = new PBox($id, $elementId);
$pictureId = $_REQUEST['pictureId'];
$image = $pBox->pictures[$pictureId];
//print_r($config);
?>

<?php
if (isset($image['title'])) unset ($image['title']);
if (isset($image['alt'])) unset ($image['alt']);
if (isset($image['admin'])) unset ($image['admin']);

?>

<?php foreach ($image as $imageKey => $subImage): ?>
    <?php

    if ($imageKey == 'original') continue;

    /*
     * Выводим только те картинки у которых
     * хотя бы в одном филтре есть width и height
     */
    $continueKey = true;


    foreach ($config['imageFilters'][$imageKey] as $filter) {

        if (isset($filter['param']['width'])) {
            $continueKey = false;
            $filterWidth = $filter['param']['width'];
            $filterHeight = $filter['param']['height'];
            continue;
        }
    }

    if ($continueKey) continue;

    ?>
    <h2><?= $imageKey ?></h2>
    <div style="float:left;width:100%">
        <img data-is-filtered-image="1" class="ladybug_ant" pb-id = "<?= $id ?>" pb-element-id="<?= $elementId ?>" pb-picture-id="<?= $pictureId ?>" style="float:left;" filter-height="<?= $filterHeight ?>" filter-width="<?= $filterWidth ?>"
             image-filter="<?= $imageKey ?>" src="<?= $image['original']?>"/>
        <div style="position: relative;width:<?= $filterWidth ?>px;height:<?= $filterHeight ?>px;overflow: hidden;">
            <img style="float:left;position: relative;max-width: none;" class="original" src="<?= $subImage.'?'.rand(1,1000) ?>"/>
        </div>

    </div>
<?php endforeach; ?>