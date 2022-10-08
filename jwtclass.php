<?php
    class myJWT
    {
        private $password = "senhaSecreta";

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
            if ($signature == $signatureCheck)
            {
                $result = true;
            }
            else
            {
                $result = false;
            }
        
            return $result;
        }

        public function get_payload($token)
        {
            $part = explode(".",$token);
            $header = $part[0];
            $payload = $part[1];
            $signature = $part[2];

            $decoded_payload = base64_decode($payload);
            return $decoded_payload;
        }
    }

    class myRefreshToken
    {
        private $password = "senhaSecreta";

        public function generate_refresh_token($user)
        {
            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];
            
            $header = json_encode($header);
            $header = base64_encode($header);
            
            $payload = [
                'issued_at' => time(),
                'user' => $user
            ];

            $payload = json_encode($payload);
            $payload = base64_encode($payload);
        
            $signature = hash_hmac('sha256',"$header.$payload",$this->password,true);
            $signature = base64_encode($signature);
        
            return "$header.$payload.$signature";
        }

        public function set_jwt($jwt,$rt)
        {
            $part = explode(".",$jwt);
            $header = $part[0];
            $payload = $part[1];
            $signature = $part[2];

            $decoded_payload = (array)base64_decode($payload);

            if($decoded_payload['exp'] <= time() && $decoded_payload['rt'] == $rt)
            {
                $decoded_payload['exp'] = time() + 120;
                $payload = $decoded_payload;
                $payload = json_encode($payload);
                $payload = base64_encode($payload);
                return $header.$payload.$signature;
            }

            return $jwt;
        }

        public function validate_token($jwt,$rt)
        {
            $payload = explode(".",$jwt)[1];

            $decoded_payload = (array)base64_decode($payload);
            if($decoded_payload['rt'] == $rt)
            {
                return true;
            }

            return false;
        }
    }
?>