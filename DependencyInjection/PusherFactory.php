<?php

namespace Lopi\Bundle\PusherBundle\DependencyInjection;

use Pusher;

class PusherFactory
{
    public static function create(array $config)
    {
        return new Pusher(
            $config['key'],
            $config['secret'],
            $config['app_id'],
            [
                'cluster' => $config['cluster'],
                'encrypted' => $config['encrypted'],
                'timeout' => $config['timeout'],
                'debug' => $config['debug'],
            ]
        );
    }
}
