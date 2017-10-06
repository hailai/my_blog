<?php
require 'config.php';
class data{
    public $con;
    public function connect(){
        $this->con=new mysqli(servername,username,password,database);
        if($this->con->errno){
            exit('connect error'.$this->con->error);
        }else{
            return $this->con;
        }
    }
    public function close(){
        if($this->con){
           $this->con->close();
           $this->con=null;
        }
    }
}