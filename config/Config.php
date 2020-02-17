<?php
    namespace Config;

    class Config
    {
        public function getDatabaseConfig()
        {
            return [
                'password' => '',
                'username' => 'root',
                'database' => 'way2',
                'servername' => 'localhost',
            ];
        }
        
        public function getApiConfig()
        {
            return [
                'url' => 'https://d1c2avle47.execute-api.sa-east-1.amazonaws.com/api/cadastros'
            ];
        }
    }
