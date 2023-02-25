<?php
	require_once PROJECT_ROOT_PATH . '/Model/Database.php';

	class AlertasModel extends Database {

		public function getNumAlertas(): int {
			$resultado = $this->select("select count(id) from alert a where enable = 1 and CURDATE() BETWEEN date_start and date_end;");
			return $resultado[0]['count(id)'];
		}
		public function getAlertasVigentes(): array {
			$resultado = $this->select("select id, icono, priority, title, resume, date_format(date_end, \"%k:%i %d-%m-%Y\") as \"date_end\" 
	from alert a 
  where enable = 1 and CURDATE() BETWEEN date_start and date_end;");
			return $resultado;
		}
	}
