<?php
/**
 * Created by PhpStorm.
 * User: celin
 * Date: 22/03/2017
 * Time: 13:46
 */

namespace DL\FamilytreeBundle\Form\Type;

use DL\FamilytreeBundle\Entity\Relation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use DL\FamilytreeBundle\Repository\RelationRepository;

class RelationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('people_a', EntityType::class,[
                'class' => "DLFamilytreeBundle:People",
                'choice_label' => 'label',
                'choices' => $options["data"]->getTree()->getPeoples()
            ])
            ->add('relationship', EntityType::class,[
                'class' => 'DLFamilytreeBundle:Relationship',
                'choice_label' => 'name'
            ])
            ->add('people_b', EntityType::class,[
                'class' => 'DLFamilytreeBundle:People',
                'choice_label' => 'label',
                'choices' => $options["data"]->getTree()->getPeoples()
            ])
            ->add('save', SubmitType::class, ['label' => 'Envoyer']);
    }


}
