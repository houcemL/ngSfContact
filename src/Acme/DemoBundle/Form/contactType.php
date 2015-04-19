<?php

namespace Acme\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class contactType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text', array(
                'attr' => array('ng-model' => 'name')
            ))
            ->add('mail', 'email', array(
                'attr' => array('ng-model' => 'mail')
            ))
            ->add('message', 'textarea', array(
                'attr' => array('ng-model' => 'message')
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\DemoBundle\Entity\contact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_demobundle_contact';
    }
}
