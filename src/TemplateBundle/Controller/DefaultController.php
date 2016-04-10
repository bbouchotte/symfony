<?php

namespace TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/homeTemplate", name="homeTemplate")
     */
    public function indexAction()
    {
        return $this->render('TemplateBundle:Default:index.html.twig');
    }
}
