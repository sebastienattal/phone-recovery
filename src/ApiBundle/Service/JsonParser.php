<?php

namespace ApiBundle\Service;

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
            $response = ['status' => 'KO', 'message' => sprintf('The file path "%s" does not exist', $filePath)];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $contentFile = file_get_contents($filePath);
        $jsonData = json_decode($contentFile);

        if (null === $jsonData) {
            $response = ['status' => 'KO', 'message' => json_last_error_msg()];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        return $jsonData;
    }
}
