<?php
    require "api.imgbb.php";

    $imgBB = new ApiImgBB;

    if($imgBB->isImg($_FILES['image'])){
        $imgBB->upload();
        echo $imgBB->getUrl();
    }else{
        echo "No es una imagen";
    }

?>