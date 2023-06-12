<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Listing;

use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class ListingType extends AbstractType
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categories = $this->categoryRepository->getAllCategories();

        $builder
            ->add('title')
            ->add('images')
            ->add('description')
            ->add('price')
            ->add('features')
            ->add('address')
            ->add('city')
            ->add('pincode')
            ->add('created_at')
            ->add('updated_at')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choices' => $categories,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('email', EmailType::class, [
                'mapped' => false
            ])
            ->add('phone', TextType::class, [
                'mapped' => false
            ])
            ->add('facebook_url', TextType::class, [
                'mapped' => false
            ])
            ->add('twitter_url', TextType::class, [
                'mapped' => false
            ])
            ->add('google_url', TextType::class, [
                'mapped' => false
            ])
            ->add('instagram_url', TextType::class, [
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
