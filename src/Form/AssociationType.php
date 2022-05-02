<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('nomDetaille')
            ->add('description')
            ->add('info')
            ->add('email')
            ->add('telephone')
            ->add('siteWeb')
            ->add('lienFacebook')
            ->add('lienTwitter')
            ->add('lienInstagram')
            ->add('nomPresident')
            ->add('prenomPresident')
            ->add('emailPresident')
            ->add('telephonePresident')
            ->add('nomSecretaire')
            ->add('prenomSecretaire')
            ->add('emailSecretaire')
            ->add('telephoneSecretaire')
            ->add('nomTresorier')
            ->add('prenomTresorier')
            ->add('emailTresorier')
            ->add('telephoneTresorier')
            ->add('categorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
        ]);
    }
}
