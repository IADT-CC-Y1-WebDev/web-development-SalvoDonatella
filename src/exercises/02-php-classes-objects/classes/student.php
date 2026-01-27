<?php 

class Student1 {
    public $name;
    public $number; 
}

class Student2 {
    protected $name;
    protected $number; 

    public function __construct($name, $number){
        $this->name = $name;
        $this->number = $number;
    }

    public function getName(){
        echo $this->name;
    }

    public function getNumber(){
        if (empty($this->number)) {
            throw new Exception("Student number cannot be empty");
        }
        else {
            echo $this->number;
         }
     }
}

?>