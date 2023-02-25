<?php
	require_once PROJECT_ROOT_PATH . "/Model/Database.php";

	class NewsModel extends Database
	{
		public function getAllNews() : array
		{
			return $this->select("SELECT * FROM news ORDER BY id");
		}
		public function getAllReverseNews() : array
		{
			return $this->select("SELECT * FROM news ORDER BY id DESC");
		}
		public function getAllReversePaginatedNews($page, $limit) : array
		{
			$ini = $page * $limit;
			$fin = $ini + $limit;
			return $this->select("SELECT id, title, image, resume, date_format(publish_date, \"%d-%m-%Y\") as \"publish_date\" FROM news ORDER BY id DESC LIMIT ".$limit." OFFSET ".$ini.";");
		}
		public function getNewsLimit($limit) : array
		{
			return $this->select("SELECT * FROM news ORDER BY id DESC LIMIT ?", ["i", $limit]);
		}
		public function getANew($id) : array
		{
			return $this->select("SELECT * FROM news WHERE id = ? ORDER BY id DESC", ["i", $id]);
		}
}