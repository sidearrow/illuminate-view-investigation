<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;

require __DIR__ . '/vendor/autoload.php';

$cacheDir = __DIR__ . '/data/cache';

$filesystem = new Filesystem();
$bladeCompiler = new BladeCompiler($filesystem, $cacheDir);

$bladeCompiler->compile('./template/index.blade.php');