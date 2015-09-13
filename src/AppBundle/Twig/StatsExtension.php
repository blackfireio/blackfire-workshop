<?php

namespace AppBundle\Twig;

use Doctrine\Bundle\DoctrineBundle\Registry;

class StatsExtension extends \Twig_Extension
{
    private $stats;

    public function __construct(Registry $doctrine)
    {
        $this->stats = array(
            'posts' => count($doctrine->getRepository('AppBundle:Post')->findAll()),
            'comments' => count($doctrine->getRepository('AppBundle:Comment')->findAll()),
        );
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
        return $this->stats['posts'];
    }

    public function getCommentsCountStats()
    {
        return $this->stats['comments'];
    }

    public function getName()
    {
        return 'app.stats_extension';
    }
}
