<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RouteController extends Controller
{
	
	/* 
	 * **************		Expressions régulières		****************
	 * 
	 * \d+	: must be a digit 
	 */
	
	/**	 
	 * @Route("/blog/{page}"
	 * , defaults={"page"=1}
	 * , requirements={"page":"\d+"}
	 * , name="blog_show"
	 * )
	 */
	public function indexAction($page) {
		
		return new Response('Affichage du blog n°' . $page);
	}
	
	/**
	 * @Route("/blog/{slug}")
	 */
	public function showAction($slug) {
		return new Response('showAction: ' . $slug);
	}
	
	/**
	 * @Route("/{_locale}"
	 * , defaults={"_locale"= "en"}
	 * , requirements={"_locale": "en|fr"}
	 * )
	 */
	public function homepageAction($_locale) {
		return new Response('Language: ' . $_locale);
	}
	
	////////		HTTP Method Requirements		/////////
	/**
	 * @Route("/api/posts/{id}")
	 * @Method({"GET", "HEAD"})
	 */
	public function show2Action($id) {
		return new Response('// ... return a JSON response with the post. id: ' . $id);
	}
	/**
	 * @Route("/api/posts/{id}")
	 * @Method("PUT")
	 */
	public function editAction($id) {
		return new Response('// ... edit a post. id: ' . $id);
	}
	
	////////		Generating URLs		////////
	/**
	 * @Route("/generateURL")
	 */
	public function generateAction() {
		$url = $this->generateUrl(
			'lucky',
			array('param' => 5)
		);
		
		$absoluteUrl = $this->generateUrl(
			'lucky', 
			array('param' => 5), 
			UrlGeneratorInterface::ABSOLUTE_URL
		);
		// Méthode match

		$params = $this->get('router')->match('/lucky/5');
		// array(
		//     	'_controller' => 'AppBundle\Controller\LuckyController::numberAction',
		// 		'param' => 5,
		//		'_route' => 'lucky'
		// )		
		$textParams = '';
		foreach ($params as $key=>$param) {
			$textParams = $textParams . $key . ' : ' . $param . '<br />';
		}
		return new Response('<p>url généré par défaut: </p><a href="' . $url . '">' . $url . '</a><hr>
				<p>Url absolu: </p><a href="' . $absoluteUrl . '">' . $absoluteUrl . '</a><hr>
				<p>Méthode match: </p>' . $textParams);
		

		
		// Generating URLs with Query Strings
	/*	$this->get('router')->generate('blog', array(
				'page' => 2,
				'category' => 'Symfony'
		));	*/
		// /blog/2?category=Symfony		
	}
	/**
	 * @Route("/twigUrl")
	 */
	public function twig_urlAction () {
		return $this->render(
			'route/route.html.twig'
		);
	}
	
	
	
	
}