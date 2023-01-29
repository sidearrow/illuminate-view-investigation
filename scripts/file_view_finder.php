<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\FileViewFinder;

require __DIR__ . '/../vendor/autoload.php';

$templateDir = __DIR__ . '/template/';

$filesystem = new Filesystem();
$fileViewFinder = new FileViewFinder($filesystem, [$templateDir]);

$viewLocation = $fileViewFinder->find('index');
assert($templateDir . 'index.blade.php' === $viewLocation);

$viewLocation = $fileViewFinder->find('dir.index');
assert($templateDir . 'dir/index.blade.php' === $viewLocation);