<?php
    require "api.imgbb.php";

    $imgBB = new ApiImgBB;

    if($imgBB->isImg($_FILES['image'])){
        $imgBB->upload();
        echo $imgBB->getUrl();
        $urlnuevaimagen = $imgBB->getUrl();
            $apikey = '4vyPKa81piMdMQTruEpk0BQqih1Hy3GGgv9mVMCxv_uJ';
            $urlservicio = "https://gateway.watsonplatform.net/visual-recognition/api/v3/classify?&version=2021-04-01";
            $urlfinal = '&url='.$urlnuevaimagen;
            $classifier = '&classifier_ids=default';
            $threshold = '&threshold=0';
            $version = '&version=2021-04-01';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $urlservicio);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $urlfinal . $classifier . $threshold );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            curl_setopt($curl, CURLOPT_USERPWD, 'apikey:' . $apikey);
            $result = curl_exec($curl);
            print_r($result);
            curl_close($curl);
    }else{
        echo "No es una imagen";
    }

?>