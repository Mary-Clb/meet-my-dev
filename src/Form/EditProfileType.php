<?php
namespace App\Form;

use App\Entity\Speciality;
use App\Entity\Activity;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use \Symfony\Bundle\SecurityBundle\Security;
use App\Repository\SpecialityRepository;
use App\Repository\ActivityRepository;

class EditProfileType extends AbstractType
{
    private $security;

    private $user;

    private $specialityRepository;
    private $activityRepository;

    public function __construct(Security $security, SpecialityRepository $specialityRepository, ActivityRepository $activityRepository)
    {
        $this->security = $security;
        $this->user = $this->security->getUser();
        $this->specialityRepository = $specialityRepository;
        $this->activityRepository = $activityRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username',
            ])
            ->add('presentation', TextareaType::class, [
                'label' => 'Presentation',
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Telephone',
                'required' => false,
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Email',
            ]);

        if ($options['dev']) {
            $builder
                ->add('name', TextType::class, [
                    'label' => 'Name',
                ])
                ->add('firstname', TextType::class, [
                    'label' => 'First Name',
                ])
                ->add('experience', IntegerType::class, [
                    'label' => 'Experience',
                ])
                ->add('specialities', ChoiceType::class, [
                    'label' => 'Specialities',
                    'multiple' => true,
                    'required' => false,
                    'placeholder' => 'Choose an language',
                    'choices' => array_merge([0 => (new Speciality())], $this->specialityRepository->findAll()),
                    'choice_label' => 'label',
                ]);
        }

        if ($options['company']) {
            $builder
                ->add('name', TextType::class, [
                    'label' => 'Name',
                ])
                ->add('siret', TextType::class, [
                    'label' => 'First Name',
                ])
                ->add('location', TextType::class, [
                    'label' => 'Experience',
                ])
                ->add('publique', CheckboxType::class, [
                    'label' => 'Publique',
                   'required' => false,
                ])
                ->add('activities', ChoiceType::class, [
                    'label' => 'Activities',
                    'multiple' => true,
                    'required' => false,
                    'placeholder' => 'Choose an language',
                    'choices' => array_merge([0 => (new Activity())], $this->activityRepository->findAll()),
                    'choice_label' => 'label',
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'dev' => in_array('ROLE_DEV', $this->user->getRoles()),
            'company' => in_array('ROLE_COMPANY', $this->user->getRoles()),
        ]);
    }
}