<?php

namespace ValidationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ValidationBundle\Entity\Author;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\AuthorType;


class DefaultController extends Controller
{
    /**
     * @Route("/validation", name="validation")
     */
    public function indexAction()
    {
        return $this->render('ValidationBundle:Default:index.html.twig');
    }
    
    /**
     * @Route("/validatorService", name="validatorService")
     */
    public function validatorServiceAction() {
    	$author = new Author;
    	$author->name = '';
    	//$author->name = 'sdfgsdfg';
    	
    	$validator = $this->get('validator');
    	$errors = $validator->validate($author);
    	if (count($errors) > 0) {
    		//return new Response((string) $errors);
    		return $this->render('ValidationBundle:Default:validatorService.html.twig', array(
    			'errors' => $errors
    		));
    	}
    	return new Response('The author is valid!');
    }
    
    /**
     * @Route("/validationUpdate", name="validationUpdate")
     */
    public function validationUpdateAction(Request $request) {
    	$author = new $author;
    	$form = $this->createForm(AuthorType::class, $author);
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		return $this->redirectToRoute('validationUpdate');
    	}
    	return $this->render('ValidationBundle:Default:validationUpdate.html.twig', array(
    			'form' => $form->createView(),
    	));
    }
    
}
