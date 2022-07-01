<?php

namespace App\Form;

use App\Entity\Produits;
use App\Entity\Categories;
use App\Entity\TypeFile;
use App\Entity\AddFiles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom"
            ])
            ->add('achat_at', DateType::class, [
                'label' => "Achat"
            ])
            ->add('guarantee_at', DateType::class, [
                'label' => "Garantie"
            ])
            ->add('price', NumberType::class, [
                'label' => "Prix"
            ])
            ->add('content', CKEditorType::class, [
                'label' => "Contenu"
            ])
            ->add('categories', EntityType::class, [
                'label' => "Catégorie",
                'class' => Categories::class,
                'choice_label' => 'name'
            ])
            ->add('manuel_src', FileType::class, [
                'label' => "Manuel",
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('ticket_src', FileType::class, [
                'label' => "Ticket",
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
