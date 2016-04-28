<?php

namespace FormsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Utility\MyService;

use FormsBundle\Form\ClanType;

class PersonageType extends AbstractType
{
	/*private $myService;
	
	public function __construct(MyService $myService)
	{
		$this->myService = $myService;
	}*/
	
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('clan', ClanType::class)
            ->add('name')
            ->add('save', SubmitType::class, array('label' => 'Create personage'))
            ->add('saveAndAdd', SubmitType::class, array('label' => 'Save and Add'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FormsBundle\Entity\Personage'
        ));
    }
}
