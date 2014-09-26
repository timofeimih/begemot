<?php

include('ParseBase.php');
class ParseCommand extends CConsoleCommand
{
    public function run()
    {

        $n = new CrontabBase();

        $n->runAll();

    }

}