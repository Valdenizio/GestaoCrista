<?php
include_once 'pesquisa.php';
?>
<html>
	<head>
		<meta charset="UTF-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1" />
    
    	<!-- Bootstrap -->
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="../bootstrap/css/style.css" rel="stylesheet">
		<script src="../Bootstrap/js/bootstrap.min.js"></script>
      	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script>
	
		
        <title>Gestão Crista</title>
	</head>
	<body>
		<div class="container">
			<div class="lead">
				<div class="col-sm-12">
				
					<table class="table table-striped table-bordered" >
						<tr>
							<td class="col-sm-2"><b>Login do usuário</b></td>
							<td class="col-sm-2"><b>Perfil do usuário</b></td>
							<td class="col-sm-2"><b>Igreja</b></td>
							<td class="col-sm-1"/>
						</tr>
						<?php 
	  						$login=$_REQUEST['usuario'];
	  						$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
	  						$sql = "select usu.id_usuario, usu.ds_login, per.ds_perfil, igj.nm_igreja
	  						from usuario usu inner join perfil per
    						on usu.id_perfil=per.id_perfil inner join igreja igj
    						on usu.id_igreja=igj.id_igreja";
	  						
	  						if ($login!=null){
	  							$sql=$sql." where LOWER(usu.ds_login) like LOWER('%{$login}%')";
	  							//var_dump($sql);
	  						}
	  						
	  						$sql=$sql." order by ds_login";
	  								
	  						$stm = $pdo->query($sql);
	  						//var_dump($stm);
	  							  						
	  						while($dados = $stm->fetch(PDO::FETCH_ASSOC)){
	   							
	  							//Criptografando parametros enviados via get
	  							$idlogin=base64_encode($dados['ID_usuario']);
	   							$dslogin=base64_encode($login);
	   							
	   							echo "<tr>
										<td>".$dados['DS_LOGIN']."</td>
										<td>".$dados['DS_PERFIL']."</td>
	  									<td>".$dados['NM_IGREJA']."</td>
										<td class='text-center'>
										<center><form action='../Usuario/visualizar.php' method='get' target='_self'>
										<input type='text' style='display:none' id='id_usuario' name='id_usuario' value='".$idlogin."'>
										<input type='text' style='display:none' id='login' name='login' value='".$dslogin."'>
										<button type='submit' class='btn btn-default col-sm-offset-1 btn-xs btn-acao' name='acao' value='visualizar'>Visualizar</button>
										</form></center></td>
										</tr>";
							}

							?>						
					</table>
				</div>
			</div>
		</div>
	
	
	</body>
</html>
