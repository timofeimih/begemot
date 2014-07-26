<?php 

include('ParseBase.php');
class ParseCommand extends CConsoleCommand
{
<<<<<<< HEAD
<<<<<<< HEAD
    public function run()
    {
        echo "ok";
=======
    public function run($args)
    {

>>>>>>> Парсер и мелкие правки
=======
    public function run($args)
    {

>>>>>>> Парсер и планировщик
    	// Сообщение
		$message = "Line 1\nLine 2\nLine 3";

		// На случай если какая-то строка письма длиннее 70 символов мы используем wordwrap()
		$message = wordwrap($message, 70);

		// Отправляем
		mail('timofeimih@gmail.com', 'My Subject', $message);

<<<<<<< HEAD
<<<<<<< HEAD
    	$n = new CrontabBase();
=======
    	$n = new ParseBase();
>>>>>>> Парсер и мелкие правки
=======
    	$n = new CrontabBase();
>>>>>>> Парсер и планировщик

    	$n->runAll();

    }
<<<<<<< HEAD
<<<<<<< HEAD

=======
>>>>>>> Парсер и мелкие правки
}
=======
}
>>>>>>> Парсер и планировщик
