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
        $doctrine = $this->getDoctrine();

        return $this->render('admin/index.html.twig', array(
            'posts_count' => $doctrine->getRepository('AppBundle:Post')->getTotalCount(),
            'comments_count' => $doctrine->getRepository('AppBundle:Comment')->getTotalCount(),
        ));
    }
}
