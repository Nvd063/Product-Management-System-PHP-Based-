<?php
include 'connect.php';

if (isset($_GET['deleteid'])) {
    $id = intval($_GET['deleteid']); // sanitize ID

    // Step 1: Fetch image paths before deleting the record
    $query = "SELECT image FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $images = $row['image'];

        // Handle multiple images (comma-separated)
        $imageArray = explode(',', $images);

        foreach ($imageArray as $imgPath) {
            $imgPath = trim($imgPath);
            if (!empty($imgPath) && file_exists($imgPath)) {
                unlink($imgPath); // delete image file
            }
        }
    }

    // Step 2: Delete record from the database
    $deleteQuery = "DELETE FROM products WHERE id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, "i", $id);
    mysqli_stmt_execute($deleteStmt);
}

// Step 3: Redirect back to main page
header("Location: index.php");  
exit();
?>
