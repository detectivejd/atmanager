<?php
namespace ATManager\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PatrimonioClasifType extends AbstractType {

public function buildForm(FormBuilderInterface $builder, array $options)
{
  $builder
	  ->add('nombre')
	  ->add('Submit','submit',array('label'=>'Guardar'));

}

public function setDefaultsOptions(OptionsResolverInterface $resolver)
{
	$resolver->setDefaults(array(
		'data_class' => 'ATManager\BackendBundle\Entity\PatrimonioClasif'
		));

}

public function getName()
{
	return 'Form_PatrimonioClasif';
}

}
