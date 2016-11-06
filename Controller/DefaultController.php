<?php

namespace DanCostinel\ServiceInfoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/dancostinel", "dancostinel_route")
     */
    public function indexAction()
    {
        return $this->render('DanCostinelServiceInfoBundle:Default:index.html.twig');
    }
}
