<?php

    class HomeController{
        public function index(){
            //echo 'teste';
            Funcionarios::selecionaTodos();
        }
    }
?>