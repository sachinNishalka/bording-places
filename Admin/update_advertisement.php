<?php
include '../ConnectionDB/DbConnection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle image upload
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile; // Use this path to store in the database
        } else {
            echo "Error moving uploaded file.";
        }
    }

    var_dump($imagePath);

    // Prepare an SQL statement
    $sql = "UPDATE advertisements SET title = ?, description = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $description, $imagePath, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Advertisement updated successfully.";
    } else {
        echo "Error updating advertisement.";
    }
}
?>
