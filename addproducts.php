<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Form</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      /* Dark background */
      color: #ffffff;
      /* White text */
    }

    .card {
      background-color: #1e1e1e;
      /* Dark card */
      color: #ffffff;
    }

    .form-control {
      background-color: #2b2b2b;
      /* Dark input fields */
      color: #ffffff;
      border: 1px solid #444444;
    }

    .form-control::placeholder {
      color: #bbbbbb;
    }

    .form-label {
      color: #ffffff;
    }

    .btn-success {
      background-color: #28a745;
      border-color: #28a745;
    }

    .btn-success:hover {
      background-color: #218838;
      border-color: #1e7e34;
    }

    .text-muted {
      color: #bbbbbb !important;
    }

    input[type="radio"] {
      accent-color: #0d6efd;
      /* Blue color for radio buttons */
    }
  </style>
</head>

<body class="bg-dark">

  <div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
      <div class="card-header bg-primary text-white text-center">
        <h3>Add Product</h3>
      </div>
      <div class="card-body p-4">
        <form id="productForm" method="POST" enctype="multipart/form-data">

          <!-- Product Name -->
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
          </div>

          <!-- Price -->
          <div class="mb-3">
            <label class="form-label">Price (PKR)</label>
            <input type="number" step="0.01" name="price" class="form-control" placeholder="Enter product price"
              required>
          </div>

          <!-- Description -->
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Enter short description"></textarea>
          </div>

          <!-- Stock -->
          <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" placeholder="Enter available quantity" required>
          </div>

          <!-- Image -->
          <input type="file" name="txtimage[]" class="form-control" multiple accept="image/*">
          <p class="text-muted">You can upload up to 5 images.</p>


          <!-- Supplier -->
          <div class="mb-3">
            <label class="form-label">Supplier</label>
            <input type="text" name="supplier" class="form-control" placeholder="Enter supplier name">
          </div>

          <!-- Status -->
          <div class="mb-3">
            <label class="form-label">Status</label>
            <div>
              <input type="radio" id="available" name="status" value="Available" required>
              <label for="available">Available</label>

              <input type="radio" id="out-of-stock" name="status" value="Out of Stock" required>
              <label for="out-of-stock">Out of Stock</label>
            </div>
          </div>


          <!-- Brand -->
          <!-- <div class="mb-3">
            <label class="form-label">Brand</label>
            <input type="text" name="brand" class="form-control" placeholder="Enter brand name">
          </div> -->

          <!-- Material -->
          <!-- <div class="mb-3">
            <label class="form-label">Material</label>
            <input type="text" name="material" class="form-control" placeholder="Enter Type">
            <p class="text-muted">"Electronics, Fashion & Clothing, Home & Living, Beauty & Personal Care,Food &
              Beverages, Kids"</p>
          </div> -->
          <!-- Brand -->
          <div class="mb-3">
            <label class="form-label">Brand</label>
            <select name="brand" id="brand" class="form-control" required>
              <option value="">Select Brand</option>
              <option value="Samsung">Samsung</option>
              <option value="Apple">Apple</option>
              <option value="Huawei">Huawei</option>
              <option value="Dell">Dell</option>
              <option value="Nike">Nike</option>
              <option value="Adidas">Adidas</option>
              <option value="Others">Others</option>
            </select>

            <!-- Brand Other Input -->
            <input type="text" id="brand_other_input" name="brand_other" class="form-control mt-2"
              placeholder="Enter brand name" style="display:none;">
          </div>


          <!-- Material (Always visible but disabled initially) -->
          <div class="mb-3" id="material_box">
            <label class="form-label">Material</label>

            <select name="material" id="material" class="form-control" disabled>
              <option value="">Select Material</option>
              <option value="Electronics">Electronics</option>
              <option value="Fashion & Clothing">Fashion & Clothing</option>
              <option value="Home & Living">Home & Living</option>
              <option value="Beauty & Personal Care">Beauty & Personal Care</option>
              <option value="Food & Beverages">Food & Beverages</option>
              <option value="Kids">Kids</option>
              <option value="Others">Others</option>
            </select>

            <!-- Material Other Input -->
            <input type="text" id="material_other_input" name="material_other" class="form-control mt-2"
              placeholder="Enter material type" style="display:none;">

            <p class="text-muted">
              "Electronics, Fashion & Clothing, Home & Living, Beauty & Personal Care, Food & Beverages, Kids"
            </p>
          </div>



          <!-- Submit -->
          <div class="text-center">
            <button type="submit" name="submit" class="btn btn-success w-50">Save Product</button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <scrip src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <script>
      // BRAND DROPDOWN
      document.getElementById("brand").addEventListener("change", function () {
        let brand = this.value;
        let brandOtherInput = document.getElementById("brand_other_input");
        let material = document.getElementById("material");

        if (brand === "Others") {
          brandOtherInput.style.display = "block";
        } else {
          brandOtherInput.style.display = "none";
        }

        // Enable material only when brand is selected
        if (brand !== "") {
          material.disabled = false;
        } else {
          material.disabled = true;
        }
      });


      // MATERIAL DROPDOWN
      document.getElementById("material").addEventListener("change", function () {
        let material = this.value;
        let materialOtherInput = document.getElementById("material_other_input");

        if (material === "Others") {
          materialOtherInput.style.display = "block";
        } else {
          materialOtherInput.style.display = "none";
        }
      });
    </script>


</body>

</html>

<?php
include "connect.php"; // DB connection file

if (isset($_POST['submit'])) {

  $name = $_POST['name'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $stock = $_POST['stock'];
  $supplier = $_POST['supplier'];
  $status = $_POST['status'];
  $brand = $_POST['brand'];
  $material = $_POST['material'];

  // 🧱 Create main "image" folder if not exists
  $main_folder = "image";
  if (!is_dir($main_folder))
    mkdir($main_folder, 0777, true);

  // 🧩 Create subfolder with product name
  $product_folder_name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $name);
  $product_folder = $main_folder . "/" . $product_folder_name;
  if (!is_dir($product_folder))
    mkdir($product_folder, 0777, true);

  $uploaded_images = []; // array to store uploaded image paths

  if (isset($_FILES['txtimage'])) {
    $total_files = count($_FILES['txtimage']['name']);
    if ($total_files > 5)
      $total_files = 5; // limit to 5 images

    for ($i = 0; $i < $total_files; $i++) {
      if ($_FILES['txtimage']['error'][$i] === UPLOAD_ERR_OK) {
        $image_name = rand(0, 9999) . '_' . basename($_FILES['txtimage']['name'][$i]);
        $temp_path = $_FILES['txtimage']['tmp_name'][$i];
        $upload_path = $product_folder . "/" . $image_name;

        if (move_uploaded_file($temp_path, $upload_path)) {
          $uploaded_images[] = $upload_path; // add successful upload
        }
      }
    }
  }

  if (count($uploaded_images) > 0) {
    $images_for_db = implode(',', $uploaded_images); // store as comma-separated string

    $query = "INSERT INTO products (name, price, description, stock, image, supplier, status, brand, material)
              VALUES ('$name', '$price', '$description', '$stock', '$images_for_db', '$supplier', '$status', '$brand', '$material')";

    $result = mysqli_query($conn, $query);

    if ($result) {
      // Redirect to index.php immediately after successful insert
      header("Location: index.php");
      exit; // important to stop script
    } else {
      echo "<div style='color:red; text-align:center;'>❌ Database Error: " . mysqli_error($conn) . "</div>";
    }

  } else {
    echo "<div style='color:red; text-align:center;'>❌ No images uploaded or upload failed.</div>";
  }

}
?>