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
}