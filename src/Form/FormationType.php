<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

/**
 * 
 */
class FormationType extends AbstractType
{
    /**
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',
            )
            ->add('videoId', TextType::class, [
                'label' => 'ID de la vidéo',
                'required' => true,  
            ])   
            ->add('publishedAt', null, [
                'widget' => 'single_text',
                'label' => 'date ',
                'required' => true,
                'constraints' => [
        new LessThanOrEqual([
            'value' => 'today',
            'message' => 'La date ne peut pas être postérieure à aujourd’hui.',
        ]),
    ],
               
            ])
            
            ->add('description')
            
            ->add('playlist', EntityType::class, [
                'class' => Playlist::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
           ])
            
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])    
        ;
    }

    /**
     * 
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
