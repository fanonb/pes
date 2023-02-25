<?php
class TokenController extends BaseController{
	public function addTokenAction(){
		$strErrorDesc = '';
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		$arrQueryStringParams = $this->getQueryStringParams();

		if(strtoupper($requestMethod) == 'POST'){
			try{
				$tokenModel = new TokenModel();

				if(isset($arrQueryStringParams['token'])){
					$token = $arrQueryStringParams['token'];
				}
				$token = $_POST['token'];
				if ($tokenModel->existToken($token))
					$responseData = json_encode(array('response' => "already created"));
				else{
					$arrToken = $tokenModel->addToken($token);
					$responseData = json_encode(array('response' => "created"));
				}


			} catch (Error $e){
				$strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
				$strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
			}
		} else {
			$strErrorDesc = 'Method not supported';
			$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
		}

		// send output
		if (!$strErrorDesc){
			$this->sendOutput(
				$responseData,
				array('Content-Typee:application/json', 'HTTP/1.1 200 OK')
			);
		} else {
			$this->sendOutput(json_encode(array('error' => $strErrorDesc)),
				array('Content-Type: application/json', $strErrorHeader)
			);
		}
	}
}