<?php

Class GoogleAuth {
    
    protected $client;
    
    public function __construct(Google_Client $googleClient = null) {
        $this->client=$googleClient;
        if ($this->client){
            $this->client->setClientId('1021254049697-gnsmganhk4kvig8j88gbg5vo6c3qbrpd.apps.googleusercontent.com');
            $this->client->setClientSecret('BH2FdJbBMNlKH4HfhvsY90DQ');
            $this->client->setRedirectUri('http://localhost:8080/incentivo/index.php');
            $this->client->setScopes('email');
            
        }
    }
    
    public function isLoggedIn(){
        return isset($_SESSION["access_token"]);
    }
    
    public function getAuthUrl() {
        return $this->client->createAuthUrl();
    }
    
    public function checkRedirectCode() {
        if (isset($_GET['code'])){
            $this->client->authenticate($_GET['code']);
            $this->setToken($this->client->getAccessToken());
            $payload=$this->getPayload();
            
            //echo  "<pre>", print_r($payload['email']),"</pre>";
            $this->registraUsuario($payload['email']);
            return true;
        }
        return false;
    }
    
    public function setToken($token) {
        $_SESSION['access_token']=$token;
        $this->client->setAccessToken($token);
        
    }
    
    public function logout() {
        unset($_SESSION['access_token']);
        
    }
    
    public function getPayload() {
      //$payload = $this->client->verifyIdToken()->getAttribute();
      $payload = $this->client->verifyIdToken() ;   
      return $payload;    
        
    }
    
    public function registraUsuario($payload){
        $_SESSION['correo_verif']=$payload;	
        return true;
    }
}