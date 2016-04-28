<?php

namespace FormsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FormsBundle\Entity\Task;
use FormsBundle\Form\TaskType;
use FormsBundle\Entity\Personage;
use FormsBundle\Form\PersonageType;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/forms", name="forms")
     */
    public function indexAction()
    {
        return $this->render('FormsBundle:Default:index.html.twig');
    }
    
    /**
     * @Route("/buildingForms", name="buildingForms")
     */
    public function buildingFormsAction(Request $request) {
    	$task = new Task();
    	$task->setTask('Write a blog post');
    	$task->setDueDate(new \DateTime('tomorrow'));
    	
    	$form = $this->createFormBuilder($task, array(
    		'validation_groups' => array('default', 'registration'),
    	))
    	->add('task', TextType::class)
    	->add('dueDate', DateType::class)
    	->add('save', SubmitType::class, array('label' => 'Create Task'))
    	->add('saveAndAdd', SubmitType::class, array('label' => 'Save and Add'))
    	->getForm();
    	
    	$form->handleRequest($request);
    	$validator = $this->get('validator');
    	$errors = $validator->validate($task);
    	
    	if ($form->isSubmitted() && $form->isValid()) {
    		// ... perform some action, such as saving the task to the database
    	
    		//return $this->redirectToRoute('task_success');
    		if ($form->get('save')->isClicked()) {
    			return new Response('Add task successfull.');
    		} else {
    			return new Response('Save task successfull.');
    		}
    	}
    	
    	return $this->render('FormsBundle:Default:new.html.twig', array(
    		'form' => $form->createView(),
    		'errors' => $errors,
    	));	// createView() should be called after handleRequest is called.
    }
    
    /**
     * @Route("/formClasses", name="formClasses")
     */
    public function formClassesAction(Request $request) {
    	$task = new Task;
    	$form = $this->createForm(TaskType::class, $task);
    	$form->handleRequest($request);
    	
    	$validator = $this->get('validator');
    	$errors = $validator->validate($task);    	 
    	if ($form->isSubmitted() && $form->isValid()) {
    		// ... perform some action, such as saving the task to the database
    		 
    		//return $this->redirectToRoute('task_success');
    		if ($form->get('save')->isClicked()) {
    			return new Response('Add task successfull.');
    		} else {
    			return new Response('Save task successfull.');
    		}
    	}
    	return $this->render('FormsBundle:Default:new.html.twig', array(
    		'form' => $form->createView(),
    		'errors' => $errors,
    	));
    }

    /**
     * @Route("/service", name="service")
     */
    public function serviceAction(Request $request) {
    	$personage = new Personage;
    	$form = $this->createForm(PersonageType::class, $personage);
    	$form->handleRequest($request);
    	 
    	$validator = $this->get('validator');
    	$errors = $validator->validate($personage);
    	if ($form->isSubmitted() && $form->isValid()) {
    		// ... perform some action, such as saving the task to the database
    		 
    		//return $this->redirectToRoute('task_success');
    		if ($form->get('save')->isClicked()) {
    			$em = $this->getDoctrine()->getManager();
    			$em->persist($personage);
    			$em->flush();
    			return new Response('Add personage successfull.');
    		} else {
    			$em = $this->getDoctrine()->getManager();
    			$newPersonage = clone $personage;
    			$em->persist($newPersonage);
    			$em->flush();
    			return new Response('Save personage successfull.');
    		}
    	}
    	//return $this->render('FormsBundle:Default:new.html.twig', array(
    	return $this->render('FormsBundle:Default:new_with_form_theming.html.twig', array(
    			'form' => $form->createView(),
    			'errors' => $errors,
    	));
    }
    
}
