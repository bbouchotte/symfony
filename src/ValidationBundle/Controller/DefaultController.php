<?php

namespace ValidationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ValidationBundle\Entity\Author;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\AuthorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

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
    	$author = new Author;
    	$form = $this->createForm(AuthorType::class, $author);
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		return $this->redirectToRoute('validationUpdate');
    	}
    	return $this->render('ValidationBundle:Default:validationUpdate.html.twig', array(
    			'form' => $form->createView(),
    	));
    }
    
    /**
     * @Route("/translation", name="translation") 
     */
    public function translationAction() {
    	return $this->render('ValidationBundle:Default:translation.html.twig');
    }
    
    /**
     * @Route("/addEmail/{email}", name="addEmail")
     */
    public function addEmailAction($email)
    {
    	$emailConstraint = new Assert\Email();
    	// all constraint "options" can be set this way
    	$emailConstraint->message = 'Invalid email address';
    	
    	// use the validator to validate the value
    	$errorList = $this->get('validator')->validate(
    			$email,
    			$emailConstraint
    			);
    
    	if (0 === count($errorList)) {
    		// ... this IS a valid email address, do something
    		return new Response('Email is valid.');
    	} else {
    		// this is *not* a valid email address
    		$errorMessage = $errorList[0]->getMessage();
    
    		// ... do something with the error
    		return new Response('Email isn\'t valid.<br />' . var_dump($errorList));
    	}
    
    	// ...
    }
}
