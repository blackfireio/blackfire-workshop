<?php

namespace AppBundle\Utils;

class SpamValidator implements SpamValidatorInterface
{
    const MAX_SCORE = 5;

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
        $score = strlen($contents);
        $score = $this->sanitizeScore($score);

        return $score;
    }

    /**
     * @param int $score
     *
     * @return int
     */
    private function sanitizeScore($score)
    {
        $final = 0;
        for ($i = 0; $i < self::MAX_SCORE; ++$i) {
            $final = $score == 0 ? 1 : $score * $this->sanitizeScore($score - 1);
        }

        return $final;
    }
}
