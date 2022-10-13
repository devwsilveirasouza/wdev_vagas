<?php 

require __DIR__ .'/vendor/autoload.php';
// Definindo a constante do titulo da pagina
define('TITLE', 'Editar vaga');
// Chamando a classe
use \App\Entity\Vaga;
// Debugando o código
// echo "<pre>"; print_r($_POST); echo "<pre>"; exit;
// VALIDAÇÃO DO ID
if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
    header('location: index.php?status=error');
    exit;
}
// CONSULTA A VAGA
$obVaga = Vaga::getVaga($_GET['id']);
// echo "<pre>"; print_r($obVaga); echo "</pre>"; exit;

// VALIDAÇÃO DO VAGA
if(!$obVaga instanceof Vaga){
    header('location: index.php?status=error');
    exit;
}

// VALIDAÇÃO DO POST
if(isset($_POST['titulo'], $_POST['descricao'], $_POST['ativo'])){
    // $obVaga = new Vaga; // Criando instância da classe // // Instanciado anteriormente    
    $obVaga->titulo     = $_POST['titulo'];
    $obVaga->descricao  = $_POST['descricao'];
    $obVaga->ativo      = $_POST['ativo'];
    // echo "<pre>"; print_r($obVaga); echo "</pre>"; exit;
    $obVaga->atualizar();

    header('location: index.php?status=success');
    exit;
    
}

include __DIR__ .'/includes/header.php';
include __DIR__ .'/includes/formulario.php';
include __DIR__ .'/includes/footer.php';