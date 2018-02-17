<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="es">
	<head>
        <meta http-equiv="pragma" content="no-cache" />

		<meta charset="utf-8">
		<title>MagicalSnapshots</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
        
		<!-- bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">      
		<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		
		<link href="themes/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->
		<link href="themes/css/flexslider.css" rel="stylesheet"/>
		<link href="themes/css/main.css" rel="stylesheet"/>

		<!-- scripts -->
		<script src="themes/js/jquery-1.7.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>				
		<script src="themes/js/superfish.js"></script>	
		<script src="themes/js/jquery.scrolltotop.js"></script>

        
	</head>
    <body>		
		<div id="top-bar" class="container">
			<div class="row">
				<div class="span4">
					
					<form method="GET" class="search_form" action="products.php">
						<?php 
						extract($_GET);
						if(isset($cat))
							echo "<input type=\"hidden\" name=\"cat\" class=\"input-block-level search-query\" value=\"".$cat."\">";
						if(isset($subcat))
							echo "<input type=\"hidden\" name=\"subcat\" class=\"input-block-level search-query\" value=\"".$subcat."\">";
					?>
						<input type="text" name="titulo" class="input-block-level search-query" Placeholder="Por ejemplo: existe dios?">
					</form>
				</div>
				<div class="span8">
					<div class="account pull-right">
						<ul class="user-menu">				
							<li><a href="#">Mi cuenta</a></li>
							<li><a href="cart.html">Carrito</a></li>
							<li><a href="checkout.html">Caja</a></li>							
							<?php
								if(isset($_SESSION['username'])){
									echo "<li><a href=\"myprofile.php\">Bienvenido ", $_SESSION['username'], "</a></li>";
									echo "<li><a href=\"./php/logout.php\">Logout</a></li>";
								}
								else{
									echo "<li><a href=\"register.php\">Login y registro</a></li>";
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
        
        <!-------------------- NAVEGACIÓN -------------------->
        
		<div id="wrapper" class="container">            
            
            <section class="navbar main-menu">
				<div class="navbar-inner main-menu">				
					<a href="index.php" class="logo pull-left"><img src="themes/images/logo.png" class="site_logo" alt=""></a>
					<nav id="menu" class="pull-right">
                        
                       <?php include('php/muestramenu.php');?>
                        
					</nav>
				</div>
			</section>


			<!-- ------------------------------------ Contenido ------------------------------------ -->


			<section class="header_text sub">
			<img class="pageBanner" src="themes/images/pageBanner.png" alt="New products" >
				<?php
					if(!isset($_SESSION['carro']) || empty($_SESSION['carro'])){
						echo '<h4><span>No tiene productos en el carrito</span></h4>';
					}else{
						echo '<h4><span>Carrito de la compra</span></h4>';
						echo '<h4 align="center"><span><a href="php/vaciar_carrito.php">Vaciar carrito</a></span></h4>';
				?>
			</section>
			<section class="main-content">
				
				<div class="row">
					<div class="span9">								
						<ul class="thumbnails listing-products">
							<?php
									$link = mysqli_connect(ADDRES_SERVER, USER, PASS, SERVERMYSQL);
							        if (mysqli_connect_errno()) {
							                printf("<header>Fallo en la conexión: %s</header>", mysqli_connect_error());
							        }
							        else{
										$carro = $_SESSION['carro'];
										foreach($carro as $c => $producto){

											$consulta = mysqli_query($link, "SELECT ID, FOTO, NOMBRE, DESCRIPCION, PRECIO FROM ".TABLA_ARTICULO." WHERE ID='".$producto['id']."'");
											$row = mysqli_fetch_row($consulta);

											?>
											<li class="span3">
												<div class="product-box">
													<span class="sale_tag"></span>												
													<a href=<?php echo "\"product_detail.php?id=".$row[0]."\""; ?>><img alt="" src=<?php echo "\"admin/images/articulos/".$row[1]."\""; ?>></a><br/>
													<a href=<?php echo "\"product_detail.php?id=".$row[0]."\""; ?> class="title"><?php echo $row[2]; ?></a><br/>
													<!--a href="#" class="category">Phasellus consequat</a-->
													<p class="price"><?php echo $row[4]; ?> € <br><?php echo $producto['cantidad'];?> uds<br>Subtotal = <?php echo $row[4]*$producto['cantidad']; ?> €</p>
												</div>
											</li> 
											<?php
										}
									}
								}
							?>
						</ul>								
						<hr>
						<div class="pagination pagination-small pagination-centered">
							<ul>
							<!--?php

								$get = "?";
								if(isset($cat) && $cat >= 0)
									$get .= "cat=$cat&";
								if(isset($subcat))
									$get .= "subcat=$subcat&";
								if (isset($titulo))
									$get .= "titulo=$titulo&";


								for ($i=0; $i < $totalPaginas ; $i++){
									if($i==$pag)
										echo "<li class=\"active\"><a href=\"products.php".$get."pag=".$i."\">".$i."</a></li>";
									else
										echo "<li><a href=\"products.php".$get."pag=".$i."\">".$i."</a></li>";
								}
							?-->
							</ul>
						</div>
					</div-->
					<!--div class="span3 col">
						<div class="block">	
							<ul class="nav nav-list">
								<li class="nav-header">SUB CATEGORIES</li>
								<li><a href="products.html">Nullam semper elementum</a></li>
								<li class="active"><a href="products.html">Phasellus ultricies</a></li>
								<li><a href="products.html">Donec laoreet dui</a></li>
								<li><a href="products.html">Nullam semper elementum</a></li>
								<li><a href="products.html">Phasellus ultricies</a></li>
								<li><a href="products.html">Donec laoreet dui</a></li>
							</ul>
							<br/>
							<ul class="nav nav-list below">
								<li class="nav-header">MANUFACTURES</li>
								<li><a href="products.html">Adidas</a></li>
								<li><a href="products.html">Nike</a></li>
								<li><a href="products.html">Dunlop</a></li>
								<li><a href="products.html">Yamaha</a></li>
							</ul>
						</div>
						<div class="block">
							<h4 class="title">
								<span class="pull-left"><span class="text">Randomize</span></span>
								<span class="pull-right">
									<a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
								</span>
							</h4>
							<div id="myCarousel" class="carousel slide">
								<div class="carousel-inner">
									<div class="active item">
										<ul class="thumbnails listing-products">
											<li class="span3">
												<div class="product-box">
													<span class="sale_tag"></span>												
													<img alt="" src="themes/images/ladies/1.jpg"><br/>
													<a href="product_detail.html" class="title">Fusce id molestie massa</a><br/>
													<a href="#" class="category">Suspendisse aliquet</a>
													<p class="price">$261</p>
												</div>
											</li>
										</ul>
									</div>
									<div class="item">
										<ul class="thumbnails listing-products">
											<li class="span3">
												<div class="product-box">												
													<img alt="" src="themes/images/ladies/2.jpg"><br/>
													<a href="product_detail.html" class="title">Tempor sem sodales</a><br/>
													<a href="#" class="category">Urna nec lectus mollis</a>
													<p class="price">$134</p>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="block">								
							<h4 class="title"><strong>Best</strong> Seller</h4>								
							<ul class="small-product">
								<li>
									<a href="#" title="Praesent tempor sem sodales">
										<img src="themes/images/ladies/3.jpg" alt="Praesent tempor sem sodales">
									</a>
									<a href="#">Praesent tempor sem</a>
								</li>
								<li>
									<a href="#" title="Luctus quam ultrices rutrum">
										<img src="themes/images/ladies/4.jpg" alt="Luctus quam ultrices rutrum">
									</a>
									<a href="#">Luctus quam ultrices rutrum</a>
								</li>
								<li>
									<a href="#" title="Fusce id molestie massa">
										<img src="themes/images/ladies/5.jpg" alt="Fusce id molestie massa">
									</a>
									<a href="#">Fusce id molestie massa</a>
								</li>   
							</ul>
						</div>
					</div-->
				</div>
			</section>
			<section id="footer-bar">
				<div class="row">
					<div class="span3">
						<h4>Navigation</h4>
						<ul class="nav">
							<li><a href="./index.html">Homepage</a></li>  
							<li><a href="./about.html">About Us</a></li>
							<li><a href="./contact.html">Contac Us</a></li>
							<li><a href="./cart.html">Your Cart</a></li>
							<li><a href="./register.html">Login</a></li>							
						</ul>					
					</div>
					<div class="span4">
						<h4>My Account</h4>
						<ul class="nav">
							<li><a href="#">My Account</a></li>
							<li><a href="#">Order History</a></li>
							<li><a href="#">Wish List</a></li>
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
				<span>Copyright 2013 bootstrappage template  All right reserved.</span>
			</section>
		</div>
		<script src="themes/js/common.js"></script>	
    </body>
</html>