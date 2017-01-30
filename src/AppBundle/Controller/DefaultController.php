<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Main controller to list and create phone recovery
 */
class DefaultController extends Controller
{
    /**
     * Homepage
     *
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * List all phone recovery
     *
     * @Route("/list", name="list_phone_recovery")
     */
    public function listAction(Request $request)
    {
        /** @var JsonResponse $ordersJson */
        $ordersJson = $this->forward('ApiBundle:Default:listOrders');
        $ordersContent = $ordersJson->getContent();
        $orders = json_decode($ordersContent);

        if (!is_array($orders) && property_exists($orders, 'status') && 'KO' == $orders->status) {
            throw new \RuntimeException('Orders data file is bad or corrupted.');
        }

        foreach ($orders as &$order) {
            /** @var JsonResponse $modelJson */
            $modelJson = $this->forward('ApiBundle:Default:getModelById', ['modelId' => $order->id]);
            $modelContent = $modelJson->getContent();
            $model = json_decode($modelContent);
            $order->model = $model->name;
        }

        return $this->render('default/list.html.twig', [
            'orders' => $orders
        ]);
    }
}
