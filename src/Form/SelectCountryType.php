<?php

namespace App\Form;

use App\Entity\City;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SelectCountryType extends AbstractType
{
    private $entityManager;
    private $cityRepository;

    public function __construct(EntityManagerInterface $entityManager, CityRepository $cityRepository)
    {
        $this->entityManager = $entityManager;
        $this->cityRepository = $cityRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a country',
                'mapped' => false,
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['country'])) {
                    $countryId = $data['country'];

                    $cities = $this->entityManager
                        ->getRepository(City::class)
                        ->createQueryBuilder('c')
                        ->innerJoin('c.country', 'co')
                        ->where('co.id = :countryId')
                        ->setParameter('countryId', $countryId)
                        ->getQuery()
                        ->getResult();


                    $form->add('city', EntityType::class, [
                        'class' => City::class,
                        'choices' => $cities,
                        'choice_label' => 'name',
                        'placeholder' => 'Select a city',
                    ]);
                }
            });
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
