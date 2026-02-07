<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == '') {
    echo 'LA RED WIFI ESTA BLOQUEADO POR EL DE SISTEMAS';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {

      $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
      $sql->execute([$id]);
      if ($sql->fetchColumn() > 0){

         $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id=? AND activo=1 LIMIT 1");
         $sql->execute([$id]);
         $row = $sql->fetch(PDO::FETCH_ASSOC);
         $nombre = $row['nombre'];
         $descripcion = $row['descripcion'];
         $precio = $row['precio'];
         $descuento = $row['descuento'];
         $precio_desc = $precio - (($precio * $descuento) /100);
         $dir_images = 'images/productos/' . $id . '/';

         $rutaImg = $dir_images . 'primero.jpg';

         if(!file_exists($rutaImg)){
          $rutaImg = 'images/no-photo.jpg';
         }

         $imagenes = array();
         if (file_exists($dir_images)){
         $dir = dir($dir_images);

         while (($archivo = $dir->read()) != false) {
            if  ($archivo != 'primero.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))){
               $imagenes[] = $dir_images . $archivo;
 
            }
         }
         $dir->close();
        }
      }
    } else {
       echo 'LA RED WIFI ESTA BLOQUEADO POR EL DE SISTEMAS';
       exit;
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">


</head>
<body>
<header>
<main>
  <div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
        <strong>Tienda Online</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
       data-bs-target="#navbarHeader" aria-controls="navbarHeader" 
       aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarHeader">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a href="#" class="nav-link active">Catalogo</a>
            </li>

             <li class="nav-item">
                <a href="#" class="nav-link">Contacto</a>
            </li>
        </ul>
        <a href="carrito.php" class="btn btn-primary">Buenos dias</a>
      </div>
    </div>
  </div>
</header>
<!--CONTENIDO-->

<main>
    <div class="container">
      <div class="row">
        <div class="col-md-6 order-md-1">
          <div id="carouselImages" class="carousel slide">
  <div class="carousel-inner">
    <div class="carousel-item active">
       <img src="<?php echo $rutaImg;?>"  class="d-block w-100">
    </div>

       <?php foreach ($imagenes as $img) { ?>
        <div class="carousel-item">
          <img src="<?php echo $img; ?>" class="d-block w-100">
    </div>
    <?php } ?>

  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
       </button>
        </div>


         </div>
        <div class="col-md-6 order-md-2">
          <h2><?php echo $nombre; ?></h2>

          <?php if ($descuento > 0) { ?>
            <p><del><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></del></p>
            <h2>
              <?php echo MONEDA . number_format($precio_desc, 2, '.', ',');?>
              <small class="text-success"><?php echo $descuento; ?>% descuento</small>
            </h2>

            <?php } else { ?>

          <h2><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h2>

           <?php } ?>

          <p class="lead">
            <?php echo $descripcion; ?>
            </p>
            <div class="d-grid gap-3 col-10 mx-auto">

              <!--CONTENIDO PARA AGREGAR EL BOTON A WHATSAP-->
              <a _ngcontent-ng-c512156147="" class="btn btn-primary" 
              href="https://wa.me/7713393017/?text=Hola.%20Me%20Gustaria%20Conocer%20Mas%20De%20este%20producto:De%20la%20Tienda_Online">Contactar</a>
              
          </div> 
          
        </div>
      </div>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
crossorigin="anonymous"></script>
<!--se crea la funcion producto para el botn donde recibe un id y un token, y se envia mediante ayacs en tiempo real -->
<script>
  function addProducto(id, token){
    let url = 'clases/carrito.php'
    let formData = new FormData()
  }
  //video 5 en minuito 3
</script>
    
</body>
</html>