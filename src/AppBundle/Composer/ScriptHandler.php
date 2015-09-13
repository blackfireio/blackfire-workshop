<?php

namespace AppBundle\Composer;

use Composer\Script\CommandEvent;
use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as SymfonyScriptHandler;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ScriptHandler extends SymfonyScriptHandler
{
    public static function installXhprofGui(CommandEvent $event)
    {
        $options = static::getOptions($event);
        $webDir = $options['symfony-web-dir'];

        if (!static::hasDirectory($event, 'symfony-web-dir', $webDir, 'install XHProf GUI')) {
            return;
        }

        $rootDir = getcwd();
        $originDir = $rootDir.'/vendor/friendsofphp/uprofiler/uprofiler_html';

        $fs = new Filesystem();
        $symlink = false;
        if ($options['symfony-assets-install'] == 'symlink' || $options['symfony-assets-install'] == 'relative') {
            $symlink = true;
        }

        $targetDir = $webDir.DIRECTORY_SEPARATOR.'xhprof';
        $event->getIO()->write(sprintf('Installing XHProf GUI into <comment>%s</comment>', $targetDir));

        $fs->remove($targetDir);

        if ($symlink) {
            if ($options['symfony-assets-install'] == 'relative') {
                $relativeOriginDir = $fs->makePathRelative($originDir, realpath($webDir));
            } else {
                $relativeOriginDir = $originDir;
            }

            try {
                $fs->symlink($relativeOriginDir, $targetDir);
                if (!file_exists($targetDir)) {
                    throw new IOException('Symbolic link is broken');
                }
                $event->getIO()->write('XHProf GUI was installed using symbolic links.');
            } catch (IOException $e) {
                $event->getIO()->write('It looks like your system doesn\'t support symbolic links, please change your options accordingly.');
            }
        } else {
            $fs->mkdir($targetDir, 0755);
            // We use a custom iterator to ignore VCS files
            $fs->mirror($originDir, $targetDir, Finder::create()->ignoreDotFiles(false)->in($originDir));

            $patcher = new XhprofPatcher($fs->makePathRelative(realpath($originDir.'/../uprofiler_lib'), realpath($targetDir)));
            $patcher->patch($targetDir);
        }
    }
}
