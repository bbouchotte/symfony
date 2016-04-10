<?php 

namespace ValidationBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Author
{
	/**
	 * @Assert\NotBlank()
	 */
	public $name;
	
}