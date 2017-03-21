<?php

namespace DL\FamilytreeBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RelationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('titre', TextType::class)
            ->add('isbn', TextType::class)
            ->add('synopsis', TextType::class)
            ->add('datePublication', DateType::class)
            ->add('edition', EntityType::class, array(
                'class' => 'BibliBundle:Edition',
                'label' => 'Nom Edition'))
            ->add('create', SubmitType::class);
    }
}

?>