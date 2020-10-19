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
    }
?>