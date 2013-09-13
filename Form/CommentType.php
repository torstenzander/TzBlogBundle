<?php

namespace Tz\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tz\BlogBundle\Form\DataTransformer\PostToIdTransformer;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('email', 'email')
            ->add(
                'website',
                'text',
                array(
                    'label' => 'Webseite'
                )
            )
            ->add('text', 'textarea', array('label' => 'Nachricht'))
            ->add('post', 'entity_hidden', array('class' => 'TzBlogBundle:Post'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Tz\BlogBundle\Entity\Comment'
            )
        );
    }

    public function getName()
    {
        return 'tz_blogbundle_commenttype';
    }



}
