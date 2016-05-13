<?php

	define('MPDF_PATH', '../Biblioteca/PDF/');
	include(MPDF_PATH.'mpdf.php');
  	
	$id_membro=$_REQUEST['id'];
	
	 
	//Removendo criptografia
	$id_membro=base64_decode($id_membro);
	
	//Monta pesquisa de igreja
	$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "select mem.*, igj.NM_IGREJA, igj.NM_CIDADE, reg.ds_regiao, crg.ds_cargo
				from membro mem left join igreja igj
				on igj.id_igreja=mem.id_igreja
				left join regiao reg 
				on reg.id_regiao=igj.id_regiao
				left join cargo crg on crg.id_cargo=mem.id_cargo
				where mem.id_membro = {$id_membro}";
	
	$stm = $pdo->query($sql);
	
	$dados = $stm->fetch(PDO::FETCH_ASSOC);
	
	switch ($dados['cd_estado_civil']) {
	
		case "1":{
			$civil="Casado";
		}break;
		 
		case "2":{
			$civil="Divorciado";
		}break;
		 
		case "3":{
			$civil="Solteiro";
		}break;
		 
		case "4":{
			$civil="União Estável";
		}break;
		 
		case "5":{
			$civil="Viúvo";
		}break;
		 
		default:{
			$civil="";
		}
	}
	
	switch ($dados['cd_escolaridade']) {
	
		case "1":{
			$escolar="Fundamental";
		}break;
	
		case "2":{
			$escolar="Médio";
		}break;
	
		case "3":{
			$escolar="Superior";
		}break;
		 
		default:{
			$escolar="";
		}
		 
	}
	
	if ($dados['cd_sexo']==1){
		$sexo="Feminino";
	}else{
		$sexo="Masculino";
	}
	
	$nr_rol="<strong>Nr de ROL: </strong>".$dados['id_membro']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Nr Local: </strong>".$dados['nr_local'];
	$nmiIgreja="<strong>Nome da Igreja: </strong>".$dados['NM_IGREJA'];
	$nmregiao="<strong>Região: </strong>".$dados['ds_regiao'];
	$nmcidade="<strong>Cidade: </strong>".$dados['NM_CIDADE'];
	$nmmembro="<strong>Nome do Membro: </strong>".$dados['nm_membro'];
	$dscargo="<strong>Cargo: </strong>".$dados['ds_cargo'];
	$dtMembrecia="<strong>Data de Membrecia: </strong>".$dados['dt_membrecia'];
	$nrRg="<strong>Nr de RG: </strong>".$dados['nr_rg']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Nr do CPF: </strong>".$dados['nr_cpf'];
	$dtNascimento="<strong>Data de Nascimento: </strong>".$dados['dt_nascimento']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Sexo: </strong>".$sexo;
	$escolaridade="<strong>Escolaridade: </strong>".$escolar."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Estado Civíl: </strong>".$civil;
	$endereco="<strong>Endereço: </strong>".$dados['ds_endereco'];
	$nrtelefone="<strong>Nr de Telefone: </strong>".$dados['nr_telefone']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>E-mail: </strong>".$dados['ds_email'];
	$nmpai="<strong>Nome do Pai: </strong>".$dados['nm_pai'];
	$nmmae="<strong>Nome da Mãe: </strong>".$dados['nm_mae'];
	$nmConjugue="<strong>Nome do Conjugue: </strong>".$dados['nm_conjugue'];
	$nrfilhas="<strong>Quantidade de Filhos: </strong>".$dados['nr_filhos_mulheres']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Quantidade de Filhas: </strong>".$dados['nr_filhos_homens'];
	$ministro="<strong>Ministro: </strong>".$dados['nm_ministro'];
	$dtbates="<strong>Bat. E. S.: </strong>".$dados['dt_bat_es']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Lugar: </strong>".$dados['ds_lugar_es'];
	$nmantigomin="<strong>Nome: </strong>".$dados['nm_antigo_minist'];
	$cargoantigomin="<strong>Cargo: </strong>".$dados['ds_cargo_antigo_min'];
	
	$pastorantigomin="<strong>Pastor: </strong>".$dados['nm_pastor'];
	$historicoantigomin=$dados['ds_historico'];
	
	//Tratando data de conversão
	if ($dados['dt_conversao']<>''){
		$dtconversao="<strong>Conversão: </strong>".$dados['dt_conversao']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Lugar: </strong>".$dados['ds_lugar_conversao'];
	}else{
		$dtconversao="<strong>Conversão: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;<strong>Lugar: </strong>".$dados['ds_lugar_conversao'];
	}
	//Tratando data de batismo das aguas
	if ($dados['dt_bat_aguas']<>''){
		$dtbatismoaguas="<strong>Bat. Águas: </strong>".$dados['dt_bat_aguas']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Lugar: </strong>".$dados['ds_lugar_aguas'];
	}else{
		$dtbatismoaguas="<strong>Bat. Águas: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;<strong>Lugar: </strong>".$dados['ds_lugar_aguas'];
	}
	//Tratando data de batismo E.S.
	if ($dados['dt_bat_es']<>''){
		$dtbates="<strong>Bat. E. S.: </strong>".$dados['dt_bat_es']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Lugar: </strong>".$dados['ds_lugar_es'];
	}else{
		$dtbates="<strong>Bat. E. S.: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;<strong>Lugar: </strong>".$dados['ds_lugar_es'];
	}
	
	//Tratando data de membreceia do antigo ministério
	if ($dados['dt_membrecia_antigo']<>''){
		$dtantigomin="<strong>Data da Membrecia: </strong>".$dados['dt_membrecia_antigo']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Lugar: </strong>".$dados['ds_lugar_antigo_minist'];
	}else{
		$dtantigomin="<strong>Data da Membrecia: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;<strong>Lugar: </strong>".$dados['ds_lugar_antigo_minist'];
	}
	
  	$mpdf=new mPDF();
  	$mpdf->charset_in='iso-8859-1';
  	$mpdf->WriteHTML("<img src='../Biblioteca/Imagens/timbre.png' />");
  	$mpdf->WriteHTML('<h3 align=center>FICHA DE MEMBRO</h3>');
  	$mpdf->WriteHTML($nr_rol);
  	$mpdf->WriteHTML($nmiIgreja);
  	$mpdf->WriteHTML($nmregiao);
  	$mpdf->WriteHTML($nmcidade);
  	$mpdf->WriteHTML($dscargo);
  	$mpdf->WriteHTML('<h4 align=center>DADOS PESSOAIS</h4>');
  	$mpdf->WriteHTML($nmmembro);
  	$mpdf->WriteHTML($endereco);
  	$mpdf->WriteHTML("<strong>Filiação: </strong> ".$nmmae);
  	$mpdf->WriteHTML("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nmpai);
  	$mpdf->WriteHTML($dtNascimento);
  	$mpdf->WriteHTML($nrtelefone);
  	$mpdf->WriteHTML($nrRg);
  	$mpdf->WriteHTML($escolaridade);
  	$mpdf->WriteHTML($nmConjugue);
  	$mpdf->WriteHTML($nrfilhas);
  	$mpdf->WriteHTML('<h4 align=center>DADOS RELIGIOSOS</h4>');
  	$mpdf->WriteHTML($dtconversao);
  	$mpdf->WriteHTML($dtbatismoaguas);
  	$mpdf->WriteHTML($ministro);
  	$mpdf->WriteHTML($dtbates);
  	$mpdf->WriteHTML('<h4 align=center>DADOS ANTIGO MINISTÉRIO</h4>');
  	$mpdf->WriteHTML($nmantigomin);
  	$mpdf->WriteHTML($cargoantigomin);
  	$mpdf->WriteHTML($dtantigomin);
  	$mpdf->WriteHTML($pastorantigomin);
  	$mpdf->WriteHTML('<h4 align=center>HISTÓRICO</h4>');
  	$mpdf->WriteHTML($historicoantigomin."<br><br><br><br>");
  	$mpdf->WriteHTML('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>_________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________</strong>');
  	$mpdf->WriteHTML('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ass. do Membro &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Secretário/Tesoureiro');
  	$mpdf->SetFooter("<p align='center' color='#FE2E2E'><b>Revesti-vos de toda armadura de Deus, para poderes ficar firmes contra as ciladas do diabo</b></p><p align='center'>SEDE PROPRIA: QD 540 LOTE 03 PEDREGAL-NOVO GAMA</p><p align='center'>CNPJ: 15.586.863/0001-60</p>");
  	$mpdf->Output();
  	exit(); 
?>