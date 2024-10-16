<?php

    require_once 'Model/Login.php';

    function loginDatos($user, $password) {
        $mensajes = array();
        $mensaje = '';

        // Validar inputs
        $username = isset($user) ? trim(htmlspecialchars($user)) : '';
        $contra = isset($password) ? trim(htmlspecialchars($password)) : '';

        if (empty($username)) {
            $mensajes[] = "El campo del correo no puede estar vacío";
        }

        if (empty($contra)) {
            $mensajes[] = "El campo de la contraseña no puede estar vacío";
        }

        // Solo continuamos si no hay errores previos
        if (empty($mensajes)) {
            // Buscar usuario en la base de datos
            $result = buscarUsuario($username);
            if ($result) {
                // Verificar la contraseña con el hash
                if (password_verify($contra, $result['password'])) {
                    // Iniciar la sesión
                    $_SESSION['username'] = $username;
                    header("Location: index.php?pagina=Mostrar");
                    exit;  // Detener ejecución después de redirigir
                } else {
                    $mensajes[] = "Contraseña incorrecta";
                }
            } else {
                $mensajes[] = "Usuario no encontrado";
            }
        }

        // Mostrar errores si existen
        if (!empty($mensajes)) {
            $mensaje .= '<div id="caja_mensaje" class="errors">';
            foreach ($mensajes as $error) {
                $mensaje .= $error . '<br/>';
            }
            $mensaje .= '</div>';
        }

        include 'Html/Login.php';
    }

    /*
    
    */
    function verificarDatos($username,$correo,$contra1,$contra2) {
        $mensajes = array();
        $mensaje = '';
     
    
        $username = isset($username) ? trim(htmlspecialchars($username)) : '';
        $correo = isset($correo) ? trim(htmlspecialchars($correo)) : '';
        $contra1 = isset($contra1) ? trim(htmlspecialchars($contra1)) : '';
        $contra2 = isset($contra2) ? trim(htmlspecialchars($contra2)) : '';

        if (empty($username)) {
            $mensajes[] = "El campo del Username no puede estar vacio";
        }

        if (empty($correo)) {
            $mensajes[] = "El campo del correo no puede estar vacio";
        }

        if(empty($contra1)) {
            $mensajes[] = "El campo de la contraseña no puede estar vacio";
        } elseif (empty($contra2)){
            $mensajes[] = "Por favor repita la contraseña.";
        }
    

    
        
        $result = usrExist($username,$correo);
        if ($result > 0) {
            echo "El nombre de usuario o el email ya están registrados.";
        } else {
            if ($contra1 == $contra2){
                // Encriptar la contraseña
            $hashed_password = password_hash($contra1, PASSWORD_DEFAULT);
            
            
            $stmt = insertarUsuario($username,$correo,$hashed_password);
            if ($stmt) {
                $mensajes[] = "Registro exitoso. Ahora puedes iniciar sesión.";
                header("Location: index.php?pagina=Login");
                exit();
            } else {
                $mensajes[] = "Error al registrar el usuario.";
            }
            } else {
                $mensajes[] = "Las contraseñas no coinciden.";
            }
        }

        if (!empty($mensajes)) {
            $mensaje .= '<div id="caja_mensaje" class="errors">';
            foreach ($mensajes as $mensaje) {
                $mensaje .= $mensaje . '<br/>';
            }
            $mensaje.= '</div>';
        }
    
    include 'Html/SignUp.php';
    }
?>