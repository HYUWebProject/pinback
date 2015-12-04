<?php
$target_dir = "./test/";
//$newfilename="aaa.";
$temp= explode(".", $_FILES["fileToUpload"]["name"]);
$newfilename = round(microtime(true)) . '.' . end($temp); //filename 
$uploadOk = 1;
$imageFileType = $temp[1];

// Check if file already exists
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf") {
    echo "Sorry, only JPG, JPEG, PNG , GIF & PDF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $newfilename)){
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>