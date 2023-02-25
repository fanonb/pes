<!DOCTYPE html>
<html lang="es">
	<head>
		<title>PES - Soporte</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

		<link rel="stylesheet" href="assets/css/main.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500;700;800&display=swap" rel="stylesheet">
    </head>
	<body>
        <header>
            <img src="assets/images/icono.svg" alt="logo"/>
            <h1>
                Polígono Espíritu Santo
            </h1>
        </header>
		<div id="box-container">
			<div id="title-container">
				<h1>Formulario de Soporte</h1>
			</div>
            <?php
                include_once ('./conexion.php');

                if($_POST != null){
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $mensaje = $_POST['mensaje'];

	                $query1 = "INSERT INTO espirituSanto.soporte (name,email,question)
                    VALUES('$name','$email','$mensaje');";

	                if (mysqli_query(conexion(), $query1))
                        echo '<h6 style="text-align: center">Formulario enviado correctamente. Te contactaremos antes de 12 horas.</h6>';
	                else{
		                echo "Non se puido realizar o pedido nestes momentos.";
		                exit();
	                }

	                mysqli_close(conexion());
                }else{
            ?>
			<div id="formulario-container">
				<form method="post" action="poligono-espiritu-santo.php">
                    <input type="text" id="name" name="name" placeholder="  Nombre" autocomplete="off" maxlength="20"  autofocus required>
                    <input type="email" id="email" name="email" placeholder="  E-mail"autocomplete="off" maxlength="100" required>
					<textarea id="mensaje" name="mensaje" placeholder="Explicanos el problema. Recibirás una contestación antes de 12 horas." maxlength="850"></textarea>

                    <input id="finalizar-pedido" type="submit" value="Enviar Mensaje">
				</form>
			</div>
            <?php
                }
            ?>
		</div>
	</body>
</html>