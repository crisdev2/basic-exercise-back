<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class RequestService
{
  public $request;

  public function __construct(
    Request $request,
  )
  {
    $this->request = $request;
  }

  private function objectToArray($obj) {
    if(is_object($obj)) $obj = (array) $obj;
    if(is_array($obj)) {
        $new = array();
        foreach($obj as $key => $val) {
            $new[$key] = $this->objectToArray($val);
        }
    }
    else $new = $obj;
    return $new;
  }

  public function getContent() {
    $data = json_decode($this->request->getContent());
    return $this->objectToArray($data);
  }
}