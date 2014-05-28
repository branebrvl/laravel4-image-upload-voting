<?php

use Illuminate\Http\Response as IlluminateResponse;
/**
 * ApiController 
 * 
 * @uses BaseController
 * TODO replace status codes
 */
class ApiController extends BaseController {
  
  protected $statusCode = IlluminateResponse::HTTP_OK;

  public  function getStatusCode()
  {
    return $this->statusCode;
  }

  public  function setStatusCode()
  {
    $this->statusCode = $statusCode;

    return $this;
  }

  public function respondNotFound($message = 'Not Found')
  {
    $this->setStatusCode(404)
         ->respondWithError($message);
  }

  public function respondInternalError($message = 'Internal Error!')
  {
    $this->setStatusCode(500)
         ->respondWithError($message);
  }

  public function respondValidationError($message = 'Validation Error!')
  {
      return $this->setStatusCode(422)
                  ->respondWithError($message);
  }

  public function respond($data, $headers = [])
  {
    return Response::json($data, $this->getStatusCode(), $headers);
  }

  public function respondWithEror($message)
  {
    return $this->respond([
      'error' => [
        'message' => $message,
        'status_code' => $this->getStatusCode()
      ]  
    ]);
  }

  public function respondCreated($message)
  {
    return $this->setStatusCode(201)
                ->respond([
                  'status' => 'success',
                  'message' => $message
                ]);
  }

  protected function respondWithPagination($lessons, $data)
  {
    $data = array_merge($data, [
       'paginator' => [
        'total_count' => $lessons->getTotal(),
        'total_pages' => ceil($lessons->getTotal() / $lessons->getPerPage()),
        'current_page' => $lessons->getCurrentPage(),
        'limit' => $lessons->getPerPage()
       ]
      ]);

    return $this->respond($data);
  }
}
