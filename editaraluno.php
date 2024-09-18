<?php
include "sessao.php";

// Função para buscar aluno pelo ID
function buscarAlunoPorId($idAluno) {
    if (file_exists('json/alunos.json')) {
        $alunos = json_decode(file_get_contents('json/alunos.json'), true);
        foreach ($alunos as $aluno) {
            if ($aluno['id'] === $idAluno) {
                return $aluno;
            }
        }
    }
    return null;
}

// Função para atualizar os dados do aluno no arquivo alunos.json
function atualizarAluno($idAluno, $novoNome, $novoTelefone, $novoCpf) {
    if (file_exists('json/alunos.json')) {
        $alunos = json_decode(file_get_contents('json/alunos.json'), true);

        // Atualizar os dados do aluno
        foreach ($alunos as &$aluno) {
            if ($aluno['id'] === $idAluno) {
                $aluno['nome'] = $novoNome;
                $aluno['telefone'] = $novoTelefone;
                $aluno['cpf'] = $novoCpf;
                break;
            }
        }

        // Salva o arquivo atualizado
        file_put_contents('json/alunos.json', json_encode($alunos, JSON_PRETTY_PRINT));

        // Atualiza o arquivo matriculas.json
        if (file_exists('json/matricula.json')) {
            $matriculas = json_decode(file_get_contents('json/matricula.json'), true);

            foreach ($matriculas as &$matricula) {
                if ($matricula['idAluno'] === $idAluno) {
                    $matricula['nome'] = $novoNome;
                }
            }
            file_put_contents('json/matricula.json', json_encode($matriculas, JSON_PRETTY_PRINT));
        }
        echo "Dados atualizados com sucesso.";
    }
}

$idAluno = isset($_GET['id']) ? $_GET['id'] : null;
$aluno = buscarAlunoPorId($idAluno);

if (!$aluno) {
    echo "Aluno não encontrado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualiza os dados do aluno
    $novoNome = $_POST['nome'];
    $novoTelefone = $_POST['telefone'];
    $novoCpf = $_POST['cpf'];
    atualizarAluno($idAluno, $novoNome, $novoTelefone, $novoCpf);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
    <link rel="shortcut icon" href="img/school.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/editar.css">
</head>
<body>
    <main>
        <div>
            <h1>Editar Aluno</h1>
            <form method="POST">
                Nome: <br> <input type="text" name="nome" value="<?php echo htmlspecialchars($aluno['nome']); ?>" required><br>
                Telefone: <br> <input type="text" name="telefone" value="<?php echo htmlspecialchars($aluno['telefone']); ?>" required><br>
                CPF: <br> <input type="text" name="cpf" value="<?php echo htmlspecialchars($aluno['cpf']); ?>" required><br>
                <input type="submit" value="Atualizar" class="inputsalvar"> <br>
                <button type="button" onclick="window.location.href='alunos.php'">Cancelar</button>
            </form>
        </div>
    </main>
</body>
</html>