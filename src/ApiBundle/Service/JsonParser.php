<?php

namespace ApiBundle\Service;

use ApiBundle\Entity\Order;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Service to parse and decode a JSON file
 */
class JsonParser
{
    /**
     * Decode a JSON file
     *
     * @param string $filePath
     * @return array|JsonResponse
     */
    public function decode($filePath)
    {
        if (!file_exists($filePath)) {
            $response = ['message' => sprintf('The file path "%s" does not exist', $filePath)];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $contentFile = file_get_contents($filePath);
        $jsonData = json_decode($contentFile);

        if (null === $jsonData) {
            return new JsonResponse(['message' => json_last_error_msg()], Response::HTTP_BAD_REQUEST);
        }

        return $jsonData;
    }

    /**
     * @param Order $order
     * @param string $filePath
     * @return JsonResponse
     * @throws \InvalidArgumentException
     */
    public function saveOrder(Order $order, $filePath)
    {
        $jsonData = $this->decode($filePath);
        if ($jsonData instanceof JsonResponse) {
            return $jsonData;
        }
        if (!is_array($jsonData)) {
            throw new \InvalidArgumentException('An error occurred when saving the order');
        }

        $jsonOrder = new \stdClass();
        $jsonOrder->id = count($jsonData) + 1;
        $jsonOrder->model = $order->getModel()->getId();
        $jsonOrder->amount = $order->getAmount();
        $jsonOrder->created = $order->getCreated()->format(Order::DATETIME_FORMAT);

        $jsonData[] = $jsonOrder;

        if (false === file_put_contents($filePath, json_encode($jsonData))) {
            throw new \InvalidArgumentException('An error occurred when writing the order JSON file.');
        }

        return new JsonResponse(['message' => 'The order has been successfully created!'], Response::HTTP_CREATED);
    }
}
