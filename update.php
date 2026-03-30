<?php
include 'connect.php';

$id = intval($_GET['updateid']);
$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$old_name = $row['name'];
$name = $row['name'];
$price = $row['price'];
$description = $row['description'];
$stock = $row['stock'];
$supplier = $row['supplier'];
$status = $row['status'];
$brand = $row['brand'];
$material = $row['material'];
$existing_images = !empty($row['image']) ? explode(',', $row['image']) : [];

$main_folder = "image";
$folder_name = $main_folder . "/" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $name);

if (!is_dir($folder_name)) mkdir($folder_name, 0777, true);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $supplier = $_POST['supplier'];
    $status = $_POST['status'];
    $brand = $_POST['brand'];
    $material = $_POST['material'];

    // handle folder rename if product name changed
    $new_folder = $main_folder . "/" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $name);
    if ($old_name !== $name && is_dir($folder_name)) {
        rename($folder_name, $new_folder);
        // update paths in existing images
        foreach ($existing_images as &$img_path) {
            $img_path = str_replace($folder_name, $new_folder, $img_path);
        }
        $folder_name = $new_folder;
    }

    // Upload new images
    if (isset($_FILES['txtimage']) && !empty($_FILES['txtimage']['name'][0])) {
        $total_files = count($_FILES['txtimage']['name']);
        for ($i = 0; $i < $total_files; $i++) {
            if ($_FILES['txtimage']['error'][$i] === UPLOAD_ERR_OK) {
                $image_name = rand(0,9999).'_'.basename($_FILES['txtimage']['name'][$i]);
                $temp_path = $_FILES['txtimage']['tmp_name'][$i];
                $upload_path = $folder_name . "/" . $image_name;
                if (move_uploaded_file($temp_path, $upload_path)) {
                    $existing_images[] = $upload_path;
                }
            }
        }
    }

    $existing_images = array_filter(array_unique($existing_images));
    $images_for_db = implode(',', $existing_images);

    $update_query = "UPDATE products SET
                        name='$name',
                        price='$price',
                        description='$description',
                        stock='$stock',
                        supplier='$supplier',
                        status='$status',
                        brand='$brand',
                        material='$material',
                        image='$images_for_db'
                     WHERE id=$id";
    mysqli_query($conn, $update_query);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.product-img { width:100px; height:100px; object-fit:cover; margin-bottom:5px; border-radius:5px; }
.img-container { display:inline-block; margin:10px; position:relative; }
.delete-btn { position:absolute; top:0; right:0; background:red; color:#fff; border:none; padding:2px 5px; cursor:pointer; }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center"><h3>Update Product</h3></div>
        <div class="card-body p-4">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3"><label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($name); ?>"></div>
                <div class="mb-3"><label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" required value="<?php echo htmlspecialchars($price); ?>"></div>
                <div class="mb-3"><label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($description); ?></textarea></div>
                <div class="mb-3"><label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" required value="<?php echo htmlspecialchars($stock); ?>"></div>

                <!-- Existing Images -->
                <div class="mb-3"><label class="form-label">Existing Images</label><br>
                    <?php foreach($existing_images as $img): ?>
                    <div class="img-container">
                        <img src="<?php echo $img; ?>" class="product-img">
                        <button type="button" class="delete-btn" data-img="<?php echo $img; ?>">X</button>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Upload new images -->
                <div class="mb-3">
                    <label class="form-label">Add Images</label>
                    <input type="file" name="txtimage[]" class="form-control" multiple>
                    <p class="text-muted">Upload new images (existing images will remain)</p>
                </div>

                <div class="mb-3"><label class="form-label">Supplier</label>
                    <input type="text" name="supplier" class="form-control" value="<?php echo htmlspecialchars($supplier); ?>"></div>
                <div class="mb-3"><label class="form-label">Status</label><br>
                    <input type="radio" name="status" value="Available" <?php if($status=="Available") echo "checked"; ?>> Available
                    <input type="radio" name="status" value="Out of Stock" <?php if($status=="Out of Stock") echo "checked"; ?>> Out of Stock
                </div>
                <div class="mb-3"><label class="form-label">Brand</label>
                    <input type="text" name="brand" class="form-control" value="<?php echo htmlspecialchars($brand); ?>"></div>
                <div class="mb-3"><label class="form-label">Material</label>
                    <input type="text" name="material" class="form-control" value="<?php echo htmlspecialchars($material); ?>"></div>

                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-success w-50">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('.delete-btn').click(function(){
        var imgPath = $(this).data('img');
        var btn = $(this);
        if(confirm('Are you sure to delete this image?')){
            $.post('delete_image.php', { img: imgPath, product_id: <?php echo $id; ?> }, function(data){
                if(data=='success'){
                    btn.parent().remove();
                } else {
                    alert('Failed to delete image');
                }
            });
        }
    });
});
</script>
</body>
</html>
