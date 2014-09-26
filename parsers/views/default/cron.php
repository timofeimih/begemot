<?php
$this->menu = array(
    array('label' => 'Все парсеры', 'url' => array('/parsers/default/index')),
    array('label' => 'Все связи', 'url' => array('/parsers/default/linking')),
    array('label' => 'Задания по расписанию', 'url' => array('/parsers/default/cron')),
);
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
	<input type="hidden" name='class' value='CatItem'/>
=======
>>>>>>> Парсер и мелкие правки
=======
	<input type="hidden" name='class' value='CatItemCron'/>
>>>>>>> Парсер и планировщик
	<input type="submit" class='btn btn-primary' value='Сохранить' name='createNew'>
</form>

<h1>Все задания</h1>
=======
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
        Точное время выполнения: <select name="hour">
            <option value='3600'>1</option>
            <option value='10800'>3</option>
            <option value='25200'>7</option>
            <option value='32400'>9</option>
            <option value='36000'>10</option>
            <option value='43200'>12</option>
            <option value='54000'>15</option>
            <option value='64800'>18</option>
            <option value='82800'>23</option>
        </select> час<br/>
        <input type="hidden" name='class' value='CatItem'/>
        <input type="submit" class='btn btn-primary' value='Сохранить' name='createNew'>
    </form>

    <h1>Все задания</h1>
>>>>>>> подчистил косяки с конфликтами

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