
<div class="btn-group dropdown">
    <?php
    echo '<a data-toggle="dropdown" class="btn btn-mini dropdown-toggle"  href="#">выбрать<span class="caret"></span></a>';
    $categories = $data;
    $level = -1;

    foreach ($categories as $n => $category) {
        if ($category->level == $level)
            echo CHtml::closeTag('li') . "\n";
        else if ($category->level > $level)
            echo CHtml::openTag('ul', array('class' => 'dropdown-menu dropdown')) . "\n";
        else {
            echo CHtml::closeTag('li') . "\n";

            for ($i = $level - $category->level; $i; $i--) {
                echo CHtml::closeTag('ul') . "\n";
                echo CHtml::closeTag('li') . "\n";
            }
        }

            if (!$category->isLeaf()){
                $class=array('class'=>'dropdown-submenu dropdown');
            } else{
                $class=array();
            }
            $htmlOptions = array(
                'onClick'=>'setNestedData(event,{id:'.$category->id.',title:"'.$category->title.'",inputId:"'.$id.'"})'
            );
        
        echo CHtml::openTag('li',  array_merge($htmlOptions, $class));
        echo '<a tabindex="-1" href="javascript:;" onClick="'.$callback.'('.$category->id.')" data="'.$category->id.'">'.$category->title.'</a>';
        //echo CHtml::encode($category->title . ' ' . $category->lft . ' ' . $category->level . ' ' . $level);
        $level = $category->level;
    }

    for ($i = $level + 1; $i; $i--) {   
        echo CHtml::closeTag('li') . "\n";
        echo CHtml::closeTag('ul') . "\n";
    }
    ?>
</div>
<div style="width:50px;display:inline;" id="<?php echo $id;?>"><?php echo $default;?></div>