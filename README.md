PhpStormOpener
===============

**NOTE:**
As of May 16 there are built-in idea:// and phpstorm:// protocols support in PhpStorm 8 EAP 138.190+ [according to this comment from phpstorm team member](http://youtrack.jetbrains.com/issue/IDEA-65879#comment=27-736256).

You can add new url schema support by changing url format:

```php
$handler = new \Whoops\Handler\PrettyPageHandler;

// Usually you don't have exact path on your remote machine like on your local.
// Anyway, in setEditor you may done your own, project-specific logic,
// but what i gave here should be also not bad for start.
$translations = array('^' . __DIR__ => '~/Development/PhpStormOpener');

$handler->setEditor(
    function ($file, $line) use ($translations) {

        foreach ($translations as $from => $to) {
            $file = preg_replace('#' . $from . '#', $to, $file, 1);
        }

        // return "pstorm://$file:$line"; // old way
        return "phpstorm://open?file=$file&line=$line"; // as of PhpStorm 8 EAP 138.190+, without my app
        // "idea://open?file=$file&line=$line"; // alternative way, as of PhpStorm 8 EAP 138.190+, without my app

    }
);
```

## Description

Add pstorm:// protocol support to Mac OS X to open local files in phpstorm from web. Originally designed to be used with
[Whoops](https://github.com/filp/whoops) handler but in general may be used separately, the only requirement is valid file path in pstorm:// link.

I made this app due to lack of pstorm:// protocol or any other, which allow you to open files in PhpStorm on Mac OS X.

To windows and linux users: sorry, I'm not familiar with that OS systems (at least at level to handle third-parties
protocols). If you find a way how to done that - just make a pull request with solution.

## Installation

0. Register command-line launcher in PhpStorm (Tools -> Create Command-line Launcher menu)

1. Place PhpStormOpener to your Application directory (global or local, it's up to you), it's not a hardcore requirement,
you may keep application where it is.

2. On first pstorm:// link click browser will ask you to associate application with protocol.
Associate with PhpStormOpener and don't forget to check "Remember my choice for pstorm links".

3. Allow PhpStormOpener to be run, while it is not from "Apple Trusted Developer". Fast solution is to manually run
PhpStormOpener and confirm in dialog that you really want to run this app and you trust to it.

4. Register editor in Whoops. See section below. You may run index.php for demo.

5. Enjoy it.

## Registering PhpStorm editor

```php
$handler = new \Whoops\Handler\PrettyPageHandler;

// Usually you don't have exact path on your remote machine like on your local.
// Anyway, in setEditor you may done your own, project-specific logic,
// but what i gave here should be also not bad for start.
$translations = array('^' . __DIR__ => '~/Development/PhpStormOpener');

$handler->setEditor(
    function ($file, $line) use ($translations) {

        foreach ($translations as $from => $to) {
            $file = preg_replace('#' . $from . '#', $to, $file, 1);
        }

        return "pstorm://$file:$line";
    }
);
```

## About software

It's written in Apple Script, so anyone can see it source code and tweak to their needs. I'm not professional Mac OS X
developer, so if something done in non-standard way just let me know.

## License, copyright

This software licensed under MIT license (see LICENSE file)

Copyright (c) 2013 Bogdan Padalko
