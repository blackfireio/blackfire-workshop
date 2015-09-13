<?php

namespace AppBundle\Composer;

use Sensio\Bundle\GeneratorBundle\Manipulator\Manipulator;
use Symfony\Component\Finder\Finder;

class XhprofPatcher extends Manipulator
{
    private $originalDirectory;

    public function __construct($originalDirectory)
    {
        $this->originalDirectory = $originalDirectory;
    }

    public function patch($directory)
    {
        $files = Finder::create()->ignoreDotFiles(false)->files()->name('*.php')->in($directory);

        foreach ($files as $file) {
            $this->patchFile($file);
        }
    }

    private function patchFile($file)
    {
        $content = file_get_contents($file);
        $src = file($file);
        $this->setCode(token_get_all($content), 0);
        while ($token = $this->next()) {
            if (T_VARIABLE !== $token[0] || '$GLOBALS' !== $token[1]) {
                continue;
            }

            // [
            $_ = $this->next();
            if ('[' !== $_) {
                continue;
            }

            $_ = $this->next();
            if (T_CONSTANT_ENCAPSED_STRING !== $_[0] || "'UPROFILER_LIB_ROOT'" != $_[1]) {
                continue;
            }

            // ]
            $_ = $this->next();
            if (']' !== $_) {
                continue;
            }

            // =
            $_ = $this->next();
            if ('=' !== $_) {
                continue;
            }

            //this is an assignation, replace the line.
            $lines = array_merge(
                array_slice($src, 0, $token[2] - 1),
                // Appends a separator comma to the current last position of the array
                array(sprintf("\$GLOBALS['UPROFILER_LIB_ROOT'] = '%s';\n", $this->originalDirectory)),
                array_slice($src, $token[2])
            );

            file_put_contents($file, implode('', $lines));

            return true;
        }
    }
}
