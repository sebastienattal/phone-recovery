<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * Main controller to list and create phone recovery
 */
class DefaultController extends Controller
{
    /**
     * Homepage
     *
     * @Route("/", name="homepage")
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * List all phone recovery
     *
     * @Route("/list", name="list_phone_recovery")
     *
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        /** @var JsonResponse $ordersJson */
        $ordersJson = $this->forward('ApiBundle:Default:listOrders');
        $ordersContent = json_decode($ordersJson->getContent());

        if (Response::HTTP_BAD_REQUEST == $ordersJson->getStatusCode()) {
            throw new \RuntimeException($ordersContent->message);
        }

        $serializer = new Serializer(
            [new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );

        $orders = $serializer->deserialize($ordersJson->getContent(), 'ApiBundle\Entity\Order[]', 'json');

        return $this->render('default/list.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * Add a phone recovery
     *
     * @Route("/add", name="add_phone_recovery")
     *
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        return $this->render('default/add.html.twig', [
        ]);
    }
}
