<?php

class ParseCommand extends CConsoleCommand
{
    public function run($args)
    {

        $n = new JobManager();

        $n->runAll();

        echo "ok";

    }

}
