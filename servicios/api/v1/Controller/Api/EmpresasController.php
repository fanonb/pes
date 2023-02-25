<?php
class EmpresasController extends BaseController
{
	public function searchAction()
	{
		$strErrorDesc = '';
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		$arrQueryStringParams = $this->getQueryStringParams();

		if (strtoupper($requestMethod) == 'GET') {
			try {
				$empresasModel = new EmpresasModel();

				if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
					$intLimit = $arrQueryStringParams['limit'];
				}
				$search = $_GET['search'];
				$arrEmpresas = $empresasModel->getEmpresasName($search);
				$responseData = json_encode($arrEmpresas);
			} catch (Error $e) {
				$strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
				$strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
			}
		} else {
			$strErrorDesc = 'Method not supported';
			$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
		}

		// send output
		if (!$strErrorDesc) {
			$this->sendOutput(
				$responseData,
				array('Content-Type: application/json', 'HTTP/1.1 200 OK')
			);
		} else {
			$this->sendOutput(json_encode(array('error' => $strErrorDesc)),
				array('Content-Type: application/json', $strErrorHeader)
			);
		}
	}

	public function getAction()
	{
		$strErrorDesc = '';
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		$arrQueryStringParams = $this->getQueryStringParams();

		if (strtoupper($requestMethod) == 'GET') {
			try {
				$empresasModel = new EmpresasModel();

				$id = $_GET['id'];
				$arrEmpresas = $empresasModel->getEmpresaById($id);
				$responseData = json_encode($arrEmpresas);
			} catch (Error $e) {
				$strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
				$strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
			}
		} else {
			$strErrorDesc = 'Method not supported';
			$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
		}

		// send output
		if (!$strErrorDesc) {
			$this->sendOutput(
				$responseData,
				array('Content-Type: application/json', 'HTTP/1.1 200 OK')
			);
		} else {
			$this->sendOutput(json_encode(array('error' => $strErrorDesc)),
				array('Content-Type: application/json', $strErrorHeader)
			);
		}
	}

	public function listAllAction()
	{
		$strErrorDesc = '';
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		$arrQueryStringParams = $this->getQueryStringParams();

		if (strtoupper($requestMethod) == 'GET') {
			try {
				$empresasModel = new EmpresasModel();

				$intLimit = 10;
				if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
					$intLimit = $arrQueryStringParams['limit'];
				}

				$arrEmpresas = $empresasModel->getEmpresas();
				$responseData = json_encode($arrEmpresas);
			} catch (Error $e) {
				$strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
				$strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
			}
		} else {
			$strErrorDesc = 'Method not supported';
			$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
		}

		// send output
		if (!$strErrorDesc) {
			$this->sendOutput(
				$responseData,
				array('Content-Type: application/json', 'HTTP/1.1 200 OK')
			);
		} else {
			$this->sendOutput(json_encode(array('error' => $strErrorDesc)),
				array('Content-Type: application/json', $strErrorHeader)
			);
		}
	}
}