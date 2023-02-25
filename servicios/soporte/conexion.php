<?php
	function conexion()
	{
		$db = "espirituSanto";
		$server = "46.101.16.148";
		$user = "espirituSanto-api";
		$password = "abc123.";
		$con = mysqli_connect($server, $user, $password, $db)
		or die("No se ha podido establecer la conexión.");
		return $con;
	}