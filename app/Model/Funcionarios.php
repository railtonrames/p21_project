<?php 

    class Funcionarios{
        public static function selecionaTodos(){
            $con = Conexao::getConn();

            $sql = "SELECT * FROM tb_dados_pessoais ORDER BY NOME DESC";
            $sql = $con->prepare($sql);
            $sql->execute();

            var_dump($sql->fetchAll());

        }
    }
?>