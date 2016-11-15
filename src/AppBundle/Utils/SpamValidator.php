<?php

namespace AppBundle\Utils;

class SpamValidator implements SpamValidatorInterface
{
    const MAX_SCORE = 25;

    /**
     * @param string $contents
     *
     * @return bool
     */
    public function validate($contents)
    {
        return $this->getContentsScore($contents) > self::MAX_SCORE;
    }

    /**
     * @param string $contents
     *
     * @return int
     */
    private function getContentsScore($contents)
    {
        return str_word_count($contents) / log(strlen($contents));
    }
}
