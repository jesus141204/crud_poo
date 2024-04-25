<?php
    require_once "database.php";
    class productos {
        static function create(string $nombre, string $descripcion, int $cantidad, float $precio) : bool {
            $sql = "INSERT INTO `productos` (`nombre`, `descripcion`, `cantidad`, `precio`) VALUES (?, ?, ?, ?)";
            return prepared_query($sql, $nombre, $descripcion, $cantidad, $precio);
        }
        static function read(int $id) : array {
            $sql = "SELECT * FROM `productos` WHERE `id` = ?";
            $response = prepared_query($sql, $id);
            return $response->fetch_assoc();
        }
        static function readAll() : array {
            $sql = "SELECT * FROM `productos`";
            $response = prepared_query($sql);
            return $response->fetch_all(MYSQLI_ASSOC);
        }
        static function update(int $id, string $nombre, string $descripcion, int $cantidad, float $precio) : bool {
            $sql = "UPDATE `productos` SET `nombre` = ?, `descripcion` = ?, `cantidad` = ?, `precio` = ? WHERE `id` = ?";
            return prepared_query($sql, $nombre, $descripcion, $cantidad, $precio, $id);
        }
        static function delete(int $id) : bool {
            $sql = "DELETE FROM `productos` WHERE `id` = ?";
            return prepared_query($sql, $id);
        }
    }
    class usuarios {
        static function create(string $usuario, string $password) : bool {
            $sql = "INSERT INTO `usuarios` (`usuario`, `password`) VALUES (?, ?)";
            return prepared_query($sql, $usuario, $password);
        }
        static function read(int $id) : array {
            $sql = "SELECT * FROM `usuarios` WHERE `id` = ?";
            $response = prepared_query($sql, $id);
            return $response->fetch_assoc();
        }
        static function readAll() : array {
            $sql = "SELECT * FROM `usuarios`";
            $response = prepared_query($sql);
            return $response->fetch_all(MYSQLI_ASSOC);
        }
        static function update(int $id, string $usuario, string $password) : bool {
            $sql = "UPDATE `productos` SET `usuario` = ?, `password` = ? WHERE `id` = ?";
            return prepared_query($sql, $usuario, $password, $id);
        }
        static function delete(int $id) : bool {
            $sql = "DELETE FROM `usuarios` WHERE `id` = ?";
            return prepared_query($id);
        }
    }
?>