<?php

namespace FormsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Personage
 *
 * @ORM\Table(name="personage")
 * @ORM\Entity(repositoryClass="FormsBundle\Repository\PersonageRepository")
 */
class Personage
{
	
	const DAMAGE_INIT = 0;
	const GRADE_INIT = 0;
	const POWER_INIT = 5;
	
	public function __construct() {
		$this->damage = self::DAMAGE_INIT;
		$this->grade = self::GRADE_INIT;
		$this->power = self::POWER_INIT;
	}
	
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="damage", type="integer")
     */
    private $damage;

    /**
     * @var int
     *
     * @ORM\Column(name="grade", type="integer")
     */
    private $grade;

    /**
     * @var int
     *
     * @ORM\Column(name="power", type="integer")
     */
    private $power;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;


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
     * Set damage
     *
     * @param integer $damage
     *
     * @return Personage
     */
    public function setDamage($damage)
    {
        $this->damage = $damage;

        return $this;
    }

    /**
     * Get damage
     *
     * @return int
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * Set grade
     *
     * @param integer $grade
     *
     * @return Personage
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return int
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set power
     *
     * @param integer $power
     *
     * @return Personage
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     *
     * @return int
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Personage
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
     * @Assert\Type(type="FormsBundle\Entity\Clan")
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Clan", inversedBy="personages", cascade={"persist"})
     * @ORM\JoinColumn(name="clan_id", referencedColumnName="id")
     */
    protected $clan;
        
    public function getClan() { return $this->clan; }
    
    public function setClan(Clan $clan = null) { $this->clan = $clan; }
    
}

