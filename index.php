<?php
//Index
$id_sessao = session_id();
if(empty($id_sessao)) session_start();
//cabeçalho
include 'cabecalho.php';

if($id_sessao == null)
{
	include 'login.php';
}

//Rodapé
include 'rodape.php';


?>