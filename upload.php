<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $targetDir = "uploads/";
  $targetFile = $targetDir . basename($_FILES["file"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  // Check if the file is an actual image or fake image
  if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }

  // Check if file already exists
  if (file_exists($targetFile)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size (limit it to 10MB)
  if ($_FILES["file"]["size"] > 10485760) {
    echo "Sorry, your file is too large. Please upload a file up to 10MB in size.";
    $uploadOk = 0;
  }

  // Allow only specific file formats (you can add more if needed)
  $allowedFormats = array("jpg", "jpeg", "png", "gif");
  if (!in_array($imageFileType, $allowedFormats)) {
    echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
    $uploadOk = 0;
  }

  // If all checks pass, move the file to the target directory
  if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
      echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
?>
