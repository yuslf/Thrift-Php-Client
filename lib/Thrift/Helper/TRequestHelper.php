<?php

namespace Thrift\Helper;

use Thrift\ClassLoader\ThriftClassLoader;

class TRequestHelper
{
    protected $loader;

    protected $baseDir;

    protected $namespace;

    protected $client;

    protected $protocol;

    protected $transport;

    public function loader($namespace, $baseDir)
    {
        $this->baseDir = $baseDir;
        $this->namespace = $namespace;

        $loader = new ThriftClassLoader();
        $loader->registerNamespace($namespace, $baseDir . '/gen-php');
        $loader->registerDefinition($namespace, $baseDir . '/gen-php');
        $loader->register();

        $this->loader = $loader;

        return $this;
    }

    public function getLoader()
    {
        return $this->loader;
    }

}
