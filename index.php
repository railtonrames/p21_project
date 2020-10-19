<?php

require_once 'app/Core/Core.php';
require_once 'app/Controller/HomeController.php';
require_once 'app/Controller/ErroController.php';
require_once 'app/Controller/ConsultarController.php';
require_once 'app/Model/Funcionarios.php';
require_once 'lib/Database/Conexao.php';
require_once 'vendor/autoload.php';

$template = file_get_contents('app/Template/estrutura.html');

ob_start();
    $core = new Core;
    $core->start($_GET);

    $saida = ob_get_contents();
ob_end_clean();

$tpl_pronto = str_replace('{{area_dinamica}}', $saida, $template);

echo $tpl_pronto;

?>