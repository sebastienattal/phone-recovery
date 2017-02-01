<?php

namespace ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * List all brands
     *
     * @ApiDoc(
     *     section="Phone recovery",
     *     description="List all brands",
     *     statusCodes={
     *         Response::HTTP_OK="Returned when brands exists",
     *         Response::HTTP_BAD_REQUEST="Returned when an error occurred"
     *     }
     * )
     * @Route("/services/brands", name="api_services_list_brands")
     * @Method("GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listBrandsAction(Request $request)
    {
        $brands = $this->get('json_parser')->decode($this->getParameter('brandfilepath'));

        if ($brands instanceof JsonResponse) {
            return $brands;
        }
        return new JsonResponse($brands);
    }

    /**
     * List all orders
     *
     * @ApiDoc(
     *     section="Phone recovery",
     *     description="List all orders",
     *     statusCodes={
     *         Response::HTTP_OK="Returned when orders exists",
     *         Response::HTTP_BAD_REQUEST="Returned when an error occurred"
     *     }
     * )
     * @Route("/services/orders", name="api_services_list_orders")
     * @Method("GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listOrdersAction(Request $request)
    {
        $orders = $this->get('json_parser')->decode($this->getParameter('orderfilepath'));
        if ($orders instanceof JsonResponse) {
            return $orders;
        }

        foreach ($orders as $order) {
            $modelJson = $this->forward('ApiBundle:Default:getModelById', ['modelId' => $order->model]);

            if (Response::HTTP_BAD_REQUEST == $modelJson->getStatusCode()) {
                $response = ['status' => 'KO', 'message' => 'Error when retrieving orders'];
                return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
            }

            $modelContent = $modelJson->getContent();
            $order->model = json_decode($modelContent);
        }

        return new JsonResponse($orders);
    }

    /**
     * Retrieve a model from its id
     *
     * @ApiDoc(
     *     section="Phone recovery",
     *     description="Retrieve a model from its id",
     *     statusCodes={
     *         Response::HTTP_OK="Returned when the model exists",
     *         Response::HTTP_BAD_REQUEST="Returned when an error occurred"
     *     }
     * )
     * @Route("/services/models/{modelId}", name="api_services_get_model", requirements={"modelId": "\d+"})
     * @Method("GET")
     *
     * @param Request $request
     * @param integer $modelId
     * @return JsonResponse
     */
    public function getModelByIdAction(Request $request, $modelId)
    {
        $models = $this->get('json_parser')->decode($this->getParameter('modelfilepath'));
        if ($models instanceof JsonResponse) {
            return $models;
        }

        foreach ($models as $model) {
            if ($modelId == $model->id) {
                $brandJson = $this->forward('ApiBundle:Default:getBrandById', ['brandId' => $model->brand]);

                if (Response::HTTP_BAD_REQUEST == $brandJson->getStatusCode()) {
                    $response = ['status' => 'KO', 'message' => 'Error when retrieving the model'];
                    return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
                }

                $brandContent = $brandJson->getContent();
                $model->brand = json_decode($brandContent);

                return new JsonResponse($model);
            }
        }

        $response = ['status' => 'KO', 'message' => 'The model does not exist'];
        return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Retrieve a brand from its id
     *
     * @ApiDoc(
     *     section="Phone recovery",
     *     description="Retrieve a brand from its id",
     *     statusCodes={
     *         Response::HTTP_OK="Returned when the brand exists",
     *         Response::HTTP_BAD_REQUEST="Returned when an error occurred"
     *     }
     * )
     * @Route("/services/brands/{brandId}", name="api_services_get_brand", requirements={"brandId": "\d+"})
     * @Method("GET")
     *
     * @param Request $request
     * @param integer $brandId
     * @return JsonResponse
     */
    public function getBrandByIdAction(Request $request, $brandId)
    {
        $brands = $this->get('json_parser')->decode($this->getParameter('brandfilepath'));
        if ($brands instanceof JsonResponse) {
            return $brands;
        }

        foreach ($brands as $brand) {
            if ($brandId == $brand->id) {
                return new JsonResponse($brand);
            }
        }

        $response = ['status' => 'KO', 'message' => 'The brand does not exist'];
        return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
    }
}
