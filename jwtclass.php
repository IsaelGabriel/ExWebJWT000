<?php
    class myJWT
    {
        private $password = "passwordSecreta";
        public function generate_token($payload)
        {
            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];
            
            $header = json_encode($header);
            $header = base64_encode($header);
            
            $payload = json_encode($payload);
            $payload = base64_encode($payload);
        
            $signature = hash_hmac('sha256',"$header.$payload",$this->password,true);
            $signature = base64_encode($signature);
        
            return "$header.$payload.$signature";
        }

        public function validate_token($jwt)
        {
            $part = explode(".",$jwt);
            $header = $part[0];
            $payload = $part[1];
            $signature = $part[2];
        
            $signatureCheck = hash_hmac('sha256',"$header.$payload",$this->password,true);
            $signatureCheck = base64_encode($signatureCheck);
            if ($signature == $signatureCheck){
            $result = true;
            }else {
            $result = false;
            }
        
            return $result;
        }
    }
?>