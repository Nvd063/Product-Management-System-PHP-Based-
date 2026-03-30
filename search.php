<?php
include 'connect.php';

// Initialize search term
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $searchTermEscaped = mysqli_real_escape_string($conn, $searchTerm);

    $query = "SELECT * FROM products 
              WHERE name LIKE '%$searchTermEscaped%' 
                 OR description LIKE '%$searchTermEscaped%'
                 OR brand LIKE '%$searchTermEscaped%'
                 OR material LIKE '%$searchTermEscaped%'";
} else {
    // Default: show all products if no search
    $query = "SELECT * FROM products";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-responsive { max-height: 500px; overflow-y: auto; }
        .product-img { width: 60px; height: 60px; object-fit: cover; }
        .btn-sm-custom { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
        body {
            background-color: #121212; /* Dark background */
            color: #ffffff;
        }

        .container {
            color: #ffffff;
        }

        .form-control {
            background-color: #2b2b2b; /* Dark input fields */
            color: #ffffff;
            border: 1px solid #444444;
        }

        .form-control::placeholder {
            color: #bbbbbb;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .table-responsive {
            max-height: 500px; 
            overflow-y: auto;
        }

        .table {
            background-color: #1e1e1e; /* Dark table background */
            color: #ffffff;
        }

        .table thead.table-dark {
            background-color: #343a40; /* Dark header */
            color: #ffffff;
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #2c2c2c; /* Dark striped rows */
        }

        .table-striped > tbody > tr:nth-of-type(even) {
            background-color: #1e1e1e;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }

        .btn-sm-custom {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .text-muted {
            color: #bbbbbb !important;
        }
    </style>
    </style>
</head>
<body>

<div class="container mt-5">

    <form class="d-flex mb-3" method="GET" action="">
        <input class="form-control me-2" type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>

    <div class="table-responsive">
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
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $imgPath = !empty($row['image']) ? $row['image'] : 'placeholder.png';
                    echo '<tr>
                        <th scope="row">' . $row['id'] . '</th>
                        <td>' . htmlspecialchars($row['name']) . '</td>
                        <td>' . htmlspecialchars($row['description']) . '</td>
                        <td>' . $row['stock'] . '</td>
                        <td>' . htmlspecialchars($row['supplier']) . '</td>
                        <td>' . htmlspecialchars($row['status']) . '</td>
                        <td>' . htmlspecialchars($row['brand']) . '</td>
                        <td>' . htmlspecialchars($row['material']) . '</td>
                        <td><img src="' . $imgPath . '" class="product-img" alt="Product Image"></td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="update.php?updateid=' . $row['id'] . '" class="btn btn-primary btn-sm-custom">Update</a>
                                <a href="delete.php?deleteid=' . $row['id'] . '" class="btn btn-danger btn-sm-custom">Delete</a>
                            </div>
                        </td>
                    </tr>';
                }
            } else {
                echo '<tr><td colspan="10">No products found</td></tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
