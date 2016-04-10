<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;		// accés aux services via $this->get(*) 
																// *:templating, router, mailer..
																// lister les services: php bin/console debug:container
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

// utiliser jsonresponse
use Symfony\Component\HttpFoundation\JsonResponse;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/{param}", name="lucky")
     */
    public function numberAction($param, Request $request)
    {
    	if ($param == 'response') 
    	{
	        $number = rand(0, 100);
	
	        return new Response(
	            '<html><body>Lucky number: '.$number.'</body></html>'
	        );
    	}
    	elseif ($param == 'json'){
    		$data = array(
    				'lucky_number' => rand(0, 100),
    		);
    		
    		return new Response(
    				json_encode($data),
    				200,
    				array('Content-Type' => 'application/json')
    				);
    	} elseif ($param == 'jsonresponse'){			// méthode raccourcie
    		$data = array(
    				'lucky_number' => rand(0, 100),
    		);
    		
    		// calls json_encode and sets the Content-Type header
    		return new JsonResponse($data);
    	} else {
    		$param = (int) $param;
    		if (is_int($param)) {
	    		$numbers = array();
	    		for ($i = 0; $i < $param; $i++) {
	    			$numbers[] = rand(0, 100);
	    		}
	    		$numbersList = implode(', ', $numbers);
	    		
	    		return new Response(
	    				'<html><body>Lucky numbers: '.$numbersList.'</body></html>'
	    				);
    		}
    	}
    	
    }
    
    /**
     * @Route("/luck/{param}")
     */
    public function twigAction($param = 2, Request $request) {
    	$numbers = array();
    	for ($i = 0; $i < $param; $i++) {
    		$numbers[] = rand(0, 100);
    	}
    	$numbersList = implode(', ', $numbers);
    	
    	/*$html = $this->container->get('templating')->render(
    			'lucky/number.html.twig',
    			array('luckyNumberList' => $numbersList)
    			);
    	
    	return new Response($html);*/
    	
    	return $this->render(
    		'lucky/number.html.twig',
    		array('luckyNumberList' => $numbersList)
    	); 
    /*	return $this->render( 	// ça ne fonctionne pas mais je ne sais pas pourquoi
    			'AppBundle:Lucky:number.html.twig',
    			array('luckyNumberList' => $numbersList)
    			); */
    }
    
    /**
     * @Route("/redirect/{param}")
     */
    public function redirectAction($param) {
    	if ($param == 'home') {
    		return $this->redirectToRoute('homepage');
    		// Equivalent à 
    		// return new RedirectResponse($this->generateUrl('homepage'));
    	}
    	elseif ($param == 'doc') {
    		return $this->redirect('https://symfony.com/doc/current/book/controller.html#redirecting');
    	}
    	elseif ($param == 'method') {
    		// 302 par défaut (temporaire). Effectue une redirection permanente:
    		return $this->redirectToRoute('homepage', array(), 301);
    	}
    }
    
    ////////		Managing Errors and 404 Pages		////////
    
    /**
     * @Route("/cherche/{code}/{param}")
     */
    public function errorAction($param, $code) {
    	$message = 'Vous n\'avez rien trouvé!';
    	if($param != 'nonos') {
	    	if ($code == 404) {		// erreur 404
	    		throw $this->createNotFoundException($message);
	    	}
	    	elseif ($code == 500) {
	    		throw new \Exception($message);
	    	}
    	}

	    	return new Response('<html><body><h2>Bravo!!</h2><p>Vous avez trouvé le nonos</p></body></html>');

    }
    
    ////////		Managing the session & Flash Message		////////
    
    /**
     * @Route("/session/{prenom}")
     */
    public function indexAction($prenom, Request $request) {
    	
    	$session = $request->getSession();
   		$text = 'Bonjour ' . $prenom .'!';
   		
   		if(null !== $session->get('prenom')) {
    		if($session->get('prenom') == $prenom) {
    			$text = 'Encore toi ' . $prenom .'!';
    		}
    		else {
    			$session->set('prenom', $prenom);
    		}
    	} 
    	else {
    		$session->set('prenom', $prenom);
    	}
    	$this->addFlash(
    		'login',
    		$text
    	);
    	return $this->render(
    		'lucky/login.html.twig',			// Voir la récupération du message Flash dans login.html.twig
    		array('messageFlash' => $text)
    	);
    }
    
    ////////		The Response Object		////////
    /**
     * @Route("response/{param}")
     */
    public function responseAction($param) {
    	
    	$name = 'Monsieur Machin';
    	if ($param == 'simple') {
    		// create a simple Response with a 200 status code (the default)
	    	$response = new Response('Hello '.$name, Response::HTTP_OK);
    	}
    	elseif ($param == "json") {
    		// create a JSON-response with a 200 status code
    		$response = new Response(json_encode(array('name' => $name)));
    		$response->headers->set('Content-Type', 'application/json');
    	}
    	return $response;
    }
    
    ////////		Forwarding to Another Controller		////////
    /**
     * @Route("/forward")
     */
    public function forwardAction() {
    	$response = $this->forward(
    		'AppBundle:Lucky:index',			// Sauf que là c'est le même controleur mais bon.
    		array(
    			'prenom' => 'Celui qui peut venir d\'un autre controleur'
    		)
    	);
    	return $response;
    }
    

}

////////		Validating a CSRF Token		////////
/*
if ($this->isCsrfTokenValid('token_id', $submittedToken)) {
	// ... do something, like deleting an object
}
*/
// isCsrfTokenValid() is equivalent to:
// $this->get('security.csrf.token_manager')->isTokenValid(
//     new \Symfony\Component\Security\Csrf\CsrfToken\CsrfToken('token_id', $token)
// );
