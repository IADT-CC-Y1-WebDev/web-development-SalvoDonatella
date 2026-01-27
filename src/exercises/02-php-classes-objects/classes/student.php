<?php 

class Student1 {
    public $name;
    public $number; 
}

class Student2 {
    public $name;
    public $number; 

    public function __construct($name, $number){
        $this->name = $name;
        $this->number = $number;
    }

    public function getName($name){
        echo $name;
    }
}

?>