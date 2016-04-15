<?php
header('Content-Type: text/html; charset=ISO-8859-1', true);
session_start();
require_once 'membro.php';
require_once 'crudMembro.php';
//require_once 'sessao.php';

switch($_REQUEST['acao']) {

	case 'salvar': {

		# Uso do singleton para instanciar
		# apenas um objeto de autenticação
		# e esconder a classe real de autenticação
		$aut = CrudMembro::instanciar();

		# efetua o processo de autenticação
		if ($aut->salvar($_REQUEST['nrlocal'],$_REQUEST['igreja'], 
						$_REQUEST['cargo'],$_REQUEST['dtmembrecia'], $_REQUEST['membro'],
						$_REQUEST['rg'],$_REQUEST['cpf'],$_REQUEST['escolaridade'],
						$_REQUEST['dtnascimento'],$_REQUEST['sexo'],$_REQUEST['civil'],
						$_REQUEST['endereco'],$_REQUEST['email'],$_REQUEST['telefone'],
						$_REQUEST['pai'],$_REQUEST['mae'],$_REQUEST['conjugue'],
						$_REQUEST['homens'],$_REQUEST['mulher'],$_REQUEST['conversao'],
						$_REQUEST['lugarconv'],$_REQUEST['bataguas'],$_REQUEST['lugarbat'],
						$_REQUEST['ministro'],$_REQUEST['bates'],$_REQUEST['lugares'],
						$_REQUEST['nomemin'],$_REQUEST['cargoant'],$_REQUEST['datamemant'],
						$_REQUEST['lugarant'],$_REQUEST['pastor'],$_REQUEST['historico'])) {
			
			
							
							
			# redireciona o usuário para dentro do sistema
			header('location: /GestaoCrista/Membro/pesquisa.php?resultado=1');
		}
		else {
			# envia o usuário de volta para
			# o form de login
			header('location: /GestaoCrista/Membro/cadastro.php?resultado=erro');
		}

	} break;

	case 'sair': {

		# envia o usuário para fora do sistema
		# o form de login
		header('location: /GestaoCrista/index.php');

	} break;
	
	case 'excluir': {

		# Uso do singleton para instanciar
		# apenas um objeto de autenticação
		# e esconder a classe real de autenticação
		$aut = CrudMembro::instanciar();

		# efetua o processo de autenticação
		//if()
		//var_dump("entrou aqui");
			if ($aut->excluir($_REQUEST['id_membro'])) {
				# redireciona o usuário para dentro do sistema
				header('location: /GestaoCrista/Membro/pesquisa.php?resultado=2');
				
			}
			else {
				# envia o usuário de volta para
				# o form de login
				header('location: /GestaoCrista/Membro/pesquisa.php');
			}	
	
	} break;

	
	case 'alterar': {
	
		# Uso do singleton para instanciar
		# apenas um objeto de autenticação
		# e esconder a classe real de autenticação
		$aut = CrudMembro::instanciar();
	
		# efetua o processo de autenticação
		//if()
		//var_dump("entrou aqui");
		if ($aut->alterar($_REQUEST['idmembro'],$_REQUEST['nrlocal'],$_REQUEST['igreja'], 
						$_REQUEST['cargo'],$_REQUEST['dtmembrecia'], $_REQUEST['membro'],
						$_REQUEST['rg'],$_REQUEST['cpf'],$_REQUEST['escolaridade'],
						$_REQUEST['dtnascimento'],$_REQUEST['sexo'],$_REQUEST['civil'],
						$_REQUEST['endereco'],$_REQUEST['email'],$_REQUEST['telefone'],
						$_REQUEST['pai'],$_REQUEST['mae'],$_REQUEST['conjugue'],
						$_REQUEST['homens'],$_REQUEST['mulher'],$_REQUEST['conversao'],
						$_REQUEST['lugarconv'],$_REQUEST['bataguas'],$_REQUEST['lugarbat'],
						$_REQUEST['ministro'],$_REQUEST['bates'],$_REQUEST['lugares'],
						$_REQUEST['nomemin'],$_REQUEST['cargoant'],$_REQUEST['datamemant'],
						$_REQUEST['lugarant'],$_REQUEST['pastor'],$_REQUEST['historico'])) {
			# redireciona o usuário para dentro do sistema
			header('location: /GestaoCrista/Membro/pesquisa.php?resultado=3');
			//var_export($_REQUEST['id_igreja']);
		}
		else {
			# envia o usuário de volta para
			# o form de login
			header('location: /GestaoCrista/Membro/pesquisa.php');
		}
	
	}break;	

	case 'svperfil': {
	
		# Uso do singleton para instanciar
		# apenas um objeto de autenticação
		# e esconder a classe real de autenticação
		$aut = CrudMembro::instanciar();
	
		# efetua o processo de autenticação
		//if()
		//var_dump("entrou aqui");
		if ($aut->svperfil($_REQUEST['id_membro'], $_REQUEST['loginmembro'], $_REQUEST['senhamembro'], $_REQUEST['perfilmembro'])) {
			# redireciona o usuário para dentro do sistema
			header('location: /GestaoCrista/Membro/pesquisa.php?resultado=3');
	
		}
		else {
			# envia o usuário de volta para
			# o form de login
			header('location: /GestaoCrista/Membro/pesquisa.php');
		}
	
	} break;
	
	case 'experfil': {
	
		# Uso do singleton para instanciar
		# apenas um objeto de autenticação
		# e esconder a classe real de autenticação
		$aut = CrudMembro::instanciar();
	
		# efetua o processo de autenticação
		//if()
		//var_dump("entrou aqui");
		if ($aut->experfil($_REQUEST['id_membro'])) {
			# redireciona o usuário para dentro do sistema
			header('location: /GestaoCrista/Membro/pesquisa.php?resultado=3');
	
		}
		else {
			# envia o usuário de volta para
			# o form de login
			header('location: /GestaoCrista/Membro/pesquisa.php');
		}
	
	} break;
	
	case 'svhist': {
	
		# Uso do singleton para instanciar
		# apenas um objeto de autenticação
		# e esconder a classe real de autenticação
		$aut = CrudMembro::instanciar();
	
		# efetua o processo de autenticação
		//if()
		//var_dump("entrou aqui");
		if ($aut->svhist($_REQUEST['id_membro'], $_REQUEST['dt_historico'], $_REQUEST['ds_historico'])) {
			$idmembro=base64_encode($_REQUEST['id_membro']);
			# redireciona o usuário para dentro do sistema
			header('location: /GestaoCrista/Membro/visualizar.php?id_membro='.$idmembro);
	
		}
		else {
			# envia o usuário de volta para
			# o form de login
			header('location: /GestaoCrista/Membro/visualizar.php?res=err');
		}
	
	} break;
	
	case 'exhist': {
	
		# Uso do singleton para instanciar
		# apenas um objeto de autenticação
		# e esconder a classe real de autenticação
		$aut = CrudMembro::instanciar();
	
		# efetua o processo de autenticação
		//if()
		//var_dump("entrou aqui");
		if ($aut->exhist($_REQUEST['idhist'])) {
			$idmembro=base64_encode($_REQUEST['id_membro']);
			# redireciona o usuário para dentro do sistema
			header('location: /GestaoCrista/Membro/visualizar.php?id_membro='.$idmembro);
	
		}
		else {
			# envia o usuário de volta para
			# o form de login
			header('location: /GestaoCrista/Membro/visualizar.php?res=err');
		}
	
	} break;
}
	
?>
