<?php
    /* 
        ------------------------------------------------------------------------------------
        -------                                                                      -------
        -------                             By DickyM                                -------
        -------                                                                      -------
        ------------------------------------------------------------------------------------

        No tienes que integrar un parametro en la funcion de Cargar Imagen ya que se guarda en una variable al 
        verificar la imagen.

        Para obtener la url de la imagen debes usar la siguiente funcion que te devolverá una variable
        de tipo texto en la que se encuentra la url:

        $datoObtenido = $apiImgBB->getUrl(); //Devuelve la url

        Ahora usa la url en la variable que creaste de $datoObtenido
    */

    class ApiImgBB{
        private $json;

        private $archivo;
        private $nombre;

        public function __construct(){
            $this->nombre = null;
        }

        public function isImg($archivo){
            if(isset($archivo) and (strpos($archivo['type'], "png") or strpos($archivo['type'], "jpg") or strpos($archivo['type'], "jpeg"))){
                $this->archivo = $archivo;
                return true;
            }else{
                return false;
            }
        }

        public function upload(){
            if(isset($this->archivo)){
                $Host = "Apis";
                $llave = "2aa683edf1a002a365115abd3ab32459";

                if($this->nombre == null){
                    $arrayName = explode(".", $this->archivo['name']);
                    $nombre = $arrayName[0];
                }else{
                    $nombre = $this->nombre;
                }

                $bin = file_get_contents($this->archivo["tmp_name"]);
                $base64 = base64_encode($bin);

                $post = "key=".$llave."&name=".$nombre."&image=".urlencode($base64);

                $ch =   curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://api.imgbb.com/1/upload");
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $resultado = curl_exec($ch);
                $this->json = json_decode($resultado, true);
            }
        }

        public function setName($nombre){
            $this->nombre = $nombre;
        }

        public function getJson(){
            return $this->json;
        }

        public function getUrl(){
            return $this->json['data']['url'];
        }
    }