<?php
require_once './vendor/autoload.php';

use Thrift\Helper\TBinSocketRequestHelper;

$h = new TBinSocketRequestHelper();
$h->loader('Rpc\HelloSwoole', base_path() . '/IDL')
  ->client('127.0.0.1', '8091');
$message = $h->struct('Message', array('send_uid' => 350749960, 'name' => 'rango'));
$a = $h->sendMessage($message);
var_dump($a);
