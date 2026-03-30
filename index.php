<?php
include 'connect.php';
$query = "SELECT * FROM `products`";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Display Products</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color: #121212; color: #fff; }
    .container-fluid { min-height: 100vh; padding: 20px 0; }
    .table-responsive { max-height: 500px; overflow-y: auto; }
    .btn-sm-custom { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
    .product-img { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; }
    .card { background-color: #1e1e1e; color: #fff; }
    .table-dark th, .table-dark td { color: #fff; border-color: #333; }
    .table-striped tbody tr:nth-of-type(odd) { background-color: #2c2c2c; }
    .table-striped tbody tr:nth-of-type(even) { background-color: #1e1e1e; }
    a.text-light { color: #fff !important; }
    .carousel-inner img { width: 60px; height: 60px; object-fit: cover; }
    .carousel-control-prev-icon, .carousel-control-next-icon { filter: invert(1); }
    .carousel { width: 70px; margin: auto; }
</style>
</head>
<body>
<div class="container-fluid bg-dark">
    <div class="container">
        <button class="btn btn-primary mt-5 mb-3">
            <a href="addproducts.php" class="text-light text-decoration-none">Add Product</a>
        </button>
        <button class="btn btn-secondary mt-5 mb-3">
            <a href="search.php" class="text-light text-decoration-none">Search Products</a>
        </button>
    </div>

    <div class="container mt-2 table-responsive">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-primary text-white text-center">
                <h3>ALL PRODUCTS</h3>
            </div>
            <div class="card-body p-4">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Stock</th>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Brand</th>
                            <th>Material</th>
                            <th>Image</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $images = !empty($row['image']) ? explode(',', $row['image']) : ['placeholder.png'];
                            echo '<tr>
                                <th scope="row">'.$row['id'].'</th>
                                <td>'.htmlspecialchars($row['name']).'</td>
                                <td>'.htmlspecialchars($row['description']).'</td>
                                <td>'.$row['stock'].'</td>
                                <td>'.htmlspecialchars($row['supplier']).'</td>
                                <td>'.htmlspecialchars($row['status']).'</td>
                                <td>'.htmlspecialchars($row['brand']).'</td>
                                <td>'.htmlspecialchars($row['material']).'</td>
                                <td>';
                            if(count($images) > 1){
                                $carouselId = 'carousel'.$row['id'];
                                echo '<div id="'.$carouselId.'" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">';
                                $active = 'active';
                                foreach($images as $img){
                                    $img = trim($img);
                                    if(!empty($img)){
                                        echo '<div class="carousel-item '.$active.'">
                                            <img src="'.$img.'" class="d-block w-100" alt="Product Image">
                                        </div>';
                                        $active = '';
                                    }
                                }
                                echo '</div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#'.$carouselId.'" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#'.$carouselId.'" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                                </div>';
                            } else {
                                echo '<img src="'.trim($images[0]).'" class="product-img" alt="Product Image">';
                            }
                            echo '</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="update.php?updateid='.$row['id'].'" class="btn btn-primary btn-sm-custom">Update</a>
                                        <a href="delete.php?deleteid='.$row['id'].'" class="btn btn-danger btn-sm-custom">Delete</a>
                                    </div>
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="10">No Products Found</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
