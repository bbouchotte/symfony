<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="DbBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
	
	/**
	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
	 */
	private $category;
	
	
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var datetime
     * 
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function findAllOrderedByName()     {
    	return $this->getEntityManager()
    	->createQuery(
    			'SELECT p FROM DbBundle:Product p ORDER BY p.name ASC'
    			)
    			->getResult();
    }
    
    /**
     * Set category
     *
     * @param \DbBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\DbBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \DbBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function findOneByIdJoinedToCategory($productId)
    {
    	$query = $this->getEntityManager()
    	->createQuery(
    			'SELECT p, c FROM DbBundle:Product p
            JOIN p.category c
            WHERE p.id = :id'
    		)->setParameter('id', $productId);
    
    	try {
    		return $query->getSingleResult();
    	} catch (\Doctrine\ORM\NoResultException $e) {
    		return null;
    	}
    }
    
    
	//////////////////		life cycle		/////////////////
	
	/**
	 * @ORM\PrePersist
	 */
	public function setCreatedAtValue()
	{
	    $this->createdAt = new \DateTime();
	}
    
}
