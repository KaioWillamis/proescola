<?php
include "class/classaluno.php";
include "sessao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];

    if (strlen($cpf) < 14) { //strlen ler o comprimento da string 
        echo "Cpf incompleto ou faltou algum sinal! Siga o exemplo '000.000.000-00'";
        exit();
    }

    if(strlen($telefone) < 14){
        echo "Telefone incompleto! Siga o exemplo '(00) 00000-0000'";
        exit();
    }

    $aluno = new ALuno($_POST['nome'],$_POST['telefone'],$_POST['cpf']);

    $arquivoJson = 'json/alunos.json';
    $dadosExistentes = [];

    if (file_exists($arquivoJson)) {
        $dadosJson = file_get_contents($arquivoJson); //Lê o conteúdo do arquivo JSON
        $dadosExistentes = json_decode($dadosJson, true); 
    }

    $alunoExistente = false; 
    foreach ($dadosExistentes as $registro) {
        if ($registro['cpf'] == $cpf) {
            $alunoExistente = true;
            break;
        }
    }

    if ($alunoExistente) {
        echo "Já existe uma pessoa com esse CPF.";
    } else {
        $novoAluno = array(
            'nome' => $nome,
            'telefone' => $telefone,
            'cpf' => $cpf,
            'id' => $aluno->getId()
        );
        
    $dadosExistentes[] = $novoAluno;

    file_put_contents($arquivoJson, json_encode($dadosExistentes, JSON_PRETTY_PRINT));

    header("Location: alunos.php");
    exit();
    }
}
else {
echo "Método de requisição inválido!";
}
?>