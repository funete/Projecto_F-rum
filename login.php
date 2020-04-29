<?php
echo '
  <form class="form_login" method ="post" action ="login.php">
   <h3>Login</h3><hr><br>
   para acessar ao fórum entre com nome de Usuario e Senha.<br>
   se não tens uma conta cria <a href="nova_conta.php">uma nova conta</a><br><br>

   Usuario:<br><input type="text" size="20" name="text_utilizador"><br> 
   Senha:<br><input type="password" size="20" name="text_senha"><br><br>
   <input type="submit" name="bt_submit" value="Entrar">

  </form>


';

?>