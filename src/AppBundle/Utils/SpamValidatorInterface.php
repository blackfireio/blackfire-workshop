<?php

namespace AppBundle\Utils;

interface SpamValidatorInterface
{
    /**
     * @param string $contents
     *
     * @return bool
     */
    public function validate($contents);
}
