<?php


include'ligacao.php';
//Istalação da Bas de dado
$ligacao = new PDO("mysql:host=$host", $utilizador, $pass);
$motor = $ligacao->prepare("CREATE database $base_dado");
$motor->execute();
echo '<p>Base de dado criado com sucesso </p>';
//feicho da base de dado
$ligacao = null;

echo '<p>tabela Users Criada com sucesso </p>';

//----------------------------------------------------------------------
//criação de tabelasa da base de dado
$ligacao = new PDO("mysql:dbname=$base_dado;host=$host", $utilizador, $pass);

// criação da tabela user- Utilizadores
$sql = "CREATE TABLE users(id_user int not null primary key, username varchar(39) not null, pass varchar(100) not null, avatar varchar(2500)not null)";
$motor = $ligacao->prepare($sql);
$motor->execute();


//----------------------------------------------------------------------
// criação da tabela Post
$sql = "CREATE TABLE posts(id_post int not null primary key, id_user int not null, titulo varchar(100)not null, messagem text, data_post datetime, foreign key(id_user) references users(id_user)on delete cascade) ";

$motor = $ligacao->prepare($sql);
$motor->execute();

echo '<p>tabela Posts Criada com sucesso </p>';
echo'<hr>';
echo '<p>Processo de criação de base de dado finalizado com sucesso</p>';
$ligacao = null;
?>