<?php
    require_once "database.php";
    require_once "utilidades.php";
    require_once "modelo.php";

    if($_POST){
        $id = intval($_POST["id"] ?? "0");
        switch($_POST["table"]){
            case "productos":

                $nombre = $_POST["nombre"];
                $descripcion = $_POST["descripcion"];
                $cantidad = intval($_POST["cantidad"]);
                $precio = floatval($_POST["precio"]);

                if($id){
                    productos::update($id, $nombre, $descripcion, $cantidad, $precio);
                }else{
                    productos::create($nombre, $descripcion, $cantidad, $precio);
                }
                break;
            case "usuarios":

                $usuario = $_POST["usuario"];
                $password = $_POST["password"];

                if($id){
                    usuarios::update($id, $usuario, $password);
                }else{
                    usuarios::create($usuario, $password);
                }
                break;
        }
        header("Location: ./");
    }
    
    $id = intval($_GET["id"] ?? "0");
    $name = $_GET["name"] ?? "";


    if($_GET["delete"] ?? null){
        $id = intval($_GET["id"] ?? "0");

        switch($_GET["name"] ?? ""){
            case "productos":
                productos::delete($id);
                break;
            case "usuarios":
                usuarios::delete($id);
                break;
        }
    
        header("Location: ./");
    }


    $editar = [];
    switch($name){
        case "productos":
            $editar = productos::read($id);
            break;
        case "usuarios":
            $editar = usuarios::read($id);
            break;
    }
    foreach ($editar as $key => $value) $$key = $value;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crudo</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            gap: .25rem;
            width: 15rem;
            padding: 1rem;
        }
    </style>
</head>
<body>
<?php
    echo "<h1>Tabla de productos</h1>";
    tabla(productos::readAll(),"productos");
?>
<form action="" method="post">
    <!-- Este input solo se usara para identificar el formulario -->
    <input hidden name="table" type="text" value="productos">
    <!-- Este input solo se usara al editar -->
    <input hidden name="id" type="number" value="<?= $id ?>">
    <input required name="nombre" placeholder="nombre" type="text" value="<?= $nombre ?? "" ?>">
    <input required name="descripcion" placeholder="descripcion" type="text" value="<?= $descripcion ?? "" ?>">
    <input required name="cantidad" placeholder="cantidad" type="number" value="<?= $cantidad ?? "" ?>">
    <input required name="precio" placeholder="precio" type="number" value="<?= $precio ?? "" ?>">
    <input type="submit">
</form>
<?php    
    echo "<h1>Tabla de usuarios</h1>";
    tabla(usuarios::readAll(),"usuarios");
?>
<form action="" method="post">
    <!-- Este input solo se usara para identificar el formulario -->
    <input hidden name="table" type="text" value="usuarios">
    <!-- Este input solo se usara al editar -->
    <input hidden name="id" type="number" value="<?= $id ?>">
    <input required name="usuario" placeholder="usuario" type="text" value="<?= $usuario ?? "" ?>">
    <input required name="password" placeholder="password" type="password" value="<?= $password ?? "" ?>">
    <input type="submit">
</form>
</body>
</html>