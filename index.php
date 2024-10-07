<?php
    // Christian Torres Barrantes

    require_once 'Controlador/controlador.php';
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $opcion = isset($_GET['pagina']) ? $_GET['pagina'] : 'Mostrar';

        switch ($opcion) {
            case 'Insertar':
                include 'Html/Insertar.php';
                break;
            case 'Borrar':
                include 'Html/Borrar.php';
                break;
            case 'Modificar':
                include 'Html/Modificar.php';
                break;
            case 'Mostrar':
                include 'Html/Mostrar.php';
                break;
            case 'BorrarVerificar':
                verificarDelet($_GET['id']);
                break;
            case 'ModificarArticulo':
                modificarPagina($_GET['id']);
                break;
            default:
                include 'Html/Mostrar.php';
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $opcion = isset($_GET['pagina']) ? $_GET['pagina'] : 'Mostrar';
        switch ($opcion) {
            case 'Insertar':
                insertarDatos($_POST['titulo'],$_POST['cuerpo']);
                break;
            case 'Borrar':
                include 'Html/Borrar.php';
                break;
            case 'BorrarVerificar':
                if ($_POST['boton'] === 'Si') {
                    // Acción cuando se presiona el botón "Sí"
                    borrar($_POST['titulo'],$_POST['cuerpo']);
                } elseif ($_POST['boton'] === 'No') {
                    // Acción cuando se presiona el botón "No"
                    include 'Html/Borrar.php';
                }
                break;
            case 'Modificar':
                modificar($_POST['boton'],$_POST['titulo'],$_POST['cuerpo']);
                break;
            default:
                include 'Html/Mostrar.php';
        }
    } 

    
    
    
?>