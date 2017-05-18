<?php

namespace Lopi\Bundle\PusherBundle\Tests\DependencyInjection;

use Lopi\Bundle\PusherBundle\DependencyInjection\LopiPusherExtension;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * PusherTest
 *
 * @author Pierre-Louis Launay <laupi.frpar@gmail.com>
 */
class PusherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the load of the configuration
     */
    public function testLoad()
    {
        $container = new ContainerBuilder();
        $configs = [
            'lopi_pusher' => [
                'app_id' => 'app_id',
                'key' => 'key',
                'secret' => 'secret',
                'auth_service_id' => 'acme_service_id',
            ],
        ];
        $extension = new LopiPusherExtension();
        $extension->load($configs, $container);

        $this->assertInstanceOf('Pusher', $container->get('lopi_pusher.pusher'));
        $this->assertEquals('app_id', $container->getParameter('lopi_pusher.config')['app_id']);
        $this->assertEquals('key', $container->getParameter('lopi_pusher.config')['key']);
        $this->assertEquals('secret', $container->getParameter('lopi_pusher.config')['secret']);
        $this->assertEquals('us-east-1', $container->getParameter('lopi_pusher.config')['cluster']);
        $this->assertEquals('acme_service_id', $container->getParameter('lopi_pusher.config')['auth_service_id']);
        $this->assertEquals(30, $container->getParameter('lopi_pusher.config')['timeout']);
        $this->assertFalse($container->getParameter('lopi_pusher.config')['debug']);
        $this->assertEquals('acme_service_id', (string) $container->getAlias('lopi_pusher.authenticator'));
    }

    /**
     * Test the load of the configuration with custom config
     */
    public function testLoadWithConfig()
    {
        $container = new ContainerBuilder();
        $configs = [
            'lopi_pusher' => [
                'app_id' => '12345',
                'key' => '54321',
                'secret' => 'thisisasecret',
                'cluster' => 'cluster',
                'timeout' => 60,
                'debug' => true,
                'auth_service_id' => 'acme_service_id',
            ],
        ];
        $extension = new LopiPusherExtension();
        $extension->load($configs, $container);

        $pusher = $container->get('lopi_pusher.pusher');
        $pusherSettings = $pusher->getSettings();

        $this->assertInstanceOf('Pusher', $pusher);
        $this->assertEquals('12345', $pusherSettings['app_id']);
        $this->assertEquals('54321', $pusherSettings['auth_key']);
        $this->assertEquals('thisisasecret', $pusherSettings['secret']);
        $this->assertEquals(60, $pusherSettings['timeout']);
        $this->assertTrue($pusherSettings['debug']);
        $this->assertEquals('acme_service_id', (string) $container->getAlias('lopi_pusher.authenticator'));
    }

    public function testNotFullyConfiguration()
    {
        $this->expectException(InvalidConfigurationException::class);
        $container = new ContainerBuilder();
        $configs = [
            'lopi_pusher' => [
                'cluster' => 'cluster',
                'debug' => true,
                'auth_service_id' => 'acme_service_id',
            ],
        ];
        $extension = new LopiPusherExtension();
        $extension->load($configs, $container);
    }
}
