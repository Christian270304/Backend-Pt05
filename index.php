<?php
    // Christian Torres Barrantes

    //require_once 'Controlador/controlador.php';
    
    
    
    //require_once 'Controlador/Borrar.php';
    //require_once 'Controlador/Modificar.php';
    session_start();
   
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $opcion = isset($_GET['pagina']) ? $_GET['pagina'] : 'MostrarInici';
        switch ($opcion) {
            case 'Insertar':
                require_once 'Controlador/Insertar.php';
                include 'Html/Insertar.php';
                break;
            case 'Borrar':
                if (!isset($_SESSION['username'])){
                    header("Location: index.php?pagina=MostrarInici");
                } else {
                    require_once 'Controlador/Borrar.php';
                    include 'Html/Borrar.php';
                }
                //require_once 'Controlador/Borrar.php';
                //include 'Html/Borrar.php';
                break;
            case 'Modificar':
                require_once 'Controlador/Modificar.php';
                include 'Html/Modificar.php';
                break;
            case 'Mostrar':
                if (!isset($_SESSION['username'])){
                    header("Location: index.php?pagina=MostrarInici");
                } else {
                    require_once 'Controlador/Mostrar.php';
                    include 'Html/Mostrar.php';
                }
                break;
            case 'MostrarInici':
                if (isset($_SESSION['username'])){
                    session_destroy();
                    require_once 'Controlador/MostrarInici.php';
                    include 'Html/MostrarInici.php';
                } else {
                    require_once 'Controlador/MostrarInici.php';
                    include 'Html/MostrarInici.php';
                }
                break;
            case 'Login':
                require_once 'Controlador/Login.php';
                include 'Html/Login.php';
                break;
            case 'Perfil':
                include 'Html/Perfil.php';
                break;
            case 'SignUp':
                include 'Html/SignUp.php';
                break;
            case 'BorrarVerificar':
                require_once 'Controlador/Borrar.php';
                verificarDelet($_GET['id']);
                break;
            case 'ModificarArticulo':
                require_once 'Controlador/Modificar.php';
                modificarPagina($_GET['id']);
                break;
            default:
            if (isset($_SESSION['username'])){
                header("Location: index.php?pagina=Mostrar");
                exit;
            } else {
                header("Location: index.php?pagina=MostrarInici");
            }
               
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $opcion = isset($_GET['pagina']) ? $_GET['pagina'] : 'Mostrar';
        switch ($opcion) {
            case 'Insertar':
                require_once 'Controlador/Insertar.php';
                insertarDatos($_POST['titulo'],$_POST['cuerpo']);
                break;
            case 'Borrar':
                include 'Html/Borrar.php';
                break;
            case 'BorrarVerificar':
                if ($_POST['boton'] === 'Si') {
                    // Acción cuando se presiona el botón "Sí"
                    require_once 'Controlador/Borrar.php';
                    borrar($_POST['titulo'],$_POST['cuerpo']);
                } elseif ($_POST['boton'] === 'No') {
                    // Acción cuando se presiona el botón "No"
                    require_once 'Controlador/Borrar.php';
                    include 'Html/Borrar.php';
                }
                break;
            case 'Login':
                require_once 'Controlador/Login.php';
                loginDatos($_POST['username'],$_POST['contra']);
                break;
            case 'SignUp':
                require_once 'Controlador/Login.php';
                verificarDatos($_POST['username'],$_POST['correo'],$_POST['contra1'],$_POST['contra2']);
                break;
            case 'Modificar':
                require_once 'Controlador/Modificar.php';
                modificar($_POST['boton'],$_POST['titulo'],$_POST['cuerpo']);
                break;
            default:
                include 'Html/Mostrar.php';
        }
    } 

    
    
    
?>