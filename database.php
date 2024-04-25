<?php
    $conn = new mysqli("localhost", "root", "", "crudo");
    $conn->set_charset("utf8");


    //esta funcion tiene como objetivo ejecutar consultas sql con prepared statements y bind_param,
    //para evitar inyecciones sql sin complicar el codigo basicamente, todo encapsulado en una funcion "simple"
    /*
    ejemplos de uso serian:

    variable que contiene el objeto de la conexion
    la consulta sql, con espacio para argumentos "?" (opcional)
    y los argumentos separados por comas.

    $result = prepared_query($con, "SELECT * FROM usuarios");
    $result = prepared_query($con, "SELECT * FROM usuarios WHERE id = ?", 1);
    $result = prepared_query($con, "SELECT * FROM usuarios WHERE id = ? AND nombre = ?", 1, "jose");

        he añadido soporte para parametros en lista, pero funciona de cualquier forma.
    $result = prepared_query($con, "SELECT * FROM usuarios WHERE id = ? AND nombre = ?", [1, "jose"]);
    */
    function prepared_query(string $sql = "", bool|int|string|float|array ...$argumentos) : mysqli_result | bool {
        global $conn;
        //si no existe sql, esta vacio, o no se encuentra el objeto de conexion termina la funcion retornando false.
        if(!($sql and $conn instanceof mysqli)) return false;
        //si la lista de argumentos esta vacia ejecuta la consulta de la manera normal con un query y retorna la respuesta. 
        if(empty($argumentos)) return $conn->query($sql);
        //si el primer argumento es una lista, hace que esa lista sean los argumentos e ignora el resto.
        if(is_array($argumentos[0])) $argumentos = $argumentos[0];
        //se inicia la construccion del string que indicara los tipos en el bind_param.
        $tipos = "";
        foreach ($argumentos as $argumento) {
            //itera sobre cada uno de los argumentos y añadiendo la letra del tipo correspondiente al string.
            if(is_bool($argumento)){
                //si es un tipo booleano (true, false) se convierte a int (1, 0) porque en mysql/mariadb los booleanos no existen.
                $argumento = intval($argumento);
            }
            if(is_int($argumento)){
                $tipos .= "i";
            }else if(is_string($argumento)){
                $tipos .= "s";
            }else if(is_float($argumento)){
                $tipos .= "d";
            }
        }
        //se prepara la consulta
        $stmt = $conn->prepare($sql);
        //se prepara un array de referencias para la funcion call_user_func_array, que lo requiere asi.
        $referencias = [];
        //itera el numero de los argumentos + 1, usando el <= en lugar de <
        //para ademas de todos los argumentos añadir el string de tipos como primer argumento
        //ejemplo [&$tipos, &$argumento 1, &$argumento 2, ...]
        for($i = 0; $i <= sizeof($argumentos); $i++){
            if($i === 0){
                $referencias[$i] = &$tipos;
            }else{
                //por eso al $i (iterador) se le resta 1 aca.
                $referencias[$i] = &$argumentos[$i - 1];
            }
        }
        //se hace la llamada al metodo bind_param de $stmt con las referencias
        //ejemplo equivalente: $stmt->bind_param($tipos, $argumento1, $argumento2, ...);
        call_user_func_array([$stmt,"bind_param"],$referencias);
        //se ejecuta la consulta (porfin)
        $stmt->execute();
        //si las filas afectadas son mayor a 0 significa que salio bien.
        $success = $stmt->affected_rows > 0;
        //y se retorna el o los resultados en un objeto de mysqli_result.
        $result = $stmt->get_result();
        //simulando el comportamiento de $con->query(); si salio bien retorna true.
        $result = $success ? true : $result;
        //se cierra el stmt.
        $stmt->close();
        return $result;
    }
?>