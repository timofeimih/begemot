<?php 

include('ParseBase.php');
class ParseCommand extends CConsoleCommand
{
<<<<<<< HEAD
    public function run()
    {
        echo "ok";
=======
    public function run($args)
    {

>>>>>>> Парсер и мелкие правки
    	// Сообщение
		$message = "Line 1\nLine 2\nLine 3";

		// На случай если какая-то строка письма длиннее 70 символов мы используем wordwrap()
		$message = wordwrap($message, 70);

		// Отправляем
		mail('timofeimih@gmail.com', 'My Subject', $message);

<<<<<<< HEAD
    	$n = new CrontabBase();
=======
    	$n = new ParseBase();
>>>>>>> Парсер и мелкие правки

    	$n->runAll();

    }
<<<<<<< HEAD

=======
>>>>>>> Парсер и мелкие правки
}