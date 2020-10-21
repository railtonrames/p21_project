<?php 

    class Funcionarios{
        public static function selecionaTodos(){
            $con = Conexao::getConn();

            $sql = "SELECT * FROM tb_dados_pessoais ORDER BY NOME ASC";
            $sql = $con->prepare($sql);
            $sql->execute();

            $resultado = array();

            while($row = $sql->fetchObject('Funcionarios')){
                $resultado[] = $row;    
            }

            if(!$resultado){
                throw new Exception("Não foi encontrado nenhum registro.");
                
            }

            return $resultado;  
        }

        public static function insert($dadosPost){
            if(empty($dadosPost['cpf']) || empty($dadosPost['dt_nasc']) || empty($dadosPost['sexo']) || empty($dadosPost['naturalidade'])
            || empty($dadosPost['cargo']) ){
                throw new Exception("Preencha todos os campos.");
                
                return false;
            }
            $con = Conexao::getConn();
            $sql = $con-> prepare('INSERT INTO tb_dados_pessoais (CPF, NOME, DT_NASC, SEXO, NATURALIDADE, CARGO) values (:cpf, :nom, :dtn, :sex, :nat, :car)');
            $sql->bindValue(':cpf', $dadosPost['cpf']);
            $sql->bindValue(':nom', $dadosPost['nome']);
            $sql->bindValue(':dtn', $dadosPost['dt_nasc']);
            $sql->bindValue(':sex', $dadosPost['sexo']);
            $sql->bindValue(':nat', $dadosPost['naturalidade']);
            $sql->bindValue(':car', $dadosPost['cargo']);
            $res = $sql->execute();

            var_dump($dadosPost);

            if($res == 0){
                throw new Exception("Falha ao inserir o funcionário.");

                return $res;      
            }
            for($i = 1; $i < 10; $i++){
                if($dadosPost['numero_'.$i] != 0){
                    $sql = $con-> prepare('INSERT INTO tb_telefone (ID, NUMERO, ID_CPF_FOREIGN_KEY) values (NULL, :num, :for)');
                    $sql->bindValue(':num', $dadosPost['numero_'.$i]);
                    $sql->bindValue(':for', $dadosPost['cpf']);
                    $sql->execute();
                }
            }
            return true;
        }

    }
?>