<?php
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$viewPaths = [];

$newHeader = <<<PHP
<?php

declare(strict_types = 1);
/**
 * @var \Slim\Views\PhpRenderer   \$this
 * @var string                    \$currentRoute
 * @var string                    \$currentRoutePattern
 * @var \RfcTool\Entity\User|null \$currentUser
 * @var \RfcTool\Util\ErrorStore  \$errorStore
 * @var \RfcTool\Util\Translator  \$translator
PHP;

$directoryIterator = new \RecursiveDirectoryIterator(ROOT_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'views');
$iterator          = new \RecursiveIteratorIterator($directoryIterator);
$regexIterator     = new \RegexIterator($iterator, '/^.+\.php$/i', \RegexIterator::GET_MATCH);
foreach ($regexIterator as $current) {
    $file        = $current[0];
    $viewPaths[] = realpath($file);
}
foreach ($viewPaths as $path) {

    $content = file_get_contents($path);
    $until   = ' */';
    while (true) {
        $firstLine = explode("\n", $content, 2)[0];
        $content   = substr($content, strpos($content, "\n") + 1);
        if ($until === $firstLine) {
            break;
        }
        if ('' === $content) {
            \RfcTool\Util\Debugger::debug($path);
            die('OMFG!!!');
        }
    }

    $content = $newHeader . PHP_EOL . $until . PHP_EOL . $content;

    file_put_contents($path, $content);
    echo $path . PHP_EOL;
}
