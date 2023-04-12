<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Activity;
use App\Entity\Developer;
use App\Entity\Speciality;
use App\Repository\ActivityRepository;
use App\Repository\SpecialityRepository;
use Symfony\Bundle\MakerBundle\Tests\tmp\current_project_xml\src\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class CompanyType extends AbstractType
{
    private $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [])
            ->add('name', TextType::class, [])
            ->add('siret', TextType::class, [])
            ->add('location', TextType::class, [])
            ->add('mail', EmailType::class, [])
            ->add('employees', IntegerType::class, ['attr' => ['min' => 0]])
            ->add('publique', CheckboxType::class, ['required' => false])
            ->add('activities', ChoiceType::class, [
                    'label' => 'Activities',
                    'multiple' => true,
                    'required' => false,
                    'placeholder' => 'Choose an activity',
                    'choices' => array_merge([0 => (new Activity())], $this->activityRepository->findAll()),
                    'choice_label' => 'label',
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-lg btn-light mt-3'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}

class DevType extends AbstractType
{
    private $specialityRepository;

    public function __construct(SpecialityRepository $specialityRepository)
    {
        $this->specialityRepository = $specialityRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [])
            ->add('name', TextType::class, [])
            ->add('firstname', TextType::class, [])
            ->add('mail', EmailType::class, [])
            ->add('experience', IntegerType::class, ['attr' => ['min' => 0]])
            ->add('specialities', ChoiceType::class, [
                    'label' => 'Specialities',
                    'multiple' => true,
                    'required' => false,
                    'placeholder' => 'Choose an language',
                    'choices' => array_merge([0 => (new Speciality())], $this->specialityRepository->findAll()),
                    'choice_label' => 'label',
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-lg btn-light mt-3'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Developer::class,
        ]);
    }
}