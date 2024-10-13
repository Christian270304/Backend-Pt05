<?php 
    // Christian Torres Barrantes

    // Requerir la conexion para poder hacer gestiones en la base de datos
    require_once 'conexion.php';
    /*
        Funcion para agarrar todos los campos de articles en la base de datos.
    */
    function select(){
        global $conn;
        $query = "SELECT * FROM articles";
        $statement = $conn->prepare($query);
        $statement->execute();
        $resultado = $statement->fetchAll();
        $articles = [];
        foreach ($resultado as $row) {
            $articles[] = [
                'id' => $row['id'],
                'titol' => $row['titol'],
                'cos' => $row['cos']
            ];
        }
        return $articles;
    }

    function selectUsuario($user_id){
        global $conn;
        $query = "SELECT * FROM articles WHERE user_id = :user_id";
        $statement = $conn->prepare($query);
        $statement->execute([':user_id' => $user_id]);
        $resultado = $statement->fetchAll();
        $articles = [];
        foreach ($resultado as $row) {
            $articles[] = [
                'id' => $row['id'],
                'titol' => $row['titol'],
                'cos' => $row['cos']
            ];
        }
        return $articles;
    }

    /*
        Funcion para insertar el nuevo articulo del usuario a la base de datos.
    */
    function insertar($titulo, $cuerpo,$user_id){
        global $conn;
        $query = "INSERT INTO articles (titol,cos,user_id) VALUES (:titol,:cos,:user_id)";
        $statement = $conn->prepare($query);
        $statement->execute( 
            array(
            ':titol' => $titulo, 
            ':cos' => $cuerpo,
            ':user_id' => $user_id)
        );
        
        if ($statement->rowCount() > 0) {
            $mensaje = "Se ha insertado correctamente";
        } else {
            $mensaje = "No se ha subido correctamente";
        }

        return $mensaje;
    }

    /*
        Funcion para borrar el articulo que ha seleccionado el usuario mediante el id.
    */
    function borrarArticle($id){
        global $conn;
        if (!$conn) {
            die("Error de conexión: ");
        }
        $sql = "DELETE FROM articles WHERE id = :id"; // Sentencia sql.
        $stmt = $conn->prepare($sql); // Preparar la sentencia.
        $stmt->execute([':id' => $id]); // Ejecutar la consulta.
        if ($stmt->rowCount() > 0) {
            return "Se ha Borrado Correctamente";
        } else {
            return "Error al borrar el artículo";
        }
    }

    /*
        Funcion para seleccionar un articulo mediante el id.
    */
    function selectOne($id){
        global $conn;
        $sql = "SELECT * FROM articles WHERE id = :id"; // Sentencia sql.
        $statement = $conn->prepare($sql); // Preparar la sentencia.
        $statement->execute([':id' => $id]); // Ejecutar la consulta.
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : null; // Retornar el resultado o null si no se encuentra
    }

    /*
        Funcion para agarrar el titulo y el cuerpo de un articulo mediante su id.
    */
    function selectTitolCos($id){
        global $conn;
        $query = "SELECT titol,cos FROM articles WHERE id = :id"; // Sentencia sql.
        $statement = $conn->prepare($query); // Preparar la sentencia.
        $statement->execute([':id' => $id]); // Ejecutar la consulta.
        $resultado = $statement->fetchAll();
        $articles = [];
        foreach ($resultado as $row) {
            $articles[] = [
                'titol' => $row['titol'],
                'cos' => $row['cos']
            ];
        }
        return $articles;
    }

    /*
        Funcion para seleccionar el id de un articulo mediante el titulo y el cuerpo.
    */
    function selectId($titol,$cos){
        global $conn;
        $sql = "SELECT id FROM articles WHERE titol = :titol AND cos = :cos"; // Sentencia sql.
        $statement = $conn->prepare($sql); // Preparar la sentencia.
        $statement->execute([':titol' => $titol,':cos' => $cos]); // Ejecutar la consulta.  
        $result = $statement->fetch(PDO::FETCH_ASSOC); // Obtener el resultado como un array asociativo.
        return $result ? $result['id'] : null; // Verificar si hay resultados y devolver el ID, o null si no se encuentra.
    }

    /*
        Funcion para updatear el articulo que el usuario ha modificado.
    */
    function update($id,$titulo, $cuerpo){
        global $conn;
        $query = "UPDATE articles SET titol = :titol , cos = :cos WHERE id = :id"; // Sentencia sql.
        $statement = $conn->prepare($query); // Preparar la sentencia.
        $statement->execute([':titol' => $titulo, ':cos' => $cuerpo,':id' => $id]); // Ejecutar la consulta.
        if ($statement->rowCount() > 0) {
            return "El artículo ha sido actualizado correctamente.";
        } else {
            return "No se pudo actualizar el artículo.";
        }
    }

    /*
        Funcion para contar cuantos articulos hay dentro de la base de datos.
    */
    function countArticles() {
        global $conn; // Asegúrate de que $db esté disponible
        $query = "SELECT COUNT(*) FROM articles"; // Reemplaza con tu consulta real
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchColumn(); // Devuelve el número total de artículos
    }

    /*

    */
    function usrExist($username, $correo){
        global $conn;
        $query = "SELECT * FROM users WHERE username = :username OR email = :correo";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username, ':correo' => $correo]);
        $stmt->fetchAll();
        return $stmt;
    }

    /*

    */
    function insertarUsuario($username, $corre, $contra){
        global $conn;
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :correo , :contra)";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username, ':correo' => $corre, ':contra' => $contra]);
        return $stmt;
    }

    

    function idUsuario($username) {
        global $conn;
        $query = "SELECT id FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetchColumn(); // Esto devuelve solo el valor de la columna 'id'
    }
?>