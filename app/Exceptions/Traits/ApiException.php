<?php

namespace App\Exceptions\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;

trait ApiException {

  protected function getJsonException($request, $e)
  {
    if ($e instanceof ModelNotFoundException) {
      return $this->notFoundException();
    }

    if ($e instanceof HttpException) {
      return $this->httpException($e);
    }

    if ($e instanceof ValidationException) {
      return $this->validationException($e);
    }

    return $this->genericException();
  }

  protected function notFoundException()
  {
    return $this->getResponse(
      "RESOURCE NOT FOUND",
      "01",
      404
    );
  }

  protected function genericException()
  {
    return $this->getResponse(
      "INTERNAL SERVER ERROR",
      "02",
      500
    );
  }

  protected function validationException($e)
  {
    return response()->json($e->errors(), $e->status);
  }

  protected function httpException($e)
  {
    $messages = [
      405 => [
        "code" => "03",
        "message" => "HTTP VERB NOT ALLOWED"
      ],
      403 => [
        "code" => "04",
        "message" => "ACCESS DENIED"
      ],
      503 => [
        "code" => "00",
        "message" => "MAINTENANCE SERVER"
      ],
      404 => [
          "code" => "05",
          "message" => "SERVICE NOT FOUND"
      ]
    ];

    return $this->getResponse(
      $messages[$e->getStatusCode()]["message"],
      $messages[$e->getStatusCode()]["code"],
      $e->getStatusCode()
    );
  }

  protected function getResponse($message, $code, $status)
  {
    return response()->json([
      "errors" => [
          [
              "status" => $status,
              "code" => $code,
              "message" => $message
          ]
      ]
    ], $status);
  }

}
