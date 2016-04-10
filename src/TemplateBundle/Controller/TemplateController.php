<?php

namespace TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class TemplateController extends Controller
{
	protected  $articles = array(
			array(
					'designation' => 'pneu',
					'prix' => '32€'
			),
			array(
					'designation' => 'moumoute pour volant',
					'prix' => '2€'
			),
			array(
					'designation' => 'Pompe à vélo',
					'prix' => '5€'
			),
			array(
					'designation' => 'Cure dents',
					'prix' => '1€'
			)
	);

	/**
	 * @Route("/homeArticle", name="homeArticle")
	 */
	public function homeArticleAction() {
		return $this->render('article/home.html.twig');
	}
	
    /**
     * @Route("/template", name="template")
     */
    public function templateAction()
    {
    $numbers = array();
    for($i=0; $i<15; $i++) {
    	$numbers[] = rand(0, 100);
    }
        return $this->render(
        	'TemplateBundle:Template:template.html.twig',	// Bundle:directory:filename
        	array('numbers' => $numbers)
        );
    }
    
    /**
     * @Route("/memoTwig", name="memoTwig")
     */
    public function memoTwigAction() {
    	return $this->render('TemplateBundle:Template:memoTwig.html.twig', array(
        	'text' => 'TEXTE EN MAJUSCULE'
        ));
    }
    
    ////		Including templates	in twig file	////
    /**
     * @Route("/includedTemplate")
     */
    public function includedtemplateAction() {
    	return $this->render(
    		'article/list.html.twig',
    			array('articles' => $this->articles)
    	);
    }
    
    ////		Embedding (intégration) Controllers		////
    /**
     * @Route("/recentArticles/{max}"
     * , defaults={"max"=3}
     * , requirements={"max":"\d+"}
     * , name="recentArticles"
     * )
     */
    public function recentArticlesAction($max) {
    	$recentArticles = array();
    	if ($max > count($this->articles)){
    		$max = count($this->articles);
    	}
    	for($i=0; $i<$max; $i++){
    		$recentArticles[$i] = $this->articles[$i];
    	}
//     	dump($this->$articles[1]);	// The output of the dump() function is then rendered in the web developer toolbar.
    	return $this->render(
   			'article/article_details.html.twig',
    		array('articles' => $recentArticles)
    	);
    }


	/**
	 * @Route("/debugging", name="debugging")
	 */
    public function debuggingAction(Request $request) {
    	return $this->render('TemplateBundle:Template:debugging.html.twig',
    		array('articles' => $this->articles)
    	);
    }

}



