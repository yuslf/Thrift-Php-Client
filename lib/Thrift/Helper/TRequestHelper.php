<?php

namespace Thrift\Helper;

use Thrift\ClassLoader\ThriftClassLoader;

class TRequestHelper
{
    protected static $loader;

    protected static $baseDir;

    protected static $namespace;

    protected static $client;

    protected static $protocol;

    protected static $transport;

    public function initLoader($namespace, $baseDir)
    {
        static::$baseDir = $baseDir;
        static::$namespace = $namespace;

        $loader = new ThriftClassLoader();
        $loader->registerNamespace($namespace, $baseDir . '/gen-php');
        $loader->registerDefinition($namespace, $baseDir . '/gen-php');
        $loader->register();

        static::$loader = $loader;

        return static::$loader;
    }

}
