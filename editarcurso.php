<?php
include "sessao.php";

function buscarCursos() {
    if (file_exists('json/cursos.json')) {
        return json_decode(file_get_contents('json/cursos.json'), true);
    }
    return [];
}

if (isset($_GET['nome'])) {
    $nomeCurso = $_GET['nome'];
    $cursos = buscarCursos();
    $cursoAtual = null;
    
    foreach ($cursos as $curso) {
        if ($curso['nome'] === $nomeCurso) {
            $cursoAtual = $curso;
            break;
        }
    }
    
    if (!$cursoAtual) {
        echo "Curso não encontrado.";
        exit();
    }
}

if (isset($_POST['atualizar'])) {
    $nomeAntigo = $_POST['nomeAntigo'];
    $novoNome = $_POST['novoNome'];
    $novaDuracao = $_POST['novaDuracao'];
    
    atualizarCurso($nomeAntigo, $novoNome, $novaDuracao);
    header("Location: cursos.php");
    exit();
}

function atualizarCurso($nomeCursoAntigo, $novoNome, $novaDuracao) {
    $cursos = json_decode(file_get_contents('json/cursos.json'), true);
    $alunos = json_decode(file_get_contents('json/alunos.json'), true);

    foreach ($cursos as &$curso) {
        if ($curso['nome'] === $nomeCursoAntigo) {
            $curso['nome'] = $novoNome;
            $curso['duracao'] = $novaDuracao;
        }
    }

    foreach ($alunos as &$aluno) {
        if ($aluno['curso'] === $nomeCursoAntigo) {
            $aluno['curso'] = $novoNome;
        }
    }

    file_put_contents('json/cursos.json', json_encode($cursos, JSON_PRETTY_PRINT));
    file_put_contents('json/alunos.json', json_encode($alunos, JSON_PRETTY_PRINT));

    header("Location: curso.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Curso</title>
</head>
<body>
    <main>
        <form method="POST" action="">
            <input type="hidden" name="nomeAntigo" value="<?php echo htmlspecialchars($cursoAtual['nome']); ?>">
            Nome Atual: <input type="text" value="<?php echo htmlspecialchars($cursoAtual['nome']); ?>" readonly>
            Novo Nome: <input type="text" name="novoNome" value="<?php echo htmlspecialchars($cursoAtual['nome']); ?>" required>
            Nova Duração: <input type="text" name="novaDuracao" value="<?php echo htmlspecialchars($cursoAtual['duracao']); ?>" required>
            <input type="submit" name="atualizar" value="Atualizar Curso">
        </form>
        <button onclick="window.location.href='cursos.php'">Voltar</button>
    </main>
</body>
</html>
