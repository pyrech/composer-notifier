<?php

/*
 * This file is part of the composer-notifier project.
 *
 * (c) Loïck Piera <pyrech@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pyrech\ComposerNotifier\tests;

use Composer\Composer;
use Composer\Factory;
use Composer\IO\BufferIO;
use Composer\Package\Package;
use Composer\Script\ScriptEvents;
use Joli\JoliNotif\Notifier;
use PHPUnit\Framework\TestCase;
use Pyrech\ComposerNotifier\NotifierPlugin;

class NotifierPluginTest extends TestCase
{
    private Composer $composer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->composer = Factory::create(new BufferIO());
    }

    public function testItIsRegisteredAndActivated()
    {
        $plugin = new NotifierPlugin();

        $pluginManager = $this->composer->getPluginManager();
        $pluginManager->addPlugin($plugin, false, new Package('pyrech/composer-notifier', '1', 'v1'));

        $this->assertSame([$plugin], $this->composer->getPluginManager()->getPlugins());
    }

    public function testEventsAreHandled()
    {
        $notifier = $this->createMock(Notifier::class);

        $notifier
            ->expects($this->exactly(1))
            ->method('send')
            ->willReturn(true)
        ;

        $plugin = new NotifierPlugin($notifier);

        $pluginManager = $this->composer->getPluginManager();
        $pluginManager->addPlugin($plugin, false, new Package('pyrech/composer-notifier', '1', 'v1'));

        $this->composer->getEventDispatcher()->dispatchScript(ScriptEvents::POST_INSTALL_CMD);
    }
}
