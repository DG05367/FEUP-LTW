<?php
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and handle the uploaded file
    if (isset($_FILES['profilePicture']) ) {
        $file = $_FILES['profilePicture'];

        // Validate file type
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions) ) {
            // File type not allowed
            // Handle the error
            echo 'error in type';
            var_dump( in_array($fileExtension, $allowedExtensions));
        }

        // Validate file size
        $maxFileSize = 5 * 1024 * 1024; // 5 MB
        $fileSize = $_FILES['profilePicture']['size'];

        if ($fileSize > $maxFileSize) {
            // File size exceeds the limit
            // Handle the error
            echo 'error in size';
        }

        // Move the uploaded file to a specific directory
        $destination = '../images/';
        // give the filename the username, cause its unique so its easier to search
        $newFilename = $session->getUsername();
        $path = $destination . $newFilename;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            echo 'Image uploaded successfully!';
            var_dump($file['tmp_name']);
          } else {
            echo 'Failed to move uploaded image.';
            var_dump($file['tmp_name']);
          }

        // Get the client ID from session
        $clientId = $session->getId();

        // Update the profile_picture column in the clients table
        $stmt = $db->prepare("UPDATE clients SET profile_picture = ? WHERE client_id = ?");
        $stmt->execute([$path, $clientId]);

        // Send a response back to the client
        header("location: ../pages/profile.php");
        exit;
    } else {
        // Handle file upload error
        // ...
        echo 'error in something';
        var_dump($_SERVER['REQUEST_METHOD']);
        //var_dump($_FILES['profilePicture']);
    }
}
