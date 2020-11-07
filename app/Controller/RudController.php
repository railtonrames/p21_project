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

        public function change($paramId){
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
                $concat_tel = (string)"TEL".$i;
                $concat_id = (string)"ID".$i;
                $parametros[$concat_tel] = $func2[$i]->NUMERO;
                $parametros[$concat_id] = $func2[$i]->ID;
            }

            //Insere Foto
            $func3 = Funcionarios::buscaFoto($paramId);
            if($func3){
                $parametros['FOTO'] = $func3->ARQUIVO;
                //var_dump($func3);
            } else {
                $parametros['FOTO'] = "Sem_Foto.jpg";
            }
           
            $conteudo = $template->render($parametros);
            echo $conteudo;
        }

        public function update(){
        try {
            Funcionarios::update($_POST);
            echo '<script>alert("Dado(s) alterados com sucesso !");</script>';
            echo '<script>location.href="?pagina=rud"</script>';
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'");</script>';
            echo '<script>location.href="?pagina=rud&metodo=change&id='.$_POST[CPF].'"</script>';
        }   
        }

        public function delete($paramId){   
            try {
                //$id = $_GET['id'];
                Funcionarios::delete($paramId);
                echo '<script>alert("Usuário deletado com sucesso !");</script>';
                echo '<script>location.href="?pagina=rud"</script>';
            } catch (Exception $e) {
                echo '<script>alert("'.$e->getMessage().'");</script>';
                echo '<script>location.href="?pagina=rud&metodo=change&id='.$_POST[CPF].'"</script>';
            }
        }
    }
?>