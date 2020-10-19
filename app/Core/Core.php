<?php

        class core{
            public function start($urlGet){
                if(isset($urlGet['pagina'])){
                    $controller = ucfirst($urlGet['pagina'].'Controller');
                } else {
                    $controller = 'HomeController';
                }
                
                if(isset($urlGet['metodo'])){
                    $acao = $urlGet['metodo'];
                }else{
                    $acao = 'index';    
                }        

                if(!class_exists($controller)){
                    $controller = "ErroController";
                }

                call_user_func_array(array(new $controller, $acao), array());
            }    
        }
?>