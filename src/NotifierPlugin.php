<?php

/**
 * This file is part of the composer-notifier project.
 *
 * (c) Loïck Piera <pyrech@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pyrech\ComposerNotifier;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\CommandEvent;
use Composer\Script\ScriptEvents;
use Joli\JoliNotif\Notification;
use Joli\JoliNotif\Notifier;
use Joli\JoliNotif\NotifierFactory;

class NotifierPlugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * @var Notifier
     */
    private $notifier;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->notifier = NotifierFactory::create();
        $this->composer = $composer;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ScriptEvents::POST_INSTALL_CMD => array(
                array('postInstall', 0),
            ),
            ScriptEvents::POST_UPDATE_CMD => array(
                array('postUpdate', 0),
            ),
        );
    }

    /**
     * @param CommandEvent $event
     */
    public function postInstall(CommandEvent $event)
    {
        $this->notify('Composer just finished the install command');
    }

    /**
     * @param CommandEvent $event
     */
    public function postUpdate(CommandEvent $event)
    {
        $this->notify('Composer just finished the update command');
    }

    /**
     * @return string
     */
    private function getProjectName()
    {
        return $this->composer->getPackage()->getName();
    }

    /**
     * @param string $body
     */
    private function notify($body)
    {
        if (!$this->notifier) {
            return;
        }

        $notification =
            (new Notification())
                ->setTitle($this->getProjectName())
                ->setBody($body)
                ->setIcon(__DIR__ . '/../Resources/logo.png')
        ;

        $this->notifier->send($notification);
    }
}
