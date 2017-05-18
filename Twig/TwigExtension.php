<?php

namespace Lopi\Bundle\PusherBundle\Twig;

class TwigExtension extends \Twig_Extension
{

    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('pusher_options', [$this, 'getPusherOptions'], [
                'is_safe' => ['html']
            ]),
        ];
    }

    /**
     * @return string
     */
    public function getPusherOptions()
    {
        $config = $this->config;
        $keys = ['key', 'cluster', 'encrypted'];
        return json_encode(array_map(function ($key) use ($config) {
            return [$key => $config[$key]];
        }, $keys));
    }


}
