# illuminate/view の調査

## 環境

下記の環境で調査しました。

* PHP 8.2.1
* illuminate/view: 9.48

## 概要

view は主に下記のモジュールで構成されます。

* Compiler
* Engine
* EngineResolver
* Finder
* Factory
* ServiceProvider

## 各モジュールの説明

### Compiler

Compiler の役割
Blade を PHP にコンパイルします。

**Blade**

```php
@foreach ($items as $item)
  <div>{{ $item }}</div>   
@endforeach
```

**コンパイルされた PHP**

```php
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div><?php echo e($item); ?></div>   
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH ./template/index.blade.php ENDPATH**/ ?>
```

### Engine

CompilerEngine に渡された Compiler のキャッシュが有効な場合、キャッシュファイルから取得します。
キャッシュが期限切れかどうかは、以下の条件で判定し、期限切れの場合は再コンパイルします。
* CompilerEngine のプロパティに保持されたコンパイル済もしくは期限切れでないファイルのリストにない
* キャッシュファイルの更新時間が元ファイルの更新時間以降

### EngineResolver

CompilerEngine や PHPEngine, FileEngine を遅延初期化します。

```php
// register メソッドに初期化処理を Closure で渡す
$resolver->register('Name of engine', function () { /** Engine の初期化処理 */ });

// register メソッドで渡された関数をこの時点で実行する
$resolver->resolve();
```

### Finder

Finder は Blade ファイルが格納されるディレクトリや拡張子を解決し、ファイルのパスを生成します。

```php
$filesystem = new Filesystem();
$fileViewFinder = new FileViewFinder($filesystem, [$templateDir]);
$viewLocation = $fileViewFinder->find('index');
assert($templateDir . 'index.blade.php' === $viewLocation);
```

### Factory

Factory は上記の部品を組み合わせて操作します。基本的にはこの Factory クラスに登録されたメソッドを利用することになります。

### ServiceProvider

ServiceProvider は Factory やその他の部品をコンテナに登録します。

## Blade を単独で利用するライブラリの紹介

* https://github.com/ryangjchandler/standalone-blade

Blade 互換のコンパイラを提供するライブラリではなく、illuminate/view を単独で利用するライブラリです。