<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idClicko')
            ->add('idGST')
            ->add('date', DateTimeType::class, [
                'data' => new \DateTime('now'),
                'widget' => 'single_text',
            ])
            ->add('titre')
            ->add('batiment')
            ->add('demandeur')
            ->add('statut')
            ->add('idTypeTicket')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
