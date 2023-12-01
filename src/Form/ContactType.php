<?php

namespace App\Form;

use App\Entity\Area;
use App\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',TextType::class, [
                'label' => 'Nombre'
            ])
            ->add('lastName',TextType::class,[
                'label' => 'Apellidos'
            ])
            ->add('email',EmailType::class,[
                'label' => 'Correo Electrónico'
            ])
            ->add('phone', TelType::class, [
                'label' => 'Teléfono'
            ])
            ->add('area', EntityType::class, [
                'class' => Area::class,
                'choice_label' => 'name',
                'label' => 'Área'
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Mensaje'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
