<?php

namespace App\Form;

use App\Entity\Produits;
use App\Entity\Categories;
use App\Entity\AddFiles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('achat_at')
            ->add('guarantee_at')
            ->add('price')
            ->add('content', CKEditorType::class)
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name'
            ])
            ->add('addFiles', EntityType::class, [
                'class' => AddFiles::class,
                'choice_label' => 'name',
                'mapped' => false
            ])
            ->add('images')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
