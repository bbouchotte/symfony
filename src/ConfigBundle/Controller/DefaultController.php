<?php

namespace ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/config", name="config")
     */
    public function indexAction()
    {
        return $this->render('ConfigBundle:Default:index.html.twig');
    }
}
