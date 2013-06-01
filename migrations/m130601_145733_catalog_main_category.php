<?php

class m130601_145733_catalog_main_category extends CDbMigration
{
	public function up()
	{
        Yii::import('application.modules.catalog.models.CatItem');
        Yii::import('application.modules.catalog.models.CatItemsToCat');
        Yii::import('application.modules.catalog.models.CatItemsRow');
        Yii::import('application.modules.begemot.extensions.contentKit.ContentKitModel');

        $models = CatItemsToCat::model()->findAll();

        foreach ($models as $model){
             $model->item->catId=$model->catId;
            $model->item->save();
        }

        echo '
good

        ';

        return true;

	}

	public function down()
	{
		echo "m130601_145733_catalog_main_category does not support migration down.\n";
		return true;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}