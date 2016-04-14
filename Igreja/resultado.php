
<html>
	<head>
		<meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
    	<meta name="viewport" content="width=device-width, initial-scale=1" />
    
    	<!-- Bootstrap -->
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="../bootstrap/css/style.css" rel="stylesheet">
		<script src="../Bootstrap/js/bootstrap.min.js"></script>
      	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script>
	
		
        <title>Gestão Crista</title>
	</head>
	<body>
	<?php
		include_once 'pesquisa.php';
	?>
		<div class="container col-sm-offset-2">
			<div class="lead">
				<div class="col-sm-10">
				
					<table class="table table-striped table-bordered" >
						
						<?php 
	  						$nome=$_REQUEST['igreja'];
	  						$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
	  						$sql = "select *
	  						from igreja";
	  						
	  						if ($nome!=null){
	  							$sql=$sql." where LOWER(igreja.nm_igreja) like LOWER('%{$nome}%')";
	  							//var_dump($sql);
	  						}
	  						
	  						$sql=$sql." order by nm_igreja";
	  								
	  						$stm = $pdo->query($sql);
	  						//var_dump($stm);
	  						
	  						if ($stm->rowCount(PDO::FETCH_ASSOC)>=1) {
	  							echo "<tr>
										<td class='col-sm-3'><b>Nome</b></td>
										<td class='col-sm-3'><b>Dirigente</b></td>
										<td class='col-sm-1'/>
										</tr>";
	  						
	  						while($dados = $stm->fetch(PDO::FETCH_ASSOC)){
	   							
	  							//Criptografando parametros enviados via get
	  							$idigreja=base64_encode($dados['ID_IGREJA']);
	   							
	   							
	   							echo "<tr>
										<td>".$dados['NM_IGREJA']."</td>
										<td>".$dados['NM_DIRIGENTE']."</td>
										<td class='text-center'>
										<center><form action='../Igreja/visualizar.php' method='get' target='_self'>
										<input type='text' style='display:none' id='idigreja' name='idigreja' value='".$idigreja."'>
										<input type='text' style='display:none' id='igreja' name='igreja' value='".$nome."'>
										<button type='submit' class='btn btn-default col-sm-offset-1 btn-xs btn-acao' name='acao' value='visualizar'>Visualizar</button>
										</form></center></td>
										</tr>";
							}
							
							}else{
								echo "	<div class='alert alert-info'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	  									Registro não encontrado.
										<alert>
										</div>";
							}
							
							?>						
					</table>
				</div>
			</div>
		</div>
	
	
	</body>
</html>
