<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{

        $authManager = Yii::app()->authManager;

        //$name
        //$type
        //$description=''
        //$bizRule=null
        //$data=null

        $modules = Yii::app()->modules;

        foreach ($modules as $moduleKey => $key){

            $moduleData = $this->getModuleConfig($moduleKey);

            if ($moduleData!==false){
                $array[$moduleKey] = $moduleData;
            }

        }

		$this->render('index',array('data'=>$array));
	}


    public function actionAddRoles($module){

        $moduleData = $this->getModuleConfig($module);

        $authManager = Yii::app()->authManager;

        foreach ($moduleData['items'] as $authName => $authItem  ){

            $type = $authItem['type'];
            $description=isset($authItem['description'])?$authItem['description']:'';
            $bizRule=isset($authItem['bizRule'])?$authItem['bizRule']:null;

            $authManager->createAuthItem($authName,$type,$description,$bizRule);
        }

        foreach ($moduleData['relations'] as  $authRelation  ){

            $child = $authRelation['child'];
            $parent = $authRelation['parent'];


            $authManager->addItemChild($parent,$child);
        }

        $this->copyFileToStore($module);

        $this->redirect(array('index'));
    }

    public function actionRemoveRoles($module){

        $moduleData = $this->getStoreModuleConfig($module);


        $authManager = Yii::app()->authManager;

        foreach ($moduleData['relations'] as  $authRelation  ){

            $child = $authRelation['child'];
            $parent = $authRelation['parent'];


            $authManager->removeItemChild($parent,$child);
        }

        foreach ($moduleData['items'] as $authName => $authItem  ){

            $type = $authItem['type'];
            $description=isset($authItem['description'])?$authItem['description']:'';
            $bizRule=isset($authItem['bizRule'])?$authItem['bizRule']:null;

            $authManager->removeAuthItem($authName,$type,$description,$bizRule);
        }

        $this->removeFileFromStore($module);

        $this->redirect(array('index'));
    }

    private function getModuleConfig($module){

        $configPath = Yii::getPathOfAlias('application.modules.'.$module.'.components').'/Roles.php';

        if (file_exists($configPath)){

            return require ($configPath);
        } else {
            return false;
        }

    }
    private function getStoreModuleConfig($module){

        $storePath = Yii::getPathOfAlias('webroot.files.RolesImport.'.$module).'.php';

        if (file_exists($storePath)){

            return require ($storePath);
        } else {
            return false;
        }

    }
    private function copyFileToStore($module){

        $configPath = Yii::getPathOfAlias('application.modules.'.$module.'.components').'/Roles.php';
        $storePath = Yii::getPathOfAlias('webroot.files.RolesImport.'.$module).'.php';
        copy($configPath,$storePath);

    }

    private function removeFileFromStore($module){
        $storePath = Yii::getPathOfAlias('webroot.files.RolesImport.'.$module).'.php';
        unlink($storePath);

    }


}