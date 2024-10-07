<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificacion</title>
    <link href="Estilos/estilos.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="nav-grid">
            <nav class="nav-bar">
                <ul>
                    <li><a href="index.php?pagina=Mostrar"><img class="icon" src="Imagenes/newspaper.svg"><span>Articles</span></a></li>
                    <li><a href="index.php?pagina=Insertar"><img class="icon" src="Imagenes/add-square.svg"><span>Insertar Article</span></a></li>
                    <li><a href="index.php?pagina=Borrar"><img class="icon" src="Imagenes/delete-button.svg"><span>Borrar Article</span></a></li>
                    <li><a href="index.php?pagina=Modificar"><img class="icon" src="Imagenes/edit.svg"><span>Modificar Article</span></a></li>
                </ul>
            </nav>
        </div>

        <div class="content">
            <form class="formulario" method="POST" action="index.php?pagina=Modificar">
                <div class="contenido">
                    <label>
                        <h1>Modifica el Articulo</h1>
                    </label>
                    <input type="text" id="titulo" value="<?php echo $titol; ?>" name="titulo" class="campos">
                    <textarea id="cuerpo" name="cuerpo" class="mensaje"><?php echo $cos; ?></textarea>
                    <?php echo $mensaje ?>
                    <button class="btn" type="submit" name="boton" value="<?php echo $ids ?>">Modificar</button>
                </div>
            </form>
        </div>

    </div>

</body>

</html>