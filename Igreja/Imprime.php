<?php

	define('MPDF_PATH', '../Biblioteca/PDF/');
	include(MPDF_PATH.'mpdf.php');
  	
	$idigreja=$_REQUEST['id'];
	
	 
	//Removendo criptografia
	//$id_igreja=base64_decode($idigreja);
	
	//Monta pesquisa de igreja
	$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
	$sql = "select igj.*, reg.ds_regiao
	from igreja igj left join regiao reg
	on igj.id_regiao=reg.id_regiao
	where igj.id_igreja = '{$idigreja}'";
	
	$stm = $pdo->query($sql);
	
	
	//$igrejabj = new Igreja();
	$dados = $stm->fetch(PDO::FETCH_ASSOC);
	 
	$nmiIgreja="<strong>Nome da Igreja: </strong>".$dados['NM_IGREJA'];
	$nmDirigente="<strong>Nome do Dirigente: </strong>".$dados['NM_DIRIGENTE'];
	$nmConjugue="<strong>Nome do Conjugue: </strong>".$dados['NM_CONJUGUE'];
	$endIgreja="<strong>Endereço da Igreja: </strong>".$dados['DS_ENDERECO'];
	if (isset($dados['ds_regiao'])){
		$nmRegiao="<strong>Regiao: </strong>".$dados['ds_regiao'];
		//var_dump($nmRegiao);
	}else{
		$nmRegiao="<strong>Regiao: </strong> Não cadastrada";
		//var_dump("não tem regiao");
	}
	$cdCEP="<strong>CEP: </strong>".$dados['CD_CEP'];
	$nmCidade="<strong>Cidade: </strong>".$dados['NM_CIDADE'];
	$telefone="<strong>Telefone: </strong>".$dados['NR_TELEFONE'];
	
	$dtInauguracao="<strong>Data de Inauguração: </strong>".$dados['DT_INAUGURACAO'];
	$banco="<strong>Banco: </strong>".$dados['NM_BANCO'];
	$agencia="<strong>Agência: </strong>".$dados['NR_AGENCIA'];
	$conta="<strong>Conta: </strong>".$dados['NR_CONTA'];
	$informacoes="<strong>Informações adicionais: </strong>";
	
  
  	$mpdf=new mPDF();
  	$mpdf->charset_in='windows-1252';
  	$mpdf->WriteHTML("<img src='../Biblioteca/Imagens/timbre.png' />");
  	$mpdf->WriteHTML('<h2 align=center>Dados da Igreja:</h2>');
  	$mpdf->WriteHTML($nmiIgreja);
  	$mpdf->WriteHTML($nmDirigente);
  	$mpdf->WriteHTML($nmConjugue);
  	$mpdf->WriteHTML($endIgreja);
  	$mpdf->WriteHTML($cdCEP);
  	$mpdf->WriteHTML($nmCidade);
  	$mpdf->WriteHTML($nmRegiao);
  	$mpdf->WriteHTML($telefone);
  	$mpdf->WriteHTML($dtInauguracao);
  	$mpdf->WriteHTML($banco);
  	$mpdf->WriteHTML($agencia);
  	$mpdf->WriteHTML($conta);
  	$mpdf->WriteHTML($informacoes);
  	$mpdf->WriteHTML($dados['DS_INFOMACOES']);
  	$mpdf->HTMLFooters("ttt<b color='#FE2E2E' align=center>Revesti-vos de toda armadura de Deus, para poderes ficar firmes contra as ciladas do diabo</b>");
  	//$mpdf->setHTMLFooters("<p align='center'>SEDE PRÓPRIA: QD 540 LOTE 03 PEDREGAL – NOVO GAMA</p>");
  	//$mpdf->setHTMLFooters("<p align='center'>CNPJ: 15.586.863/0001-60</p>");
  	$mpdf->Output();
  	exit(); 
?>