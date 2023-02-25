<?php
	require_once PROJECT_ROOT_PATH . '/Model/Database.php';

	class TokenModel extends Database{

		public function existToken($token) : bool
		{
			$result = $this->select("SELECT * FROM espirituSanto.token t WHERE t.token=?",["s", $token]);
			if ($result == null)
				return false;
			else
				return true;
		}
		public function addToken($token) : bool
		{
			return $this->insert("INSERT INTO token (token) VALUES (?)", ["s", $token]);
		}
	}