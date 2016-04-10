<?php

namespace TestingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/testing", name="testing")
     */
    public function indexAction()
    {
        return $this->render('TestingBundle:Default:index.html.twig');
    }
}
