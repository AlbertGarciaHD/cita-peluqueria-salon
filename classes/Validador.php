<?php
    namespace Classes;

    use Exception;

    class Validador{
        protected $data;
        protected $errors = [];

        public function __construct($data)
        {
            $this->data = $this->trim( $data ) ;
        }

        public function getData() {
            //TODO: Validar los campos que debe devolver 
            return $this->trim( $this->data );
        }

        public function validate(array $rules)
        {
            foreach ($rules as $field => $ruleSet) {
                $rulesArray = explode('|', $ruleSet);
                foreach ($rulesArray as $rule) {
                    $this->applyRule($field, $rule);
                }
            }
            return empty($this->errors);
        }

        protected function applyRule($field, $rule)
        {
            if (strpos($rule, ':') !== false) {
                list($ruleName, $parameter) = explode(':', $rule);
            } else {
                $ruleName = $rule;
                $parameter = null;
            }

            if (!method_exists($this, $ruleName)) {
                throw new Exception("La regla $ruleName no existe.");
            }

            $this->{$ruleName}($field, $parameter);
        }

        protected function required($field)
        {
            if (empty($this->data[$field])) {
                $this->errors[$field][] = "El campo $field es requerido.";
            }
        }

        protected function email($field)
        {
            if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
                $this->errors[$field][] = "El campo $field debe ser un email válido.";
            }
        }

        protected function max($field, $max)
        {
            if (strlen($this->data[$field]) > $max) {
                $this->errors[$field][] = "El campo $field no debe superar los $max caracteres.";
            }
        }

        protected function trim($data)
        {
            $response = [];
            foreach ($data as $key => $value) {
                $response[$key] = trim($value);
            }
            return $response;
        }

        protected function empty($field){
            if( empty($this->data[$field]) ){
                $this->errors[$field][] = "El campo $field no puede estar vacio.";
            }
        }
        

        public function errors()
        {
            return $this->errors;
        }

    }