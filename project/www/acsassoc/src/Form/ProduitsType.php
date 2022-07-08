<?php

namespace App\Form;

use App\Entity\Produits;
use App\Entity\Categories;
use App\Entity\TypeFile;
use App\Entity\AddFiles;
use Symfony\Component\Validator\Constraints\File;
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
                'label' => false,
                'attr' => [
                    'class' => 'form-control-plaintext'
    
                ]
            ])
            ->add('achat_at', DateType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control-plaintext'
                ],
                'widget' => 'single_text'

            ])
            ->add('guarantee_at', DateType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control-plaintext'
                ],
                'widget' => 'single_text'
            ])
            ->add('price', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control-plaintext'
                ]
            ])
            ->add('lieu_achat', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control-plaintext'
                ]
            ])
            ->add('content', CKEditorType::class, [
                'label' => "Contenu"
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'class' => Categories::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select'
                ]
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
                'required' => false,
                'attr' => [
                    'accept' => 'image/gif, image/png, image/jpeg, image/bmp, image/webp',
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/gif', 
                            'image/png', 
                            'image/jpeg', 
                            'image/bmp', 
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Merci de télécharger une image valide.',
                    ])
                ],
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
