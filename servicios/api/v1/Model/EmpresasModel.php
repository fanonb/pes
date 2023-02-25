<?php
	require_once PROJECT_ROOT_PATH . "/Model/Database.php";

	class EmpresasModel extends Database
	{
		public function getEmpresas() : array
		{
			return $this->select("SELECT * FROM empresa_short");
		}
		public function getEmpresasLimit($limit) : array
		{
			return $this->select("SELECT * FROM empresa_short ORDER BY id LIMIT ?", ["i", $limit]);
		}

		public function getEmpresasName($name) : array
		{
			$name = "'%".strtoupper($name)."%'";
			return $this->select("SELECT * FROM empresa_short WHERE UPPER(name) like ".$name);
		}

		public function getEmpresaById($id) : array
		{
			return $this->select("SELECT * FROM empresa_short WHERE id=?",["i",$id]);
		}
	}