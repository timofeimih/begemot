<?php

Yii::import('application.modules.tasks.models._base.BaseTasksToUser');

class TasksToUser extends BaseTasksToUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}