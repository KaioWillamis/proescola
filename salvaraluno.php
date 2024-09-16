<?php
include "class/classaluno.php";
include "sessao.php";

if(isset($_POST['nome']) && ($_POST['nome']) !="" && isset($_POST['telefone']) && ($_POST['telefone']) !="" && isset($_POST['cpf']) && ($_POST['cpf']) !=""){
    
    $_SESSION['admi'] = $admi;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];

    $aluno = new ALuno($_POST['nome'],$_POST['telefone'],$_POST['cpf']);

    
    // Caminho do arquivo JSON
    $arquivoJson = 'json/alunos.json';
    $dadosExistentes = [];

    // Verifica se o arquivo JSON já existe
    if (file_exists($arquivoJson)) {
        $dadosJson = file_get_contents($arquivoJson); //Lê o conteúdo do arquivo JSON
        $dadosExistentes = json_decode($dadosJson, true); //Decodifica o JSON para um array PHP
    }

    // Verifica se o aluno já existe no arquivo JSON
    $alunoExistente = false; // Inicializa uma flag para verificar se o aluno já existe
    foreach ($dadosExistentes as $registro) {
        if ($registro['nome'] == $nome && $registro['telefone'] == $telefone && $registro['cpf'] == $cpf) {
            $alunoExistente = true; //Define a flag como verdadeira se o aluno for encontrado
            break;
        }
    }

    if ($alunoExistente) {
        echo "O aluno já está cadastrado.";
    } else {
        // Adiciona o novo aluno ao array
        $novoAluno = array(
            'nome' => $nome,
            'telefone' => $telefone,
            'cpf' => $cpf,
            'id' => $aluno->getId()
        );
        
    $dadosExistentes[] = $novoAluno;

    // Salva os dados atualizados no arquivo JSON
    file_put_contents($arquivoJson, json_encode($dadosExistentes, JSON_PRETTY_PRINT));

    header("Location: alunos.php");
    exit();
    }
}
else {
echo "Método de requisição inválido!";
}
?>