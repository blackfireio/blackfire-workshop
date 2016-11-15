<?php

namespace AppBundle\Twig;

use Doctrine\Bundle\DoctrineBundle\Registry;

class StatsExtension extends \Twig_Extension
{
    private $doctrine;
    private $stats;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('stats_posts_count', array($this, 'getPostsCountStats'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('stats_comments_count', array($this, 'getCommentsCountStats'), array('is_safe' => array('html'))),
        );
    }

    public function getPostsCountStats()
    {
        if (!isset($this->stats['posts'])) {
            $this->stats['posts'] = $this->doctrine->getRepository('AppBundle:Post')->getTotalCount();
        }

        return $this->stats['posts'];
    }

    public function getCommentsCountStats()
    {
        if (!isset($this->stats['comments'])) {
            $this->stats['comments'] = $this->doctrine->getRepository('AppBundle:Comment')->getTotalCount();
        }

        return $this->stats['comments'];
    }

    public function getName()
    {
        return 'app.stats_extension';
    }
}
