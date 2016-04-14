<?php 
header('Content-Type: text/html; charset=ISO-8859-1');

echo '<html>';
session_start();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Bootstrap -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="bootstrap/css/style.css" rel="stylesheet">
    <title>Gestão Crista</title>
    
</head>
<body>
<br>
<?php 
	if (isset($_REQUEST['res'])){
		$teste=$_GET['res'];
		if ($teste=="err"){
			//var_export("teste1");
			echo "	<div class='alert alert-danger col-sm-offset-2 col-sm-8'>
							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
		  					<strong>Acesso não permitido!</strong> Favor verifique o login e a senha e tente novamente.
							<alert>
						</div>";
		}
	}
?>
<div class="col-sm-offset-4">
<form class="form-horizontal col-sm-6" action="login/controle.php" method="post" target="_self">
	<div class="panel panel-default top40">
  		<div class="panel-heading">Login</div>
  		<div class="panel-body">
  			<div class="form-group form-element">
    			<label for="login" class="col-sm-4 control-label">Usuário:</label>
    			<div class="col-sm-8">
      					<input type="text" class="form-control" id="login" name="login" placeholder="Login" required>
    			</div>
 			</div>
			<div class="form-group">
			   	<label for="senha" class="col-sm-4 control-label">Senha:</label>
			   	<div class="col-sm-8">
			   		<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>	   	
				</div>
			</div>
  			<div class="form-group">
    			<div class="col-sm-offset-4 col-sm-6">
      				<button type="submit" class="btn btn-primary col-sm-6" id="acao" name="acao" value="logar">Entrar</button>
    			</div>
  			</div>
 		</div>
 	</div>
</form>
</div>
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Versão 3.3.6 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Versão 1.4.1 -->
	
</body>
</html>