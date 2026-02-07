<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="css/estilos.css" rel="stylesheet">
    <style>
      
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(1000px, 10fr));
            gap: 5px;
            padding: 5px;
        }

        .card {
            background-color: #93aeb2df;
            border: 3px solid #070000ff;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(250, 18, 2, 0.1);
            text-align: center;
        }

        .card img {
            width: 100%;
            aspect-ratio: 1 / 1; /* Mantiene imagen cuadrada automáticamente */
            object-fit: contain;   /* Recorta la imagen sin deformarla */
            display: block;
        }

        .card p {
            padding: 0px;
            margin: 0;
        }
    </style>

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
        <a href="carrito.php" class="btn btn-primary">Carrito</a>
      </div>
    </div>
  </div>
</header>
<!--CONTENIDO-->
<main>
    <div class="container">
     <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
      <?php foreach($resultado as $row) { ?>
        <div class="col">
          <div class="card shadow-sm">
            <?php
            $id =$row['id'];
            $imagen = "images/productos/" . $id . "/primero.jpg";
            if(!file_exists($imagen)){
              $imagen = "images/no-photo.jpg";
            }

            ?>
            <img src="<?php echo $imagen;?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['nombre'];?></h5>
              <p class="card-text">$ <?php echo number_format($row['precio'], 2, '.', ',');?>
              </p>
               <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo 
                    hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn 
                    btn-primary">Detalles</a>
                </div>
                <a _ngcontent-ng-c512156147="" class="btn btn-primary" 
                href="https://wa.me/7713393017/?text=Hola.%20Me%20Gustaria%20Conocer%20Mas%20De%20este%20producto:De%20la%20Tienda_Online">Contactar</a>
              </div>
            </div>
          </div>
        </div>
      <?php }?>
    </div>
    
    
</main>
    <div class="container">

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
crossorigin="anonymous"></script>
    
</body>
</html>