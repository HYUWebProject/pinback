<?php

print("hello");

header('Content-Type: image/jpeg');

$img = "../../lecturenote/".$_POST["lecturecourse"]."_".$_POST["lecturenumber"]."_".$_POST["input_page"]."jpg";
print($img);
# 이미지 실제경로 그리고 이미지 이름 
//$url = "img/new/" . $_GET[img_name] .".jpg"; 

$fp = fopen($img,"r"); 
$img_data = fread($fp,filesize($url)); 
fclose($fp); 

echo $img_data; 
?>