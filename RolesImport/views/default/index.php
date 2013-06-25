
<h1>Importing roles</h1>
<?php if (count($data)>0):?>
    <?php foreach($data as $moduleName =>$moduleData):?>
        <?php  $moduleData['title']= $moduleName;?>
        <?php $this->renderPartial('moduleRoles',array('data'=>$moduleData));?>
    <?php endforeach;?>
<?php endif;?>