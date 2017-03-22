<?php
/**
 * Created by PhpStorm.
 * User: celin
 * Date: 22/03/2017
 * Time: 13:46
 */

namespace DL\FamilytreeBundle\Form\Type;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RelationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('relationship', EntityType::class,[
                'class' => 'FamilytreeBundle:Relationship',
                'choice_label' => 'name'
            ])
            ->add('save', SubmitType::class, ['label' => 'Envoyer']);
    }


}