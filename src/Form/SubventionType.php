<?php

namespace App\Form;

use App\Entity\Subvention;
use App\Entity\TypeSubvention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('typeSubvention', null, [
//                'attr'=> ['onchange'=> 'displayCheck()']
//                ]
//            )
            ->add('dateDemande', DateTimeType::class, [
                'data' => new \DateTime('now'),
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
            ])
            ->add('montantOuQteDemande')
            ->add('commentaireDemandeur')
            ->add('association')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subvention::class,
        ]);
    }
}
