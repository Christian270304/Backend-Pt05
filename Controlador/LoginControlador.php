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
?>