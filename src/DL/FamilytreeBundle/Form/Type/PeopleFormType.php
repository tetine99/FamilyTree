<?php

namespace DL\FamilytreeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PeopleFormType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('create', SubmitType::class);
    }
}

?>