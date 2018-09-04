<?php

namespace Thrift\Helper;

use Thrift\Transport\TSocket;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TFramedTransport;

class TBinSocketRequestHelper extends TRequestHelper
{
    protected static $ip;

    protected static $port;

    protected static $socket;

    public static function initClient($ip, $port)
    {
        if (empty(static::$namespace)) {
            throw new \Exception('没有设置Thrift客户端命名空间，请先调用 initLoader 方法！');
            return false;
        }

        static::$ip = $ip;
        static::$port = $port;

        static::$socket = new TSocket(static::$ip, static::$port);
        static::$transport = new TFramedTransport(static::$socket);

        static::$protocol = new TBinaryProtocol(static::$transport);

        $namespace = explode("\\", static::$namespace);

        $client = static::$namespace . "\\" . $namespace[count($namespace) - 1] . 'Client';

        if (! class_exists($client)) {
            throw new \Exception('Thrift客户端不存在，请先调用 initLoader 方法！');
            return false;
        }

        static::$client = new $client(static::$protocol);

        return true;
    }

    public static function getTransport()
    {
        return static::$transport;
    }

    public static function getClient()
    {
        return static::$client;
    }

    public static function __callStatic($func, $args)
    {
        if (empty(static::$client)) {
            throw new \Exception('Thrift客户端不存在，请先调用 initLoader 和 initClient 方法！');
            return false;
        }

        if (! method_exists(static::$client, $func)) {
            throw new \Exception('Thrift客户端方法:' . $func . ' 不存在！');
            return false;
        }

        $is_once = ! static::$transport->isOpen();

        if ($is_once) {
            static::$transport->open();
        }

        $ret = call_user_func_array(array(static::$client, $func), $args);

        if ($is_once) {
            static::$transport->close();
        }

        return $ret;
    }

    public static function open()
    {
        if (! static::$transport->isOpen()) {
            static::$transport->open();
        }

        return true;
    }

    public static function close()
    {
        if (static::$transport->isOpen()) {
            static::$transport->close();
        }

        return true;
    }
}
