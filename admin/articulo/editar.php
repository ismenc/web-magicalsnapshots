<?php
  session_start();
  $rutaCss = "../..";
  require($rutaCss.'/php/database.php');
  include $rutaCss.'/admin/comienzo-pagina.php';
?>


<header>Editar un artículo</header>

<?php 
if (isset($_SESSION['admin'])){
  echo '
<form id="form"  enctype="multipart/form-data" class="topBefore" action="editar-datos.php" method="get" autocomplete="off">

    <!-- Elementos del formulario -->';
	


      // Conectamos y comprobamos la conexión
      $link = mysqli_connect(ADDRES_SERVER, USER, PASS, SERVERMYSQL);
      if (mysqli_connect_errno()) {
              printf("<header>Fallo en la conexión: %s</header>", mysqli_connect_error());
      }
      else{

          // Consultamos e imprimimos las opciones
          $query="SELECT ID, NOMBRE FROM ".TABLA_ARTICULO;
          if ($result = mysqli_query($link, $query)) {
              
              echo"<select name=\"idarticulo\" class=\"spinner\">";
              echo "<option value=\"\" disabled selected>ID del artículo</option>";
                  
              while ($row = mysqli_fetch_row($result)) {
                  echo "<option value=\"".$row[0]."\">".$row[0]." - ".$row[1]."</option>";
              }
              echo "</select><br>";
              mysqli_free_result($result);
          }
          mysqli_close($link);
      }


  
    echo '<!-- Botones de navegación -->
    
  <input id="ultimo" type="submit" value="Seleccionar artículo">
  
</form>';
} ?>
    
<?php 
  include $rutaCss.'/admin/fin-pagina.php'; 
?>
