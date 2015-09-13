<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Comment;
use AppBundle\Utils\SpamValidator;
use AppBundle\Utils\SpamValidatorInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class CommentListener
{
    /**
     * @var SpamValidator
     */
    private $spamValidator;

    /**
     * @param SpamValidator $spamValidator
     */
    public function __construct(SpamValidatorInterface $spamValidator)
    {
        $this->spamValidator = $spamValidator;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Comment) {
            return;
        }

        if (!$this->spamValidator->validate($entity->getContent())) {
            throw new \InvalidArgumentException('Found a spam !');
        }
    }
}
