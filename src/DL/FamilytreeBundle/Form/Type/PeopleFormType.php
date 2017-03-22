<?php

namespace DL\FamilytreeBundle\Form\Type;

use DL\FamilytreeBundle\Entity\People;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PeopleFormType extends AbstractType {

    public function buildform(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('firstname', TextType::class, ['label' => 'Nom : '])
                ->add('lastname', TextType::class, ['label' => 'Prenom : '])
                ->add('image', FileType::class, [
                    'label' => 'Image(jpeg) : ',
                    'required' => (false),
                    'data_class' => 'Symfony\Component\HttpFoundation\File\File',
                    'property_path' => 'image'
                ])
                ->add('create', SubmitType::class, ['label' => 'enregistrer ']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => People::class,
        ));
    }

}
