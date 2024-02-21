<?php

include 'armazem.class.php';
require 'conexao.class.php';

interface IRepositorioArmazems{
	public function incluirArmazem($armazem);

}

class RepositorioArmazemsSQL implements IRepositorioArmazems
{
	private $conexao;

	public function __construct()
	{
		$this->conexao = new Conexao("localhost","locadora","alunolab","armazem");
		if ($this->conexao->conectar() == false) {
			echo "Erro" . mysqli_error();
		}
	}

	public function incluirArmazem($armazem){
	$nome = $armazem->getNome();
	$codigo = $armazem->getCodigo();

	$sql = "INSERT INTO armazem(
		nome,
		id,
		codigo)
		
		VALUES(
			'$nome',
			NULL,
			'codigo')";

		$this->conexao->executarQuery($sql);
	}

	public function buscarArmazem($codigo){
		$linha = $this->conexao->obterPrimeiroRegistroQuery("SELECT * FROM armazem WHERE codigo = '$codigo'");

		$armazem = new Armazem(
			$linha_armazem['nome'],
			$linha_armazem['codigo']);
		return$armazem;
	}

	public function getListarArmazem()
	{
		$listagem_armazem = $this->conexao->executarQuery("SELECT * FROM armazem");

		$arrayArmazem = array();

		while($linha_armazem = mysqli_fetch_array($listagem_armazem)){
			$armazem = new Armazem(
				$linha_armazem['nome'],
				$linha_armazem['id'],
				$linha_armazem['codigo']);

			array_push($arrayArmazem, $armazem);
		}
		return $arrayArmazem;
	}

}

$repositorio = new RepositorioArmazemsSQL();

?>