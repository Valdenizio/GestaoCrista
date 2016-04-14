<?php
header('Content-Type: text/html; charset=ISO-8859-1');

?>
<html>
	<head>
		<!-- <meta charset="UTF-8" /> -->
    	<meta name="viewport" content="width=device-width, initial-scale=1" />
    
    	<!-- Bootstrap -->
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="../bootstrap/css/style.css" rel="stylesheet">
		<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Versão 3.3.6 -->
    <script src='../bootstrap/js/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Versão 1.4.1 -->		
        <title>Gestão Crista</title>
	</head>
	<body>
	<br/>
	<?php include_once 'pesquisa.php';?>
		
		<div class="container col-sm-offset-2">
			<div class="lead">
				<div class="col-sm-10">
					<br>
					<table class="table table-striped table-bordered" >
						
						<?php 
	  						if (isset($_REQUEST['membro'])){ 
	  							$nome=$_REQUEST['membro'];
	  						}else{
	  							$nome=null;
	  						}
	  						
	  						if (isset($_REQUEST['igreja'])){
	  							$igreja=$_REQUEST['igreja'];
	  						}else{
	  							$igreja=null;
	  						}
	  						
	  						$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
	  						$sql = "select mem.id_membro, mem.nm_membro, igj.nm_igreja
	  						from membro mem left join igreja igj on mem.id_igreja=igj.id_igreja";
	  						
	  						if ($nome!=null){
	  							$sql=$sql." where LOWER(mem.nm_membro) like LOWER('%{$nome}%')";
	  							if ($igreja!=null){
	  								$sql=$sql." and mem.id_igreja ='{$igreja}'";
	  							}
	  						}else{
	  							if ($igreja!=null){
	  								$sql=$sql." where mem.id_igreja ='{$igreja}'";
	  							}
	  						}
	  							
	  						$sql=$sql." order by nm_membro";
	  								
	  						$stm = $pdo->query($sql);
	  						//var_dump($stm);
	  						if ($stm->rowCount(PDO::FETCH_ASSOC)>=1) {
	  							echo "<tr>
										<td class='col-sm-3'><strong>Nome do membro</strong></td>
										<td class='col-sm-3'><strong>Igreja</strong></td>
										<td class='col-sm-1'/>
										</tr>";
	  						
	  							  						
	  						while($dados = $stm->fetch(PDO::FETCH_ASSOC)){
	   							
	  							//Criptografando parametros enviados via get
	  							$idmembro=base64_encode($dados['id_membro']);
	   							$nmmembro=base64_encode($nome);
	   							$idigreja=base64_encode($igreja);
	   							
	   							echo "<tr>
										<td>".$dados['nm_membro']."</td>
										<td>".$dados['nm_igreja']."</td>
										<td class='text-center'>
										<center><form action='../Membro/visualizar.php' method='get' target='_self'>
										<input type='text' style='display:none' id='id_membro' name='id_membro' value='".$idmembro."'>
	  									<input type='text' style='display:none' id='membro' name='membro' value='".$nmmembro."'>
										<input type='text' style='display:none' id='igreja' name='igreja' value='".$idigreja."'>
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
