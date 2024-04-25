<?php
    function tabla(array $datos, string $name, array $columnas = []) : void {
        echo "<table border=\"1\">";
        if(!$columnas and $datos) $columnas = array_keys($datos[0]);

        echo "<thead><tr>";
            foreach ($columnas as $value) {
                echo "<th>$value</th>";
            }
        echo "</tr></thead>";

        foreach ($datos as  $fila) {
            echo "<tr>";
            if(is_array($fila)){
                foreach ($fila as $value) {
                    echo "<th>$value</th>";
                }
                if($id = $fila["id"] ?? 0){
                    echo "<th><a href='./?id=$id&name=$name'>Editar</a></th>";
                    echo "<th><a href='./?delete=1&id=$id&name=$name'>Eliminar</a></th>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }
?>