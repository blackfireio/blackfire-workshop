<?php

namespace AppBundle\EventListener;

use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Bundle\FrameworkBundle\Command\ServerRunCommand;

/**
 * Defines the method that 'listens' to the 'console.command' event, which is
 * triggered whenever a command is executed in the application, to display the
 * true reachable adress to ease Docker dev.
 *
 * @author Tugdual Saunier <tucksaun@gmail.com>
 */
class ServerRunListener
{
    public function listenForServerRunCommand(ConsoleCommandEvent $event)
    {
        if (!$event->getCommand() instanceof ServerRunCommand) {
            return;
        }

        $argv = $_SERVER['argv'];
        if (count($argv) < 3) {
            return;
        }
        // strip the application name
        array_shift($argv);
        // strip the command name
        array_shift($argv);

        $address = $argv[0];
        if (0 !== strpos($address, '0.0.0.0')) {
            return;
        }

        $address = str_replace('0.0.0.0', $this->getLocalIp(), $address);
        $output = $event->getOutput();
        $output->writeln(sprintf('If you are in a container you would probably prefer to use: <info>http://%s</info>', $address));

        if (function_exists('uprofiler_enable')) {
            $output->writeln(sprintf('XHProf UI: <info>http://%s/xhprof</info>', $address));
        }
        $output->writeln('');
    }

    private function getLocalIp()
    {
        return gethostbyname(gethostname());
    }
}
