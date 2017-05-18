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
            new \Twig_Function('pusherjs', [$this, 'getPusherJs'], [
                'is_safe' => 'html'
            ])
        ];
    }

    public function getPusherJs()
    {
        return sprintf(
            "new Pusher('%s', {cluster: '%s', encrypted: %s});",
            $this->config['key'],
            $this->config['cluster'],
            $this->config['encrypted'] ? 'true' : 'false'
        );
    }


}
