<?php

$types = array(
    CAuthItem::TYPE_ROLE => '<i class="icon-user"></i>&nbsp;role',
    CAuthItem::TYPE_TASK => '<i class="icon-list"></i>&nbsp;task',
    CAuthItem::TYPE_OPERATION => '<i class="icon-check"></i>&nbsp;operation',
);

?>
<?php

$rolesFile = Yii::getPathOfAlias('webroot.files.RolesImport.'.$data['title']).'.php';



$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => $data['title'].' roles, tasks and operations.',
    'headerIcon' => 'icon-user',
    'headerButtons' => array(
            array(
                'class'=>'bootstrap.widgets.TbButton',
                'url'=>array('removeRoles','module'=>$data['title']),
                'label'=>'Удалить',
                'size' => 'mini',
                'type'=>'danger', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'visible'=> file_exists($rolesFile)
            ),
            array(
                'class'=>'bootstrap.widgets.TbButton',
                'url'=>'#',
                'size' => 'mini',
                'label'=>'Импорт',
                'type'=>'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'url'=>array('addRoles','module'=>$data['title']),
                'visible'=> !file_exists($rolesFile)
            )
        ))
    );

?>
    <h4><?php echo isset($data['title']) ? $data['title'].' roles.' : '<span style="color:#ff4036;">no value</span>';?></h4>

    <table class="table">
        <thead>
        <tr>
            <td>Name</td>
            <td>Type</td>
            <td>Description</td>
            <td>BizRule</td>
        </tr>
        </thead>

        <?php foreach ($data['items'] as $itemName => $item): ?>
            <tr>
                <td><?php echo $itemName;?></td>
                <td><?php echo $types[$item['type']];?></td>
                <td><?php echo isset($item['description']) ? $item['description'] : '<span style="color:#ff4036;">no value</span>';?></td>
                <td><?php echo isset($item['bizRule']) ? $item['bizRule'] : '<span style="color:#ff4036;">no value</span>';?></td>
            </tr>
        <?php endforeach;?>
    </table>
    <h4><?php echo isset($data['title']) ? $data['title'].' assigments.' : '<span style="color:#ff4036;">no value</span>';?></h4>
    <table class="table" style="width:auto;">
        <thead>
        <tr>
            <td>Parent</td>
            <td></td>
            <td>Children</td>
        </tr>
        </thead>
        <?php if (isset($data['relations'])): ?>
            <?php foreach ($data['relations'] as $item): ?>
                <tr>
                    <td><?php echo $item['parent'];?></td>
                    <td><i class="icon-arrow-right"></td>
                    <td><?php echo $item['child'];?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif;?>

    </table>

<?php $this->endWidget() ?>