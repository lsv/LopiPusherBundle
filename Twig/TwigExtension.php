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

        $output = [];
        foreach ($keys as $key) {
            $output[$key] = $config[$key];
        }

        return json_encode($output);
    }


}
