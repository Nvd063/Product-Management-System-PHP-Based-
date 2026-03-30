<?php
include 'connect.php';

if(isset($_POST['img']) && isset($_POST['product_id'])){
    $img = $_POST['img'];
    $id = intval($_POST['product_id']);

    // delete image from folder
    if(file_exists($img)) unlink($img);

    // remove image from DB
    $query = "SELECT image FROM products WHERE id=$id";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $images = explode(',', $row['image']);
    $images = array_filter($images, function($i) use ($img){ return $i != $img; });
    $images_for_db = implode(',', $images);

    mysqli_query($conn, "UPDATE products SET image='$images_for_db' WHERE id=$id");
    echo 'success';
} else {
    echo 'error';
}
?>
