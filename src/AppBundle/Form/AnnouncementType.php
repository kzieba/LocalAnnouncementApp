<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnnouncementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('expirationTime')
    //        ->add('photo')
            ->add('categories')
            ->add('uploaded_file', 'file' , ['mapped'=>false] )
            ->add('alt_text','text', ['mapped'=>false])
    //        ->add('user')

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Announcement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_announcement';
    }
}
