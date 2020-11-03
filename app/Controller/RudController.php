<?php

    class RudController{
        public function index(){
            try{
                $colecFuncionarios = Funcionarios::selecionaTodos();

                $loader = new \Twig\Loader\FilesystemLoader('app/View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('Rud.html');

                $parametros = array();
                $parametros['func'] = $colecFuncionarios;

                $conteudo = $template->render($parametros);

                echo $conteudo;

                //var_dump($colecFuncionarios);
                
            }catch(Exception $e){
                echo $e->getMessage();
            }
            
        }

        public function update($paramId){
            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('update.html');

            //echo $paramId;

            //Insere Dados Pessoais
            $func = Funcionarios::selecionaPorId($paramId);
            //var_dump($func);
            $parametros = array();
            $parametros['NOME'] = $func->NOME;
            $parametros['CPF'] = $func->CPF;
            $parametros['DT_NASC'] = $func->DT_NASC;
            $parametros['SEXO'] = $func->SEXO;
            $parametros['NATURALIDADE'] = $func->NATURALIDADE;
            $parametros['CARGO'] = $func->CARGO;

            //Insere Telefones
            $func2 = Funcionarios::buscaTelefone($paramId);
            //var_dump($func2);
            $total = count($func2);
            for($i = 0; $i < $total; $i++){
                $contador = (string)"TEL".$i;
                //echo($contador);
                $parametros[$contador] = $func2[$i]->NUMERO;
            }

            //Insere Foto
            $func3 = Funcionarios::buscaFoto($paramId);
            $parametros['FOTO'] = $func3->ARQUIVO;
            //var_dump($func3);


            $conteudo = $template->render($parametros);
            echo $conteudo;
        }
    }
?>