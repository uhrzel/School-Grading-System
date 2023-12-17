<?php

class Validate{
    private $_passed = false,
            $_errors = [],
            $_db = null;

    public function __construct(){
        $this->_db = Database::getInstance();
    }

    public function check($source, $items = []){
        foreach($items as $item => $rules){
            foreach($rules as $rule => $rule_value){
                $value = trim($source[$item]);
                $item = H::sanitize($item);

                if($rule === 'required' && empty($value)){
                    $this->addError("{$rules['display']} is required.");
                } else if(!empty($value)){
                    switch($rule){
                        case 'min':
                            if(strlen($value) < $rule_value){
                                $this->addError("{$rules['display']} must be a minimum of {$rule_value} characters.");
                            }
                        break;
                        case 'max':
                            if(strlen($value) > $rule_value){
                                $this->addError("{$rules['display']} must be a maximum of {$rule_value} characters.");
                            }
                        break;
                        case 'matches':
                            if($value != $source[$rule_value]){
                                $this->addError("{$rules['display']} must match {$rule_value}.");
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->query("SELECT {$item} FROM {$rules['unique']} WHERE {$item} = ?", [$value]);
                            if($check->count()){
                                $this->addError("{$rules['display']} already exists.");
                            }
                        break;
                        case 'unique_update':
                            $t = explode(',', $rule_value);
                            $table = $t[0];
                            $id = $t[1];
                            $query = $this->_db->query("SELECT * FROM {$table} WHERE id != ? AND {$item} = ?", [$id, $value]);
                            if($query->count()){
                                $this->addError("{$rules['display']} already exists.");
                            }
                        break;
                        case 'is_numeric':
                            if(!is_numeric($value)){
                                $this->addError("{$rules['display']} must be a number.");
                            }
                        break;
                        case 'valid_email':
                            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                                $this->addError("{$rules['display']} must be a valid email address.");
                            }
                        break;
                        case 'valid_name':
                            if(!preg_match("/^[a-zA-Z ]*$/", $value)){
                                $this->addError("{$rules['display']} must be a valid name.");
                            }
                        break;
                    }
                }
            }
        }

        if(empty($this->_errors)){
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($error){
        $this->_errors[] = $error;
    }

    public function errors(){
        return $this->_errors;
    }

    public function passed(){
        return $this->_passed;
    }

    public function displayErrors(){
        $html = '<ul class="bg-danger">';
        foreach($this->errors() as $error){
            if(is_array($error)){
                foreach($error as $subError){
                    $html .= '<li class="text-danger">'.$subError.'</li>';
                }
            }else{
                $html .= '<li class="text-danger">'.$error.'</li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }
}