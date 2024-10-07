<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar</title>
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
            <h1>Introduce un Articulo</h1>
            <form class="formulario" method="POST" action="index.php?pagina=Insertar">
                <div class="contenido">
                    <label>
                        <h1>Titol</h1>
                    </label>
                    <input type="text" id="titulo" value="<?php echo isset($titulo) ? $titulo : ''; ?>" name="titulo" class="campos">
                    <label>
                        <h1>Cos</h1>
                    </label>
                    <textarea id="cuerpo" name="cuerpo" class="mensaje"><?php echo isset($cuerpo) ? $cuerpo : ''; ?></textarea>
                    <?php echo isset($mostrar) ? $mostrar : '' ?>
                    <button class="btn" type="submit" name="boton">Enviar</button>
                </div>
            </form>
        </div>

    </div>
</body>

</html>