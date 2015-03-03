<?php
/**
 * Этот класс содержит методы для взаимодействием
 * с заданиями текущего процесса парсинга.
 */

class TaskManager {
    /**
     * @var int Номер процесса в рамках которого менеджер работает с набором задач
     */
    private $processId = null;

    public function TaskManager($processId){
        $this->processId = $processId;
    }

    public function getActiveTaskCount()
    {
        return ScenarioTask::getActiveTaskCount($this->processId);
    }

    public function createTask($target_id,$target_type, $scenarioItemName, $status = null)
    {

        $newTask = new ScenarioTask();
        $newTask->target_id = $target_id;
        $newTask->target_type = $target_type;
        $newTask->processId = $this->processId;
        $newTask->scenarioName = $scenarioItemName;
        if (is_null($status)) {
            $newTask->taskStatus = 'new';
        } else {
            $newTask->taskStatus = $status;
        }
        $newTask->save();
    }

}