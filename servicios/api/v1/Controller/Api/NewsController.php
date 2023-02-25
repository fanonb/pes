<?php
	class NewsController extends BaseController
	{
		public function listAllAction()
		{
			$strErrorDesc = '';
			$requestMethod = $_SERVER["REQUEST_METHOD"];
			$arrQueryStringParams = $this->getQueryStringParams();

			if (strtoupper($requestMethod) == 'GET') {
				try {
					$newsModel = new NewsModel();

					$arrNews = $newsModel->getAllNews();
					$responseData = json_encode($arrNews);
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

		public function listAllReversePaginatedAction()
		{
			$strErrorDesc = '';
			$requestMethod = $_SERVER["REQUEST_METHOD"];
			$arrQueryStringParams = $this->getQueryStringParams();

			if (strtoupper($requestMethod) == 'GET') {
				try {
					$newsModel = new NewsModel();

					$page = $_GET['page'];
					$limit = 10;

					$arrNews = $newsModel->getAllReversePaginatedNews($page,$limit);
					$responseData = json_encode($arrNews);
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

		public function listAllReverseAction()
		{
			$strErrorDesc = '';
			$requestMethod = $_SERVER["REQUEST_METHOD"];
			$arrQueryStringParams = $this->getQueryStringParams();

			if (strtoupper($requestMethod) == 'GET') {
				try {
					$newsModel = new NewsModel();

					$arrNews = $newsModel->getAllReverseNews();
					$responseData = json_encode($arrNews);
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
					$newsModel = new NewsModel();

					$id=$_GET['id'];
					$arrNews = $newsModel->getANew($id);
					$responseData = json_encode($arrNews);
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

		public function listAction()
		{
			$strErrorDesc = '';
			$requestMethod = $_SERVER["REQUEST_METHOD"];
			$arrQueryStringParams = $this->getQueryStringParams();

			if (strtoupper($requestMethod) == 'GET') {
				try {
					$newsModel = new NewsModel();

					$intLimit = $_GET['limit'];
					if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
						$intLimit = $arrQueryStringParams['limit'];
					}

					$arrNews = $newsModel->getNewsLimit($intLimit);
					$responseData = json_encode($arrNews);
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
