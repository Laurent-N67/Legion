<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Manga;
use App\Entity\Auteur;
use Doctrine\ORM\EntityRepository;
use App\Repository\AuteurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class MangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre', TextType::class)
            ->add('Description', TextType::class)
            ->add('dateCreation', DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('garde', TextType::class)
            ->add('tag', CollectionType::class,[
                'entry_type'=>EntityType::class,
                'entry_options'=>[
                    'label'=>"choisir tag",
                    'class'=>Tag::class,
                ],  
                'allow_add'=>true,
                'allow_delete'=>true,
                'by_reference'=>false,
                'label'=>false,
                
            ])
            ->add('auteur', EntityType::class,
            [
                'class' => Auteur::class,
                'query_builder' => function(AuteurRepository $er){
                    return $er -> createQueryBuilder('a')
                        ->orderBy('a.NomAuteur','ASC');
                },
                'choice_label' => 'NomAuteur',
            ])
            ->add('valider',SubmitType::class)
            ->add('statut', ChoiceType::class,[
                'choices' =>[
                    'En cours'=> true,/*(1)*/
                    'Terminer'=>false,/*(0)*/
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manga::class,
        ]);
    }
}
