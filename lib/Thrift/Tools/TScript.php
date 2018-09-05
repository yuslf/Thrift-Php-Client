<?php
namespace Thrift\Tools;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class TScript
{
    public static function test(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        var_dump($vendorDir);
        var_dump(getcwd());
    }

    public static function test2(PackageEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
        var_dump($installedPackage);

        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        var_dump($vendorDir);
        var_dump(getcwd());
        // do stuff
    }
}
