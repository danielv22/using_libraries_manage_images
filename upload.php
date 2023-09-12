<?php
include_once "vendor/autoload.php";

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

$allowed_images = ['jpg', 'jpeg', 'png'];

if (isset($_POST['upload'])) {
    //var_dump($_FILES['file']);
    $fileName = $_FILES['file']['name'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    if  (in_array($fileActualExt, $allowed_images)) {
        if ($_FILES['file']['error'] === 0) {
            $newFileName = Str::random(5) . "-$fileName." . $fileActualExt;
            $path = "C:\\xampp\htdocs\\tarea-2-librerias\uploads\\$newFileName";

            Image::make($_FILES['file']['tmp_name'])
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($path);
            header("Location: index.php?uploadsuccess");
        } else {
            echo "Hubo un error al subir la imagen.";
        }
    } else {
        echo "No puedes subir otros tipos de archivo.";
    }
}