<?php

return  array(
                array('label' => 'Галлереи'),
                array('label'=>'Manage' , 'url'=>array('/videoGallery/videoGallery/admin')),
		array('label'=>'Create' , 'url'=>array('/videoGallery/videoGallery/create')),
    
                array('label' => 'Видео ролики'),
                array('label'=>'Manage' , 'url'=>array('/videoGallery/videoGalleryVideo/admin')),
		array('label'=>'List' , 'url'=>array('/videoGallery/videoGalleryVideo/index')),
		array('label'=>'Create' , 'url'=>array('/videoGallery/videoGalleryVideo/create')) 
	);

?>
