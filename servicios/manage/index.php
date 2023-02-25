<?php
    include_once ('./funciones.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>PES - Administración</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

        <link rel="stylesheet" href="assets/css/main.css">

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
	</head>

	<body>
        <?php
          if(isset($_GET['id'])){
              deleteAlert($_GET['id']);
	          header("Location: ./index.php");
              exit();
          }
          if ($_GET['logout']=='true') {
	          session_unset();
	          session_destroy();
          }
          else if($_POST){
              if ($_POST['form']=="login")
                checkUser($_POST['usuario'],$_POST['password']);
          }
        ?>
        <?php

          if(!isset($_SESSION['login']) or $_SESSION['login']!="true"){
        ?>
        <div id="login-container">
            <div id="login-logo">
                <img src="assets/images/icono.svg" alt="logo">
            </div>
            <div id="login-form-container">
                <form method="post" action="index.php">
                    <label>
                        Usuario
                        <input type="text" id="usuario" name="usuario" autofocus maxlength="20" autocomplete="off" required/>
                    </label>
                    <label>
                        Contraseña
                        <input type="password" id="password" name="password" maxlength="20" autocomplete="off" required/>
                    </label>
                    <input id="login-form" name="form" type="hidden" value="login">
                    <input id="login-submit" type="submit" value="Iniciar Sesión">
                </form>
            </div>
        </div>
        <?php
	        }

          if (isset($_SESSION['login']) and $_SESSION['login']=='true'){
        ?>
        <div id="dashboard-container">
            <header id="dashboard-header">
                <div id="dashboard-header-container">
                    <img src="assets/images/icono.svg" alt="logo"/>
                    <div id="dashboard-header-container-menu">
                        <ul>
                            <a class="menu-item"><li>Alertas</li></a>
                        </ul>
                    </div>
                    <div id="dashboard-header-container-logout">
                        <p><a href="./index.php?logout=true">Cerrar Sesión</a></p>
                    </div>
                </div>
            </header>
            <header id="dashboard-subheader">
                <div id="dashboard-subheader-container">
                    <h1>
                        Alertas
                    </h1>
                </div>
            </header>
            <div id="dashboard-alert-main-container">
                <div id="dashboard-alert-main">
		            <?php
			            if ($_POST['form']=='create-alert')
				            createAlert();
		            ?>
                    <div id="dashboard-alert-container">
                        <div>
                            <h1 class="dashboard-title">Creación de Alertas</h1>
                        </div>
                        <form action="index.php" method="post">
                            <div class="row">
                                <div class="col">
                                    <label>
                                        Título
                                        <input type="text" id="titulo" name="titulo" maxlength="25" autocomplete="off" required/>
                                    </label>
                                </div>
                                <div class="col">
                                    <label>Fecha de Comienzo
                                        <input type="datetime-local" id="fecha_ini" name="fecha_ini">
                                    </label>
                                    <label>Fecha de Fin
                                        <input type="datetime-local" id="fecha_fin" name="fecha_fin">
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="tipo">Tipo
                                        <select name="tipo" id="tipo">
                                            <option value="9">Notificación Normal</option>
                                            <option value="0">Sin Especificar</option>
                                            <option value="1">Inundación</option>
                                            <option value="2">Carretera Cortada</option>
                                            <option value="3">Obras</option>
                                            <option value="0">Huelga</option>
                                            <option value="0">Vigilancia</option>
                                            <option value="0">Cierre del Polígono</option>
                                            <option value="0">Evento Especial</option>
                                        </select>
                                    </label>
                                </div>

                                <div class="col">
                                    <label for="tipo">Prioridad
                                        <select name="prioridad" id="prioridad">
                                            <option value="0">Informativa</option>
                                            <option value="1">Baja</option>
                                            <option value="2">Media</option>
                                            <option value="3">Alta</option>
                                            <option value="4">Excepcional</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <textarea id="descripcion" name="descripcion" rows="8" placeholder="" maxlength="250"></textarea>
                            </div>
                            <input id="login-form" name="form" type="hidden" value="create-alert">
                            <div class="row">
                                <input id="login-submit" type="submit" value="Enviar Alerta">
                            </div>
                        </form>
                        <div id="sending-notifications">
                            <?php
                                if (isset($_SESSION['idAlertaCreada']) and $_SESSION['idAlertaCreada'] != null)
                                    enviarAlerta($_SESSION['idAlertaCreada']);
                            ?>
                        </div>
                    </div>
                </div>
                <div id="dashboard-alert-list">
                    <div id="dashboard-alert-list-container">
                        <h1 class="dashboard-title">Alertas Creadas</h1>
                        <div id="dashboard-alert-list-table">
		                    <?php
			                    showActiveAlerts();
		                    ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
	</body>
</html>