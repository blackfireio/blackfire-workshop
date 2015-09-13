<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Post;

/**
 * @Route("/admin")
 * @Security("has_role('ROLE_ADMIN')")
 */
class DashboardController extends Controller
{
    /**
     * @Route("/", name="admin_index")
     *
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commentsCount = $postsCount = 0;
        foreach ($em->getRepository('AppBundle:Post')->findAll() as $post) {
            ++$postsCount;
            $commentsCount += count($post->getComments());
        }

        return $this->render('admin/index.html.twig', array(
            'posts_count' => $postsCount,
            'comments_count' => $commentsCount,
        ));
    }
}
