<?php
if(!defined('APP_ROOT')){
    include_once('../config.php');
    redirectSecurity();
} 

abstract class supermodel{
    private $id;
    private $tablename;


    protected function setID($id){
        $this->id = $id;
    }
    protected function setTableName($tablename){
        $this->tablename = $tablename;
    }
    public function getID(){
        return $this->id;
    }
    public function getTableName():string{
        return $this->tablename;
    }

}