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
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Vers�o 3.3.6 -->
    <script src='../bootstrap/js/jquery.min.js'></script><!-- Vers�o 1.11.1 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Vers�o 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Vers�o 1.4.1 -->		
        <title>Gest�o Crista</title>
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
	  						if (isset($_REQUEST['tpmov'])){ 
	  							$tpmovimento=$_REQUEST['tpmov'];
	  						}else{	
	  							if (isset($_REQUEST['p4'])){
	  								$tpmovimento=$_REQUEST['p4'];
	  							}else{
	  								$tpmovimento=null;
	  							}
	  						}
	  						
	  						if (isset($_REQUEST['igreja'])){
	  							$igreja=$_REQUEST['igreja'];
	  						}else{
	  							$igreja=$_REQUEST['p1'];
	  						}
	  						
	  						if (isset($_REQUEST['dtmovinicio'])){
	  							$dti=$_REQUEST['dtmovinicio'];
	  						}else {
	  							$dti=$_REQUEST['p2'];
	  						}
	  						
	  						if (isset($_REQUEST['dtmovfim'])){
	  							$dtf=$_REQUEST['dtmovfim'];
	  						}else{
	  							$dtf=$_REQUEST['p3'];
	  						}
	  						//substr("abcdef", -3, 1);// retorna "d"
	  						//11/11/1111
	  						/* $datainicio['a'] = substr($dti, -4);
	  						$datainicio['m'] = substr($dti, -7,2);
	  						$datainicio['d'] = substr($dti, -10,2); */
	  						
	  						
	  						
	  						
	  						
	  						/* $datafim['a'] = substr($dti, -4);
	  						$datafim['m'] = substr($dti, -7,2);
	  						$datafim['d'] = substr($dti, -10,2); */
	  						
	  						//var_dump ($datafim);
	  						
	  						$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
	  						
	  						$sqli = "select igj.nm_igreja, igj.id_igreja
	  						from igreja igj where igj.id_igreja='{$igreja}'";
	  						
	  						$stmi = $pdo->query($sqli);
	  						
	  						/* DATE_FORMAT( mov.dt_movimento, '%d/%m/%Y' ) */
	  						
	  						$sql = "select mov.id_movimento, DATE_FORMAT( mov.dt_movimento, '%d/%m/%Y' ) as data_movimento,
	  								DATE_FORMAT( mov.dt_reg_movimento, '%d/%m/%Y' ) as dt_reg_movimento,
    								mov.vl_movimento, tpm.ds_tipo_movimento, igj.nm_igreja
	  								from movimento mov left join tipo_movimento tpm 
    								on mov.id_tipo_movimento=tpm.id_tipo_movimento
    								inner join igreja igj on mov.id_igreja=igj.id_igreja
    								where mov.id_igreja ='{$igreja}' and mov.dt_movimento >= STR_TO_DATE('".$dti."','%d/%m/%Y')
	  								and mov.dt_movimento <= STR_TO_DATE('".$dtf."','%d/%m/%Y')";
	  						
	  						if ($tpmovimento!=null){
	  							$sql=$sql." and tpm.id_tipo_movimento ='{$tpmovimento}')";
	  						}
	  							
	  						$sql=$sql." order by dt_movimento";
	  								
	  						$stm = $pdo->query($sql);
	  						
	  						
	  						//var_dump($stm);
	  						if ($stm->rowCount(PDO::FETCH_ASSOC)>=1) {
	  							 $info = $stmi->fetch(PDO::FETCH_ASSOC);
	  							echo "	<tr>
	  										<td colspan='4'><strong>Igreja: ".$info['nm_igreja']."</strong></td>
	  									</tr>
	  									<tr>
										<td class='col-sm-3'><strong>Data do Movimento</strong></td>
										<td class='col-sm-3'><strong>Data de Registro</strong></td>
	  									<td class='col-sm-3'><strong>Tipo Movimento</strong></td>
		  									
										<td class='col-sm-1'/>
										</tr>";
	  						
	  							  						
		  						while($infomv = $stm->fetch(PDO::FETCH_ASSOC)){
		   							
		  							//$dti=;
		  							
		  							/* $dtmov['a'] = substr($infomv['dt_movimento'], -4);
		  							$dtmov['m'] = substr($infomv['dt_movimento'], -7,2);
		  							$dtmov['d'] = substr($infomv['dt_movimento'], -10,2);
		  							var_dump ($infomv['dt_movimento']); */
		  							
		  							/* if (($datainicio['a']<=$dtmov['a'] && $datafim['a']>=$dtmov['a']) && 
		  								($datainicio['m']<=$dtmov['m'] && $datafim['m']>=$dtmov['m']) && 
		  								($datainicio['d']<=$dtmov['d'] && $datafim['d']>=$dtmov['d'])) { */
		  									
		  									echo "<tr>
													<td>".$infomv['data_movimento']."</td>
													<td>".$infomv['dt_reg_movimento']."</td>
	  												<td>".$infomv['ds_tipo_movimento']."</td>
													<td class='text-center'>
													<form action='../Movimento/visualizar.php' method='get' target='_self'>
													<input type='text' style='display:none' id='id_mov' name='id_mov' value='".$infomv['id_movimento']."'>
		  											<input type='text' style='display:none' id='igreja' name='igreja' value='".$igreja."'>
	  												<input type='text' style='display:none' id='dtmovinicio' name='dtmovinicio' value='".$dti."'>
	  												<input type='text' style='display:none' id='dtmovfim' name='dtmovfim' value='".$dtf."'>
													<input type='text' style='display:none' id='tpmovimento' name='tpmovimento' value='".$tpmovimento."'>
													<button type='submit' class='btn btn-default col-sm-offset-1 btn-xs btn-acao' name='acao' value='visualizar'>Visualizar</button>
													</form></td>
											</tr>";
		  									
		  								
		  						}

	  						}else{
	  							echo "	<div class='alert alert-info'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>�</span></button>
	  									Registro n�o encontrado.
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
