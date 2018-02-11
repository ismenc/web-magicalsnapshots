<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Registro</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">

        <!-- bootstrap -->
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">      
		<link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">		
		<link href="../themes/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->
		<link href="../themes/css/flexslider.css" rel="stylesheet"/>
		<link href="../themes/css/main.css" rel="stylesheet"/>

		<!-- scripts -->
		<script src="../themes/js/jquery-1.7.2.min.js"></script>
		<script src="../bootstrap/js/bootstrap.min.js"></script>				
		<script src="../themes/js/superfish.js"></script>	
		<script src="../themes/js/jquery.scrolltotop.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        

	</head>
    <body>		
		<div id="top-bar" class="container">
			<div class="row">
				<div class="span4">
					<form method="POST" class="search_form">
						<input type="text" class="input-block-level search-query" Placeholder="eg. T-sirt">
					</form>
				</div>
				<div class="span8">
					<div class="account pull-right">
						<ul class="user-menu">				
							<li><a href="../#">Mi cuenta</a></li>
							<li><a href="../cart.html">Carrito</a></li>
							<li><a href="../checkout.html">Caja</a></li>					
							<li><a href="../register.html">Login</a></li>		
						</ul>
					</div>
				</div>
			</div>
		</div>
        
        <!-- ================================== MENU ================================== -->
        
		<div id="wrapper" class="container">
			<section class="navbar main-menu">
				<div class="navbar-inner main-menu">				
					<a href="index.php" class="logo pull-left"><img src="themes/images/logo.png" class="site_logo" alt=""></a>
					<nav id="menu" class="pull-right">
                        
                        
						<?php include('muestramenu_alternativo.php');?>
                        
                        
					</nav>
				</div>
			</section>			
			<section class="header_text sub">
			<img class="pageBanner" src="themes/images/pageBanner.png" alt="New products" >
				<h4><span>Registro y Login</span></h4>
			</section>			
			<section class="main-content">				
				<div class="row">

					<!-- ================================== Contenido interesante ================================== -->

					<?php

					    // Inicializamos y conectamos. Database.php incluido en el muestramenu.php de arriba
					    extract($_POST);
					    include_once('recaptchalib.php');

					    
					    // Elementos del captcha
					    $sentCaptcha=$_POST["g-recaptcha-response"];
					    $secretKey = "6LcTuUUUAAAAANW5jhPnFRstntcUgcQbwmq8EBIC";
					    $url= "https://www.google.com/recaptcha/api/siteverify";
					 	$infoForGoogle=$url."?secret=".$secretKey."&response=".$sentCaptcha."&remoteip=".$_SERVER['REMOTE_ADDR'];

					 	// Obtenemos captcha
					 	if (!$_POST["g-recaptcha-response"]) {
					 		echo "<p>DEBE PULSAR CAPTCHA</p>";
					 	} else{
					 		$jsondata=curl_init($infoForGoogle);

							curl_setopt($jsondata,CURLOPT_RETURNTRANSFER, TRUE);
							$jsondata = curl_exec($jsondata);

							$getGoogle = json_decode($jsondata,true);

							$resultado = $getGoogle['success'];

							// Captcha entregado bien o mal
							if ($resultado!=null){

								// Captcha bien
								if ($resultado) {
									$link = mysqli_connect(ADDRES_SERVER, USER, PASS, SERVERMYSQL);

									// Comprobación de conexión
								    if (mysqli_connect_errno()) {
								        printf("<header>Fallo en la conexión: %s</header>", mysqli_connect_error());
								    }
								    else{

								        
								        // Evitar la inyeccción de codigo y encriptamos pass
							            $usuario = mysqli_real_escape_string($link, $usuario);
							            $nombre = mysqli_real_escape_string($link, $nombre);
							            $apellidos = mysqli_real_escape_string($link, $apellidos);
							            $email = mysqli_real_escape_string($link, $email);
							            $password=password_hash($password, PASSWORD_DEFAULT);
							            $direccion = mysqli_real_escape_string($link, $direccion);
							            $provincia = mysqli_real_escape_string($link, $provincia);	

										/* Comprobamos posibles errores (Usuario o email ya existen) */
										$comprobacion = mysqli_query($link, "SELECT USUARIO FROM usuario WHERE USUARIO='$usuario'");
										$row = mysqli_fetch_row($comprobacion);
								        if($row[0] == $usuario){
								                printf("<header>El usuario \"$usuario\" ya está registrado.</header><br>
								                	<p><a href=\"..\">Volver atrás</a></p>");
								        }
								        else{


								        	$comprobacion = $result = mysqli_query($link, "SELECT EMAIL FROM usuario WHERE EMAIL='$email'");
								        	$row = mysqli_fetch_row($comprobacion);
								            if($row[0] == $email){
								            	printf("<header>El email \"$email\" ya está registrado.</header><br>
								                	<p><a href=\"..\">Volver atrás</a></p>");
								            }else{
								                
								            	// Insertamos en base de datos
								                $insert="INSERT INTO ".TABLA_USUARIO." (".COLUMNAS_USUARIO.") VALUES ('$usuario','$nombre', '$apellidos', '$email', '$password', '$direccion', '$provincia')";

								                $resultadoInsercion = mysqli_query($link, $insert);

								                // Interpretación de resultados
								                if ($resultadoInsercion){
								                    echo "<header>Registro realizado con éxito. <a href=\"..\">Volver a la página principal</a></header>";
								                }
								                else{
								                    echo "<header>No fue posible registrar el usuario.<br>Vuelve a <a href=\"../register.php\">registro</a> y comprueba algún campo.</header>";
								                }
								            }
								        }
								        mysqli_close($link);
								    }
								}
								else{
									echo "<header>Captcha incorrecto</header>";
								}
							}
							else{
								echo "<header>Debe rellenar el captcha</header>";
							}
					 	}

					?>




				</div>
			</section>			
			<section id="footer-bar">
				<div class="row">
					<div class="span3">
						<h4>Navegación</h4>
						<ul class="nav">
							<li><a href="../index.php">Página principal</a></li>  
							<li><a href="../about.html">Sobre nosotros</a></li>
							<li><a href="../contact.html">Contacta</a></li>
							<li><a href="../cart.html">Carrito</a></li>
							<li><a href="../register.html">Login</a></li>							
						</ul>					
					</div>
					<div class="span4">
						<h4>Mi cuenta</h4>
						<ul class="nav">
							<li><a href="#">Mi cuenta</a></li>
							<li><a href="#">Historial de pedidos</a></li>
							<li><a href="#">Lista de deseos</a></li>
							<li><a href="#">Newsletter</a></li>
						</ul>
					</div>
					<div class="span5">
						<p class="logo"><img src="themes/images/logo.png" class="site_logo" alt=""></p>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. the  Lorem Ipsum has been the industry's standard dummy text ever since the you.</p>
						<br/>
						<span class="social_icons">
							<a class="facebook" href="#">Facebook</a>
							<a class="twitter" href="#">Twitter</a>
							<a class="skype" href="#">Skype</a>
							<a class="vimeo" href="#">Vimeo</a>
						</span>
					</div>					
				</div>	
			</section>
			<section id="copyright">
				<span>Copyright 2013 MagicalSnapshots  All right reserved.</span>
			</section>
		</div>
		<script src="themes/js/common.js"></script>
		<script>
			$(document).ready(function() {
				$('#checkout').click(function (e) {
					document.location.href = "checkout.html";
				})
			});
		</script>		
    </body>
</html>