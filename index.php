<?php

require __DIR__ . '/vendor/autoload.php';

$run     = new \Whoops\Run;
$handler = new \Whoops\Handler\PrettyPageHandler;

// Usually you don't have exact path on your remote machine like on your local.
// Anyway, in setEditor you may done your own, project-specific logic, but what i gave here should be also not bad
$translations = array('^' . __DIR__ => '~/Development/PhpStormOpener');

$handler->setEditor(
    function ($file, $line) use ($translations) {

        foreach ($translations as $from => $to) {
            $file = preg_replace('#' . $from . '#', $to, $file, 1);
        }

        return "pstorm://$file:$line";
    }
);

$JsonHandler = new \Whoops\Handler\JsonResponseHandler;

$run->pushHandler($JsonHandler);
$run->pushHandler($handler);
$run->register();

// Do something bad to call Whoops spirit and to show us some stack trace
require __DIR__ . '/demo.php';