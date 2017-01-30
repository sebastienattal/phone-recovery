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
        $brandFilePath = $this->getParameter('brandfilepath');

        if (!file_exists($brandFilePath)) {
            $response = ['status' => 'KO', 'message' => 'The brand file does not exist'];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $jsonBrands = file_get_contents($brandFilePath);

        $brands = json_decode($jsonBrands);
        if (null === $brands) {
            $response = ['status' => 'KO', 'message' => json_last_error_msg()];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
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
        $orderFilePath = $this->getParameter('orderfilepath');

        if (!file_exists($orderFilePath)) {
            $response = ['status' => 'KO', 'message' => 'The order file does not exist'];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $jsonOrders = file_get_contents($orderFilePath);

        $orders = json_decode($jsonOrders);
        if (null === $orders) {
            $response = ['status' => 'KO', 'message' => json_last_error_msg()];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
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
        $modelFilePath = $this->getParameter('modelfilepath');

        if (!file_exists($modelFilePath)) {
            $response = ['status' => 'KO', 'message' => 'The model file does not exist'];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $jsonModels = file_get_contents($modelFilePath);

        $models = json_decode($jsonModels);
        if (null === $models) {
            $response = ['status' => 'KO', 'message' => json_last_error_msg()];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        foreach ($models as $model) {
            if ($modelId == $model->id) {
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
        $brandFilePath = $this->getParameter('brandfilepath');

        if (!file_exists($brandFilePath)) {
            $response = ['status' => 'KO', 'message' => 'The brand file does not exist'];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $jsonBrands = file_get_contents($brandFilePath);

        $brands = json_decode($jsonBrands);
        if (null === $brands) {
            $response = ['status' => 'KO', 'message' => json_last_error_msg()];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
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
