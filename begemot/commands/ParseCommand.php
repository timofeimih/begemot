<?php 

include('ParseBase.php');
class ParseCommand extends CConsoleCommand
{
    public function run($args)
    {

    	// Сообщение
		$message = "Line 1\nLine 2\nLine 3";

		// На случай если какая-то строка письма длиннее 70 символов мы используем wordwrap()
		$message = wordwrap($message, 70);

		// Отправляем
		mail('timofeimih@gmail.com', 'My Subject', $message);

    	$n = new CrontabBase();

    	$n->runAll();

    }
}