<?php
//echo "<script>alert("hi"); </script>";
/*$uploaddir = "/lecturenote/";

$uploadfile = $uploaddir .basename($_FILE['file_name']['name'];

$upload_result = "FAIL";

if(move_uploaded_file($_FILE['file_name']['tmp_name'], $uploadfile)){
    $upload_result = "SUCCESS";
}*/
    $target_dir = "../../lecturenote/";
    //$newfilename="aaa.";
    $temp= explode(".", $_FILES["file_name"]["name"]);
    //echo $temp[1];
    echo $_POST["lecturecourse"]."_".$_POST["lecturenumber"];
    $newfilename = $_POST["lecturecourse"]."_".$_POST["lecturenumber"].'.'.end($temp);//round(microtime(true)) . '.' . end($temp);//// //filename 
    $uploadOk = 1;
    $imageFileType = $temp[1];

    // Check if file already exists
    // Check file size
    if ($_FILES["file_name"]["size"] > 50000000000) {
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
        if (move_uploaded_file($_FILES["file_name"]["tmp_name"], $target_dir . $newfilename)){
            $upload_result = "SUCCESS";
            echo "The file ". basename( $_FILES["file_name"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    echo json_encode(
        array("result"=>$upload_result,"error"=>$_FILE['file_name']['error'])
        );

?>

