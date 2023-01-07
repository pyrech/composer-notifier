<?php

/*
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
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Joli\JoliNotif\Notification;
use Joli\JoliNotif\Notifier;
use Joli\JoliNotif\NotifierFactory;

class NotifierPlugin implements PluginInterface, EventSubscriberInterface
{
    protected ?Composer $composer = null;
    private ?Notifier $notifier;

    public function __construct(Notifier $notifier = null)
    {
        $this->notifier = $notifier ?: NotifierFactory::create();
    }

    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => [
                ['postInstall', -10000],
            ],
            ScriptEvents::POST_UPDATE_CMD => [
                ['postUpdate', -10000],
            ],
        ];
    }

    public function postInstall(Event $event): void
    {
        $this->notify('Composer just finished the install command');
    }

    public function postUpdate(Event $event): void
    {
        $this->notify('Composer just finished the update command');
    }

    private function getProjectName(): string
    {
        return $this->composer->getPackage()->getName();
    }

    private function notify(string $body): void
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
