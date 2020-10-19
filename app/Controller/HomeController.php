<?php

    class HomeController{
        public function index(){

                $loader = new \Twig\Loader\FilesystemLoader('app/View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('Home.html');

                $parametros = array();

                $conteudo = $template->render($parametros);

                echo $conteudo;
           
        }
    }
?>