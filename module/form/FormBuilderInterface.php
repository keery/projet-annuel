<?php

namespace Module\Form;

class FormBuilderInterface
{
    private $structure = [];
    public $method = "POST";
    public $action;
    public $enctype;
    
    
    public function add($name, $type, $options=null) {
        $options['name'] = $name;
        
        //Si il n'y a pas de label on prend le nom par defaut avec une majuscule
        if(!isset($options['label']))  $options['label'] = ucfirst($name);

        $type->build($options);
        $this->structure[$name] = $type;

        //Attribut pour les formulaires qui contiennent des fichiers
        if( $this->isTypeFile(get_class($type)) ) $this->enctype = "multipart/form-data";
    }

    public function getStructure() {
        return $this->structure;
    }

    public function isTypeFile($type) {
        return $type == "Module\Form\Type\FileType";
    }

    public function getMethod() {
        return $this->method;
    }
    public function setMethod($method) {
        $this->method = $method;
    }  
    
    public function getAction() {
        return $this->action;
    }   
    public function setAction($action) {
        $this->action = $action;
    }  

    public function getEnctype() {
        return $this->enctype;
    }   
    public function setEnctype($enctype) {
        $this->enctype = $enctype;
    }      
}