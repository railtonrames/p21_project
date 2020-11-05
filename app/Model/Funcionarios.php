<?php 

    class Funcionarios{
        public static function selecionaTodos(){
            $con = Conexao::getConn();

            $sql = "SELECT CPF,NOME,DT_NASC,SEXO,NATURALIDADE,CARGO,group_concat(NUMERO) as NRS, ID_FOTO from tb_dados_pessoais
            LEFT JOIN tb_foto ON tb_dados_pessoais.CPF = tb_foto.ID_CPF_FOREIGN_KEY
            LEFT JOIN tb_telefone ON tb_dados_pessoais.CPF = tb_telefone.ID_CPF_FOREIGN_KEY 
            group by tb_dados_pessoais.CPF order by tb_dados_pessoais.NOME;";
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

            //var_dump($dadosPost);

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

            if(isset($_FILES['imagem'])){

                $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                $novo_nome = md5(uniqid($_FILES['imagem']['name'])).".".$extensao;
                $diretorio = "app/Img_Funcs/";
        
                move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome);             

                $sql = $con-> prepare('INSERT INTO tb_foto (ID_FOTO, ARQUIVO, DATA, ID_CPF_FOREIGN_KEY) VALUES (NULL, :nome, NOW(), :cpf)');
                $sql->bindValue(':cpf', $dadosPost['cpf']);
                $sql->bindValue(':nome', $novo_nome );

                $sql->execute();           
            }
            return true;
        }

        public static function selecionaPorId($idFunc){
            $con = Conexao::getConn();

            $sql = "SELECT * FROM tb_dados_pessoais WHERE CPF = :cpf";
            /*$sql = "SELECT CPF,NOME,DT_NASC,SEXO,NATURALIDADE,CARGO,group_concat(NUMERO) as NRS, ID_FOTO from tb_dados_pessoais
            LEFT JOIN tb_foto ON tb_dados_pessoais.CPF = tb_foto.ID_CPF_FOREIGN_KEY
            LEFT JOIN tb_telefone ON tb_dados_pessoais.CPF = tb_telefone.ID_CPF_FOREIGN_KEY 
            WHERE CPF = :cpf
            group by tb_dados_pessoais.CPF;";*/
            $sql = $con->prepare($sql);
            $sql->bindValue(':cpf', $idFunc, PDO::PARAM_STR);
            $sql->execute();

            $resultado = $sql->fetchObject('Funcionarios');

            if (!$resultado) {
				throw new Exception("Não foi encontrado nenhum registro.");	
			}else{
                return $resultado;
            }  
        }

        public static function buscaTelefone($idFunc){
            $con = Conexao::getConn();
            $nrs = array();

            $sql = "SELECT * FROM tb_telefone WHERE ID_CPF_FOREIGN_KEY = :cpf";
            $sql = $con->prepare($sql);
            $sql->bindValue(':cpf', $idFunc, PDO::PARAM_STR);
            $sql->execute();

            $count = $sql->rowCount();
            
            for($i = 0; $i < $count; $i++){
                $sql = "SELECT NUMERO, ID FROM tb_telefone WHERE ID_CPF_FOREIGN_KEY = :cpf order by ID LIMIT 1 OFFSET $i;";
                $sql = $con->prepare($sql);
                $sql->bindValue(':cpf', $idFunc, PDO::PARAM_STR);
                $sql->execute();
                $nrs[$i] = $sql->fetchObject('Funcionarios');    
            }
            return $nrs;    
        }

        public static function buscaFoto($idFunc){
            $con = Conexao::getConn();

            $sql = "SELECT * FROM tb_foto WHERE ID_CPF_FOREIGN_KEY = :cpf";
            $sql = $con->prepare($sql);
            $sql->bindValue(':cpf', $idFunc, PDO::PARAM_STR);
            $sql->execute();

            $resultado = $sql->fetchObject('Funcionarios');
            
            return $resultado;
        }

        public static function update($params){
            $con = Conexao::getConn();

            $sql = "UPDATE tb_dados_pessoais SET NOME = :nom, DT_NASC = :dtn, SEXO = :sex, NATURALIDADE = :nat, CARGO = :car WHERE CPF = :cpf";
            $sql = $con->prepare($sql);
            $sql->bindValue(':cpf', $params['CPF']);
            $sql->bindValue(':nom', $params['NOME']);
            $sql->bindValue(':dtn', $params['DT_NASC']);
            $sql->bindValue(':sex', $params['SEXO']);
            $sql->bindValue(':nat', $params['NATURALIDADE']);
            $sql->bindValue(':car', $params['CARGO']);
            $resultado = $sql->execute();

            for($i = 1; $i < 10; $i++){
                if($params['numero_'.$i] != 0 && $params['id_'.$i] !=0){
                    $sql = $con-> prepare('UPDATE tb_telefone SET NUMERO = :num WHERE ID = :id');
                    $sql->bindValue(':num', $params['numero_'.$i]);
                    $sql->bindValue(':id', $params['id_'.$i]);
                    $resultado2 = $sql->execute();
                } else if($params['numero_'.$i] != 0) {
                    $sql = $con-> prepare('INSERT INTO tb_telefone (ID, NUMERO, ID_CPF_FOREIGN_KEY) values (NULL, :num, :for)');
                    $sql->bindValue(':num', $params['numero_'.$i]);
                    $sql->bindValue(':for', $params['CPF']);
                    $resultado2 = $sql->execute();
                }
            }

            if(isset($_FILES['imagem']) && $_FILES['imagem']['tmp_name'] != ""){
                $busca_ft = Funcionarios::buscaFoto($params['CPF']);

                unlink("app/Img_Funcs/".$busca_ft->ARQUIVO);

                $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                $novo_nome = md5(uniqid($_FILES['imagem']['name'])).".".$extensao;
                $diretorio = "app/Img_Funcs/";
        
                move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome);             

                $sql = "UPDATE tb_foto SET ARQUIVO = :nome, DATA = NOW() WHERE ID_CPF_FOREIGN_KEY = :cpf";
                $sql = $con->prepare($sql);
                $sql->bindValue(':cpf', $params['CPF']);
                $sql->bindValue(':nome', $novo_nome );

                $resultado3 = $sql->execute();          
            } else {
                $resultado3 = 1; 
            }

            if($resultado == 0 || $resultado2 == 0 || $resultado3 == 0){
                throw new Exception("Falha ao alterar publicação.");
                
                return false;
            }
            return true;
        }

    }
?>
