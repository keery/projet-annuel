<?php
namespace Module\Form;

class Validator {
    
    private $rules;
    private $object;
    private $errors = [];

    public function __construct($rules, $object) {
        $this->rules = $rules;
        $this->object = $object;
    } 

    public function verify() {
        $object = $this->object;
        foreach ($this->rules as $key => $rule) {
            if($key == 'captcha') $this->captcha($_POST['captcha']);
            else {
                $f = 'get'.ucfirst(strtolower($key));
                $value = $object->$f();
                foreach ($rule as $keyRule => $critere) {
                    $this->$keyRule($value, $critere, $key);
                }
            }
        }
        return sizeof($this->errors) > 0 ? $this->errors : true;
    }

    public function maxLength($string, $length, $field){
        if(strlen(trim($string))<=$length) {            
            return true;
        }
        $this->errors[] = "La taille du champ ".$field." doit être inférieur à ".$length;
        return false;
	}

	public function minLength($string, $length, $field){
        if(strlen($string)>=$length) {
            return true;
        }
        $this->errors[] = "La taille du champ ".$field." doit être supérieur à ".$length;
        return false;
    }
    

	public function maxNum($num, $length, $field){
        if($num<=$length) {
            return true;
        }
        $this->errors[] = "Le chiffre du champ ".$field." doit être inférieur à ".$length;
        return false;
	}

	public function minNum($num, $length, $field){
        if($num>=$length) {
            return true;
        }
        $this->errors[] = "Le chiffre du champ ".$field." doit être supérieur à ".$length;
        return false;
	}

	public function checkEmail($email, $field){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        $this->errors[] = "Le format de l'email n'est pas valide";
        return false; 
    }
    
    public function required($required, $field){
        if(!empty($required)) {
            return true;
        }
        $this->errors[] = "Vous n'avez pas rempli tous les champs";
        return false; 
	}
    
    public function captcha($captcha, $field){
        if($captcha == $_SESSION['captcha']) {
            return true;
        }
        $this->errors[] = "Captcha invalide";
        return false; 
	}

	public function checkPwd($pwd, $field){
        if(strlen($pwd)>=6 && 
        strlen($pwd)<=32 && 
		preg_match("/[a-z]/", $pwd) && 
		preg_match("/[A-Z]/", $pwd) && 
		preg_match("/[0-9]/", $pwd)) {
            return true;
        }
        $this->errors[] = "Mot de passe incorrect(Maj, Min, Chiffre, entre 6 et 32)";
        return false;
	}

	public function checkNumber($number, $field){
        if(is_numeric(trim($number))) {
            return true;
        }
        $this->errors[] = "Chiffre requis pour le champ ".$field."";
        return false;
	}
}