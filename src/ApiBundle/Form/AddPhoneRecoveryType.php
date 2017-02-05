<?php

namespace ApiBundle\Form;

use ApiBundle\Entity\Model;
use ApiBundle\Entity\Order;
use Lsw\ApiCallerBundle\Call\HttpGetJson;
use Lsw\ApiCallerBundle\Caller\ApiCallerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Router;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Form type to add a phone recovery
 */
class AddPhoneRecoveryType extends AbstractType
{
    /**
     * @param ApiCallerInterface $apiCaller
     * @param Router $router
     */
    public function __construct(ApiCallerInterface $apiCaller, Router $router)
    {
        $this->apiCaller = $apiCaller;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Call the API to retrieve all models
        $modelsContent = $this->apiCaller->call(new HttpGetJson(
            $this->router->generate('api_services_list_models', [], UrlGenerator::ABSOLUTE_URL),
            []
        ));
        $serializer = new Serializer(
            [new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );

        $modelsJson = new JsonResponse($modelsContent);

        $models = $serializer->deserialize($modelsJson->getContent(), 'ApiBundle\Entity\Model[]', 'json');

        $builder
            ->add('model', ChoiceType::class, [
                'placeholder' => 'Choose a model',
                'choices' => $models,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'constraints' => [new NotBlank()],
                'choice_attr' => function(Model $model, $key, $index) {
                    return ['data-model-estimation' => $model->getPrice()];
                },
            ])
            ->add('amount', NumberType::class, [
                'attr' => ['placeholder' => 'Choose an amount'],
                'constraints' => [new NotBlank(), new GreaterThan(['value' => 0])]
            ]);

        /**
         * The method Order::setModel accepts only an array, so we transform here received model
         */
        $builder->get('model')->addModelTransformer(new CallbackTransformer(
            function ($model) {
                return $model;
            },
            function (Model $model = null) {
                if (null === $model) {
                    return null;
                }

                $brand = [
                    'id' => $model->getBrand()->getId(),
                    'name' => $model->getBrand()->getName()
                ];

                return [
                    'id' => $model->getId(),
                    'name' => $model->getName(),
                    'brand' => $brand,
                    'price' => $model->getPrice()
                ];
            }
        ));

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($options) {
            if (!$event->getForm()->isValid()) {
                return;
            }

            /** @var Order $order */
            $order = $options['data'];
            if ($order->getAmount() > $order->getModel()->getPrice()) {
                $error = new FormError('The amount must be lower than the price of the model');
                $event->getForm()->get('amount')->addError($error);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => Order::class,
            'allow_extra_fields' => true
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'add_phone_recovery';
    }
}
