<?php
	include_once ('conexion.php');
	session_start();

	function cleanVar($string, $tipo){
	$finalString = '';
	# Comillas
	if ($tipo == "string"){
		$finalString =  str_replace("'","",$string);
		$finalString =  str_replace("\"","",$finalString);
		$finalString =  str_replace("\"","",$finalString);
		$finalString =  str_replace("%","",$finalString);
		$finalString =  str_replace("`","",$finalString);
	}
		return $finalString;
}

	function checkUser($user, $password){
	$user = cleanVar($user,"string");
	$password = cleanVar($password,"string");

	try{
		$query = 'SELECT name, email, password, created_at, validate  
				FROM espirituSanto.users 
				WHERE name="'.$user.'" or email="'.$user.'";';
		$col = mysqli_fetch_array(mysqli_query(conexion(),$query));

		if ($col == null){
			throw new Error('El usuario no existe en la base de datos');
		}
		if ($col['validate'] == 0)
			throw new Error('El usuario no está habilitado, habla con un administrador.');

		$sended = hash('sha256', "$".$user."$".$password);

		if ($sended == $col['password']){
			$_SESSION['login']=true;
		}
		else if ($sended != $col['password']){
			throw new Error('La contraseña no es correcta.');
		}

	}catch (Error $e){
		print '<div id="login-message"><strong>! </strong>'.$e->getMessage().'</div>';
	} finally {
		mysqli_close(conexion());
	}


}

	function createAlert(){
		$titulo = cleanVar($_POST['titulo'],"string");
		$fecha_ini = $_POST['fecha_ini'];
		$fecha_fin = $_POST['fecha_fin'];
		$tipo = $_POST['tipo'];
		$priority = $_POST['prioridad'];
		$descripcion = cleanVar($_POST['descripcion'],"string");
		unset($_POST);

		$query1 = "INSERT INTO espirituSanto.alert (icono,priority,title,resume,date_start,date_end)
                    VALUES('$tipo',$priority,'$titulo','$descripcion','$fecha_ini','$fecha_fin');";

		if (mysqli_query(conexion(), $query1)) {
			$query2 = 'SELECT id from alert ORDER BY id DESC limit 1';
			mysqli_close(conexion());

			$result2 = mysqli_fetch_assoc(mysqli_query(conexion(),$query2));
			$_SESSION['idAlertaCreada'] = $result2['id'];
			mysqli_close(conexion());
		}
		else{
			echo "No se pudo crear la alerta. Contacta con el administrador.";
		}

	}

	function showActiveAlerts(){
		$query = "Select id, title, date_format(date_start, \"%k:%i  %d/%m/%Y\") as \"date_start\",  date_format(date_end, \"%k:%i  %d/%m/%Y\") as \"date_end\" from alert a where enable = 1; ";
		$result = mysqli_query(conexion(),$query);

		echo "<table id='table-alerts'>";
		echo "<tr><th>Título</th><th>Fecha de inicio</th><th>Fecha de fin</th><th></th></tr>";
		$i=0;
		while ($row = mysqli_fetch_assoc($result)) {
			if ($i%2)
				echo "<tr class='tr-par'>";
			else
				echo "<tr class='tr-impar'>";
			echo "<td>".$row['title']."</td>";
			echo "<td>".substr($row['date_start'],0,5)."<br/>".substr($row['date_start'],7,17)."</td>";
			echo "<td>".substr($row['date_end'],0,5)."<br/>".substr($row['date_end'],7,17)."</td>";
			echo "<td>"."<a href='./index.php?id=".$row['id']."'><img src='./assets/images/trash.svg'/></a>"."</td>";
			echo "</tr>";
			$i++;
		}
		echo "</table>";


	}
	function deleteAlert($id){
		$query1 = "UPDATE alert SET enable=0,date_update=now() WHERE id=$id;";


		if (mysqli_query(conexion(), $query1))
			$fin=true;
		else{
			echo "No se pudo eliminar la alerta. Contacta con el administrador.";
		}

		mysqli_close(conexion());
	}

	function enviarAlerta($id){
		$_SESSION['idAlertaCreada']=null;
		unset($_SESSION['idAlertaCreada']);

		$query = "SELECT * FROM alert WHERE id=$id";
		$result = mysqli_query(conexion(),$query);
		$alert = mysqli_fetch_assoc($result);

		$titulo= $alert['title'];
		$descripcion=$alert['resume'];

		$query = "SELECT token from  token;";
		$result = mysqli_query(conexion(),$query);

		$i=0;
		$errores=0;
		print '<p class="envio-line-bien envio-line-normal">Enviando Notificaciones a los usuarios, no cierre la página.</p>';
		while ($row = mysqli_fetch_assoc($result)) {
			$i++;
			if (sendExpoNotification($row['token'], $titulo, $descripcion))
				print '<p class="envio-line envio-line-bien">Envío de notificación (' . $i . "/" . $result->num_rows . ")</p>";
			else{
				print '<p class="envio-line envio-line-error">Envío de notificación (' . $i . "/" . $result->num_rows . ") ❌</p>";
				$errores++;
			}
		}
		print '<p class="envio-line-bien envio-line-normal"><strong>----</strong></p>';
		print '<p class="envio-line-bien envio-line-normal">Envío completado. Errores: (' . $errores . "/" . $result->num_rows . ") ❌</p>";
	}

	function sendExpoNotification($token, $titulo, $description){
		try{
			$expoMessage = [
				'to' => $token,
				'title' => $titulo,
				'body' => $description,
			];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://exp.host/--/api/v2/push/send');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Accept: application/json',
				'Content-Type: application/json',
				'Expo-SDK-Version: 45.0.0', // Reemplaza esto con la versión actual del SDK de Expo
			]);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($expoMessage));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($ch);

			if ($response === false) {
				// Error al hacer la solicitud
				echo 'Error al hacer la solicitud: ' . curl_error($ch);
			} else {
				$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if ($statusCode !== 200) {
					// Error en la respuesta del servidor
					echo 'Error en la respuesta del servidor: ' . $response;
				} else {
					// Éxito
					//echo 'Notificación enviada con éxito';
					return true;
				}
			}

		}catch (Error $e){
			return false;
		}finally{
			curl_close($ch);
		}
	}