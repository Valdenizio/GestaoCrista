<?php
abstract class Autenticador {

	private static $instancia = null;

	private function __construct() {}

	/**
	 *
	 * @return Autenticador
	 */
	public static function instanciar() {

		if (self::$instancia == NULL) {
			self::$instancia = new AutenticadorEmBanco();
		}

		return self::$instancia;

	}

	public abstract function logar($login, $senha);
	public abstract function esta_logado();
	public abstract function pegar_usuario();
	public abstract function expulsar();

}

class AutenticadorEmBanco extends Autenticador {

	public function esta_logado() {
		$sess = Sessao::instanciar();
		return $sess->existe('usuario');
	}

	public function expulsar() {
		header('location: controle.php?acao=sair');
	}

	public function logar($login, $senha) {
		//var_dump($senha);
		$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=utf8','root','');
		$sess = Sessao::instanciar();
		//var_dump($pdo);
		$sql = "select usu.ds_login, mem.id_igreja, usu.id_perfil
		from usuario usu left join membro mem
		on usu.id_membro=mem.id_membro
		where usu.ds_login ='{$login}' and
		usu.ds_senha = '{$senha}'";
		$stm = $pdo->query($sql);
		//var_dump($sql);
		//$count = rowCount($pdo);
		//var_dump($stm);
		if ($stm->rowCount() >= 1) {
			
			$dados = $stm->fetch(PDO::FETCH_ASSOC);
			$usuario = new Usuario();
			$usuario->setLogin($dados['login']);
			$usuario->setId($dados['id']);
			$usuario->setPerfil($dados['perfil']);
			//$usuario->setSenha($dados['senha']);
			$usuario->setIgreja($dados['igreja']);

			$sess->set('usuario', $dados);
			
			
			
			//var_dump($sess);
			return true;

		}
		else {
			return false;
		}
	}

	public function pegar_usuario() {
		$sess = Sessao::instanciar();
		
		if ($this->esta_logado()) {
			$usuario = $sess->get('usuario');
			//var_dump($usuario);
			return $usuario;
		}
		else {
			return false;
		}
	}

}
?>
