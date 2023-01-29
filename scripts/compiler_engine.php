<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;

require __DIR__ . '/../vendor/autoload.php';

$cacheDir = __DIR__ . '/cache/';
$templateDir = __DIR__ . '/template/';

$filesystem = new Filesystem();
$bladeCompiler = new BladeCompiler($filesystem, $cacheDir);
$compilerEngine = new CompilerEngine($bladeCompiler, $filesystem);

$contents = $compilerEngine->get($templateDir . 'index.blade.php', ['color' => 'red']);

echo $contents;