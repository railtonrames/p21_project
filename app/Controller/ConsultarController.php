<?php

    class ConsultarController{
        public function index(){
            try{
                $colecFuncionarios = Funcionarios::selecionaTodos();

                $loader = new \Twig\Loader\FilesystemLoader('app/View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('Consultar.html');

                $parametros = array();
                $parametros['func'] = $colecFuncionarios;

                $conteudo = $template->render($parametros);

                echo $conteudo;

                //var_dump($colecFuncionarios);
                
            }catch(Exception $e){
                echo $e->getMessage();
            }
            
        }
    }
?>