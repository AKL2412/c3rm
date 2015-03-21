<?php

namespace Crm\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email',"email")
            ->add('ddn',"date",array("years"=>range(1950,2020)))
            ->add('presentation',"textarea",array("required"=>false))
            ->add('adresse',"textarea",array("required"=>false))
            ->add('image',"file",array("required"=>false))
            ->add('tel')
            ->add('cin')
            ->add('motpasse')
            //->add('dateajout')
           // ->add('compte')
            ->add('profil','entity', array(
                  'class'    => 'CrmAdminBundle:Profil',
                  'property' => 'nom',
                  'multiple' => false,
                  'required'    => true,
                'empty_value' => 'Choisissez le profil',
                'empty_data'  => null
                ))
            ->add('genre','entity', array(
                  'class'    => 'CrmAdminBundle:Genre',
                  'property' => 'nom',
                  'multiple' => false,
                  'required'    => true,
                'empty_value' => 'Choisissez le genre',
                'empty_data'  => null
                ))
            ->add('save', 'submit', array(
                'attr' => array('class' => 'btn btn-success'),
                    ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AdminBundle\Entity\Utilisateur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_adminbundle_utilisateur';
    }
}
