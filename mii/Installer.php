<?php

namespace MII;

use Composer\Script\Event;

class Installer
{
    public static function postCreateProject(Event $event)
    {
        $io = $event->getIO();
        $io->write("Setting up your MII project...");

        // Example: Copy .env.example to .env
        copy('.env.example', '.env');

        // Additional setup steps...
    }
}
