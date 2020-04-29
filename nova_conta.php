<?php

	$id_sessao = session_id();
	if(empty($id_sessao)) session_start();
	

	//cabeçalho
	include 'cabecalho.php';

	if(!isset($_POST['bt_submit']))
	{
		ApresentarFormulario();
	}
	else
	{
		RegistarUtilizador();
	}
	

	//Rodapé
	include 'rodape.php';
    
    // Função do formulario
function ApresentarFormulario()
	{
       //-------------------------------------------------------------------------
	  // Apresnatr formulário
		echo '
              <form class="novo_formulario" method="POST" action="nova_conta.php?a=nova" entype="multipart/form-data">
               <h3>Nova Conta</h3><hr><br> 

               Usuario:<br><input type="text" size="20" name="text_utilizadorn"><br> 
               Senha:<br><input type="password" size="20" name="text_senha1"><br>
               Confirmar:<br><input type="password" size="20" name="text_senha2"><br><br>
			   
			   <input type="submit" name="bt_submit" value="Registar"><br><br>
               
               
             

               <a href="index.php">Voltar</a>
              </form>

		';
	}
function RegistarUtilizador()
{

					// codigo da iamgem

	           /*<small>(imagem do tipo <strong>JPG</strong> tamanho máximo <strong> 50KB</strong>)</small><br><br>
               <input type="submit" name="bt_submit" value="Registar"><br><br>
                */
	// as Variaveis do utiizador novo
	$usuario = $_POST['text_utilizadorn'];
	$senha1 = $_POST['text_senha1'];
	$senha2 = $_POST['text_senha2'];
	// Imagem Do Utiliador
    //$conta = $_FILES['imagem_usu'];

     $erro = false;


	if($usuario == "")
	{
		echo '<div class="aviso"><p >preencha os campos vazios</p></div>';
		$erro = true;
	}

	else if($senha1 == "")
	{
		echo '<div class="aviso"><p >preencha os campos vazios</p></div>';
		$erro = true;
	}

	else if($senha2 == "")
	{
		echo '<div class="aviso"><p >preencha os campos vazios</p></div>';
		$erro = true;
	}

    if($senha1 != $senha2)
	{
		//erro de Senhas difenrentes
	   echo '<div class="aviso">As senhas são diferentes</div>';
	   $erro = true;	
	}

	if ($erro)
	{
      ApresentarFormulario();
      include 'rodape.php';
      exit;
	}
	//----------------------------------------------
	//        Processamento do novo usuario
	//----------------------------------------------

    include 'ligacao.php';

    $ligacao = new PDO("mysql:dbname=$base_dado;host=$host", $utilizador, $pass);

    $motor = $ligacao->prepare("select username from users where username = ?");
    $motor ->bindparam(1,$usuario,PDO::PARAM_STR);
    $motor->execute();

    if($motor->rowCount() != 0)
    {
    	//Utilizador ja existe
    	echo '<div class="aviso>Utilizador ja Registrado</div>';
    	$ligacao =null;
    	ApresentarFormulario();
    	include'rodape.php';
    	exit;
    }
    else
    {
    	//registo do novo usuario
    	$motor = $ligacao->prepare("SELECT MAX(ide_user) AS MAXID from users");
    	$motor->execute();

    	$id_temp = $motor->fetch(PDO::FETCH_ASSOC)['MAXID'];
    	if($id_temp = null)
    	   {
    		$id_temp = 0;
    	    }
    	else
    	    {
    		$id_temp++;
         	}
         }

    	//password Emcripdade
    	$passEncriptada = md5($senha1);


    	//inserindo os dados na base de dado

    	$sql = "INSERT into users values(:id_user, :username, :pass)";
    	$motor = $ligacao->prepare($sql);
    	$motor->bindparam("id_user", $id_temp, PDO::PARAM_INT);
    	$motor->bindparam("username", $usuario, PDO::PARAM_STR);
    	$motor->bindparam("pass", $passEncriptada, PDO::PARAM_STR);
    	//$motor->bindparam("avatar",$avatar['name'],PDO::PARAM_STR);
        $motor->execute();
        $ligacao = null;

    	// Upload Da Imagem do nosso avater
    	//move_uploaded_file($avatar['tmp_name],"imagens/avtars".$avatar['name']);

    	echo'
    	    <div class="novo">Seja Bem-vindo Sr(a)<strong>'.$usuario.'</strong><br>
    	    Agora já pode participar de forma ativa ao nosso fórum.<br><br>
			<a href="index.php">Voltar</a> 

    	    </div>

    	    

    	';	

    
}

?>