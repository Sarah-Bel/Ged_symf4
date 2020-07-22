<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\TypeDocument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypedocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, array('label' => 'Description'),)
            //->add('service',EntityType::class)
            ->add('service',EntityType::class, array(
                'label' => 'Département',
                'class' => Departement::class,
                'choice_label' => 'description'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeDocument::class,
        ]);
    }
}
