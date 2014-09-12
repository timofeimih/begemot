<?php
$this->menu = array(
    array('label' => 'Все парсеры', 'url' => array('/parsers/default/index')),
    array('label' => 'Все связи', 'url' => array('/parsers/default/linking')),
    array('label' => 'Задания по расписанию', 'url' => array('/parsers/default/cron')),
);
?>


    <h1>Создать новое задание</h1>

    <form>
        Файл: <select name="filename" >
            <?php foreach ($files as $file): ?>
                <option><?php echo $file['name'] ?></option>
            <?php endforeach ?>
        </select><br/>
        Временой период: <select name="time">
            <option value="604800">Раз в неделю в понедельник</option>
            <option value="302400">Два раза в неделю(в понедельник и четверг)</option>
            <option value="86400">Ежедневно</option>
        </select><br/>
        <input type="hidden" name='class' value='CatItemCron'/>
        <input type="submit" class='btn btn-primary' value='Сохранить' name='createNew'>
    </form>

    <h1>Все задания</h1>

<?php if ($jobs_obj): ?>
    <table>
        <thead>
        <tr>
            <td>Команда</td>
            <td>Исполняется</td>
            <td>Действия</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($jobs_obj as $key => $job ): ?>
            <tr>
                <td><?php echo $key?></td>
                <td><?php echo $cron->timeToString($job->period)?></td>
                <td><form><input type="hidden"  name='deleteJob' value='<?php echo $key?>'><input type="submit" value='Удалить'></form></td>
            </tr>
        <?php endforeach ?>


        </tbody>
    </table>

<?php else: ?>
    Пока нету ни одного задания
<?php endif ?>