<?php

namespace DL\FamilytreeBundle\Form\Type;

use DL\FamilytreeBundle\Entity\People;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PeopleFormType extends AbstractType
{
  public function buildform(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('firstname', TextType::class, ['label' => 'Nom : '])
    ->add('lastname', TextType::class, ['label' => 'Prenom : '])
    ->add('imageFile', VichImageType::class, [
      'label' => 'image :',
      'required' => false,
      'allow_delete' => true,
       'download_link' => true,
       'data_class' => null,
    ])
    ->add('create', SubmitType::class, ['label'=> 'enregistrer '])
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => People::class,
        ));
    }



}
