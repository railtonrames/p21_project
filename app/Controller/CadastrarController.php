<?php

    class CadastrarController{
        public function index(){

                $loader = new \Twig\Loader\FilesystemLoader('app/View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('Cadastrar.html');

                $parametros = array();

                $conteudo = $template->render($parametros);

                echo $conteudo;  
                      
        }

        public function insert(){
            try{
                Funcionarios::insert($_POST);

                echo '<script>alert("Cadastro realizado com sucesso !");</script>';
                echo '<script>location.href="?pagina=cadastrar";</script>';
            }catch(Exception $e){
                echo '<script>alert("'.$e->getMessage().'");</script>';
                echo '<script>location.href="?pagina=cadastrar";</script>';
            }
        }

    }
?>