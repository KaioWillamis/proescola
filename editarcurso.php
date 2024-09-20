<?php
include "sessao.php";

function buscarCursos() {
    if (file_exists('json/cursos.json')) {
        return json_decode(file_get_contents('json/cursos.json'), true);
    }
    return [];
}

// Função para verificar se já existe um curso com o nome informado
function cursoNomeJaExiste($novoNome, $nomeAntigo) {
    $cursos = buscarCursos();
    foreach ($cursos as $curso) {
        // Verifica se o nome já existe e é diferente do nome antigo
        if ($curso['nome'] === $novoNome && $curso['nome'] !== $nomeAntigo) {
            return true;
        }
    }
    return false;
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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Curso</title>
    <link rel="shortcut icon" href="img/school.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/editar.css">
</head>
<body>
    <main>
        <div>
            <h1>Editar Curso</h1>
            <form method="POST" action="">
                <input type="hidden" name="nomeAntigo" value="<?php echo htmlspecialchars($cursoAtual['nome']); ?>">
                Nome Atual: <br> <input type="text" value="<?php echo htmlspecialchars($cursoAtual['nome']); ?>" readonly> <br>
                Novo Nome: <br> <input type="text" name="novoNome" value="<?php echo htmlspecialchars($cursoAtual['nome']); ?>" required> <br>
                Nova Duração: <br> <input type="text" name="novaDuracao" value="<?php echo htmlspecialchars($cursoAtual['duracao']); ?>" required> <br>
                <input type="submit" name="atualizar" value="Atualizar Curso" class="inputsalvar"> <br>
                <button type="button" onclick="window.location.href='curso.php'">Voltar</button>
            </form>

<?php
            if (isset($_POST['atualizar'])) {
    $nomeAntigo = $_POST['nomeAntigo'];
    $novoNome = $_POST['novoNome'];
    $novaDuracao = $_POST['novaDuracao'];

    // Verifica se o novo nome já existe para outro curso
    if (cursoNomeJaExiste($novoNome, $nomeAntigo)) {
        ?>
        <div class="mensagem">
        <?php
        echo "Já existe um curso com esse nome.";
        ?>
        </div>
        <?php
    } else {
        atualizarCurso($nomeAntigo, $novoNome, $novaDuracao);
        header("Location: cursos.php");
        exit();
    }
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

        </div>
    </main>
</body>
</html>
