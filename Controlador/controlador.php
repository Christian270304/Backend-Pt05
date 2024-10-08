<?php
    // Christian Torres Barrantes

    require_once 'Model/Model.php';
    
    /* Funcion para mostrar los articulos, con tres posibilidades. 
        $click = Boolean dependiendo de si los articulos tienen que tener la opcion de ser clickable.
        $cat = String que define si es de la categoria Borrar o Modificar.
    */
    function mostrarArticulos($click = false, $cat, $page = 1, $articlesPerPage = 5) {
        $article_data = '<div class="articulo-container">'; // Contenedor para los artículos.
        $articles = select(); // Obtener los artículos de la base de datos
        
        // Verificar si hay artículos
        if (empty($articles)) {
            return '<h1>No hi han articles a la base de dades.</h1>';
        }
    
        // Calcular el número total de artículos
        $totalArticles = count($articles);
        $startIndex = ($page - 1) * $articlesPerPage;
        $endIndex = min($startIndex + $articlesPerPage, $totalArticles);
    
        // Mostrar artículos según la página
        for ($i = $startIndex; $i < $endIndex; $i++) {
            $article = $articles[$i];
            if (!$click && $cat == 'Mostrar') {
                $article_data .= '<div class="articulo" id="' . $article['id'] . '">';
                $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>';
                $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
                $article_data .= '</div>';
            } elseif ($cat == 'Borrar') {
                $article_data .= '<button onclick="redireccion(' . $article['id'] . ')" class="selectB" id="' . $article['id'] . '">';
                $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>';
                $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
                $article_data .= '</button>';
            } else { // Para la opción de Modificar
                $article_data .= '<button onclick="redireccion(' . $article['id'] . ')" class="selectM" id="' . $article['id'] . '">';
                $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>';
                $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
                $article_data .= '</button>';
            }
        }
    
        $article_data .= '</div>'; // Cerrar el contenedor de artículos
        $article_data .= generarPaginacion($page,$articlesPerPage,$cat);
        return $article_data;
    }

    /*
        Funcion para crear la paginacion en las paginas.
        $page El numero de pagina en la que esta el usuario.
        $articlesPerPage El numero de articulos por pagina
    */
    function generarPaginacion($pagina, $articlesPerPage,$cat) {
        $articles = select(); // Obtener todos los artículos
        $totalArticles = count($articles); // Calcular el número total de artículos
        $totalPagines = ceil($totalArticles / $articlesPerPage); // Número total de páginas
        
        // Generar la barra de paginación
        $pagination = '<div class="pagination">';
    
        // Flechas a las paginas anteriores
        if ($pagina > 1) {
            $pagination .= '<a href="?pagina=' . $cat . '&page=1&articulosPorPagina=' . $articlesPerPage . '" class="arrow first">« Primera</a>';
            $pagination .= '<a href="?pagina=' . $cat . '&page=' . ($pagina - 1) . '&articulosPorPagina=' . $articlesPerPage . '" class="arrow next">« Anterior</a>';

        }
    
        // Calcular el rango de páginas a mostrar
        $maxVisiblePages = 4;
        $startPage = max(1, $pagina - floor($maxVisiblePages / 2));
        $endPage = min($totalPagines, $startPage + $maxVisiblePages - 1);
    
        // Ajustar el rango si hay menos de 4 páginas
        if ($endPage - $startPage + 1 < $maxVisiblePages) {
            $startPage = max(1, $endPage - $maxVisiblePages + 1);
        }
    
        // Mostrar enlaces de paginación
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i == $pagina) {
                $pagination .= '<span class="current-page">' . $i . '</span>'; // Página actual
            } else {
                // Incluir artículos por página en el enlace de paginación
                $pagination .= '<a href="?pagina=' . $cat . '&page=' . $i . '&articulosPorPagina=' . $articlesPerPage . '">' . $i . '</a>'; // Enlace a la página
            }
        }
    
        // Flechas a la siguiente página
        if ($pagina < $totalPagines) {
            $pagination .= '<a href="?pagina=' . $cat . '&page=' . ($pagina + 1) . '&articulosPorPagina=' . $articlesPerPage . '" class="arrow next">Siguiente »</a>';
            $pagination .= '<a href="?pagina=' . $cat . '&page='. $totalPagines . '&articulosPorPagina=' . $articlesPerPage . '" class="arrow first">Última »</a>';
        }

    
        $pagination .= '</div>'; 
        return $pagination;
    }


    /*
        Funcion para validar los numeros de pagina y articulos por pagina de la url.
    */
    function validarEntero($parametro, $valorPorDefecto, $min = 1, $max = PHP_INT_MAX) {
        if (isset($_GET[$parametro]) && filter_var($_GET[$parametro], FILTER_VALIDATE_INT)) {
            $valor = (int)$_GET[$parametro];
            if ($valor >= $min && $valor <= $max) {
                return $valor;
            }
        }
        return $valorPorDefecto;
    }

    /*
        Funcion que retorna el total de articulos que hay en la base de datos.
    */
    function totArticles(){
        return countArticles();
    }

    /*
        Funcion para poder insertar los articulos a la base de datos.
        $titulo = El titulo del articulo 
        $cuerpo = El cuerpo de
    */
    function insertarDatos($titulo,$cuerpo){
        $mensajes= array();
        $mostrar = '';


        $titol = isset($titulo) ? trim(htmlspecialchars($titulo)) : '';
        $cos = isset($cuerpo) ? trim(htmlspecialchars($cuerpo)) : '';

        if (empty($titol)) {
            $mensajes[] = 'El campo del titulo no puede estar vacio';
        }
        if (empty($cos)) {
            $mensajes[] = 'El campo del cuerpo no puede estar vacio';
        }
         
        $id = selectId($titol,$cos);
        if ($id == null){
            $resultado = insertar($titol, $cos);
            $mostrar .= '<div id="caja_mensaje" class="enviar">' . $resultado . '</div>';
        } else {
            $mensajes[] = 'Este articulo ya existe';
        }
        
        // Generar mensajes de error
        if (!empty($mensajes)) {
            $mostrar .= '<div id="caja_mensaje" class="errors">';
            foreach ($mensajes as $mensaje) {
                $mostrar .= $mensaje . '<br/>';
            }
            $mostrar .= '</div>';
        }
        

        include 'Html/Insertar.php';
    }
    
    /*
        Funcion para mostrar el titulo y el cuerpo dentro de la pagina BorrarVerificar.
    */
    
    function verificarDelet($id)  {
        $ids = isset($id) ? trim(htmlspecialchars($id)) : '';
        $verificar = verificarId($ids);
        $mensaje = '';
        $titol = '';
        $cos = '';
        if ($verificar == false){
            include 'Html/404.php';
        } else {
            $articles = selectTitolCos($id);
            foreach ($articles as $article) {
                $titol = $article['titol'] ;
                $cos = $article['cos'];
                
            }   
            include 'Html/BorrarVerificar.php';
        }
        
        
    }

    /*
        Funcion para borrar el articulo que ha seleccionado el usuario.
    */
    function borrar($titulo,$cuerpo)  {
        $titol = isset($titulo) ? trim($titulo) : '';
        $cos = isset($cuerpo) ? trim($cuerpo) : '';
        $id = selectId($titol,$cos);
        if ($id != 1){
        $mensaje = borrarArticle($id);
        include 'Html/Borrar.php';
        } else{
            echo "Fallo";
        }
        
    }

     
     /*
        Funcion para mostrar los datos del articulo que ha seleccionado el usuario en la pagina de ModificarArticulo.
     */
    function modificarPagina($id)  {
        $ids = isset($id) ? trim(htmlspecialchars($id)) : '';
        $verificar = verificarId($ids);
        $mensaje = '';
        $titol = '';
        $cos = '';
        if ($verificar == false){
            include 'Html/404.php';
        } else {
            $articles = selectTitolCos($id);
            if (!empty($articles)) {
                foreach ($articles as $article) {
                    $titol = $article['titol'] ;
                    $cos = $article['cos'];
                    include 'Html/ModificarArticulo.php';
                }
            } else {
                $mensaje = "No s'ha trobat l'article.";
            }
            
        }
        
        
    }

    /*
        Funcion que modifica el articulo con el titulo o el campo modificado. Si no ha modificado nada en el formulario 
        no cambia nada y salta el error de que no se ha podido modificar el articulo.
    */
    function modificar($id,$titulo,$cuerpo)  {
       $titol = isset($titulo) ? trim($titulo) : '';
       $cos = isset($cuerpo) ? trim($cuerpo) : '';
       $verid = verificarId($id);
       if ($verid == true){
            $mensaje = update($id,$titol,$cos);
            include 'Html/ModificarArticulo.php';
       } else{
           include 'Html/404.php';
       }
       
    }
    /*
        Funcion para verificar si el id pasado por parametro exite dentro de la base de datos.
        Devuelve true si el artículo existe, false si no.
    */
    function verificarId($id) {
        $verificar = selectOne($id);
        return $verificar ? true : false;
    }

    /*
    
    */
    function verificarDatos($username,$correo,$contra1,$contra2) {
        $mensajes = array();
        $mostrar = '';
     
    
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
                header("index.php?pagina=Login");
                exit();
            } else {
                $mensajes[] = "Error al registrar el usuario.";
            }
            } else {
                $mensajes[] = "Las contraseñas no coinciden.";
            }
        }
    
    include 'Html/SignUp.php';
    }

?>
