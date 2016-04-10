<?php

namespace BundleSystemBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/bundleSystem", name="bundleSystem")
     */
    public function indexAction()
    {
        return $this->render('BundleSystemBundle:Default:index.html.twig');
    }
}
