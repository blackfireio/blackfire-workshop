<?php

namespace AppBundle\Mocks\Utils;

use AppBundle\Utils\SpamValidatorInterface;

class SpamValidator implements SpamValidatorInterface
{
    /**
     * @param string $contents
     *
     * @return bool
     */
    public function validate($contents)
    {
        return true;
    }
}
