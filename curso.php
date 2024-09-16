<?php
session_start();

if (!isset($_SESSION["admi"])) {
    // Se não existir uma sessão, redirecionar para a página de login
    header("Location: login.php");
    exit();
}

// Função para buscar cursos
function buscarCursos() {
    if (file_exists('json/cursos.json')) {
        return json_decode(file_get_contents('json/cursos.json'), true);
    }
    return [];
}

// Função para buscar alunos
function buscarAlunos() {
    if (file_exists('json/alunos.json')) {
        return json_decode(file_get_contents('json/alunos.json'), true);
    }
    return [];
}

// Função para excluir um curso
function excluirCurso($nomeCurso) {
    // Carregar os cursos existentes
    $cursos = json_decode(file_get_contents('json/cursos.json'), true);
    $cursosAtualizados = array_filter($cursos, function($curso) use ($nomeCurso) {
        return $curso['nome'] !== $nomeCurso;
    });

    // Verificar se o curso a ser excluído tem alunos matriculados
    $alunos = buscarAlunos();
    foreach ($alunos as $aluno) {
        if ($aluno['curso'] === $nomeCurso) {
            return false; // Curso não pode ser excluído porque tem alunos matriculados
        }
    }

    // Atualizar o arquivo de cursos se o curso puder ser excluído
    file_put_contents('json/cursos.json', json_encode(array_values($cursosAtualizados), JSON_PRETTY_PRINT));
    return true;
}

// Função para atualizar curso
function atualizarCurso($nomeCursoAntigo, $novoNome, $novaDuracao) {
    // Carregar os cursos existentes
    $cursos = json_decode(file_get_contents('json/cursos.json'), true);
    $alunos = buscarAlunos();

    // Atualizar informações do curso
    foreach ($cursos as &$curso) {
        if ($curso['nome'] === $nomeCursoAntigo) {
            $curso['nome'] = $novoNome;
            $curso['duracao'] = $novaDuracao;
        }
    }
    
    // Atualizar informações dos alunos
    foreach ($alunos as &$aluno) {
        if ($aluno['curso'] === $nomeCursoAntigo) {
            $aluno['curso'] = $novoNome;
        }
    }

    // Salvar atualizações
    file_put_contents('json/cursos.json', json_encode($cursos, JSON_PRETTY_PRINT));
    file_put_contents('json/alunos.json', json_encode($alunos, JSON_PRETTY_PRINT));
}

// Verificar se há um curso para excluir
if (isset($_GET['excluir'])) {
    $cursoExcluido = excluirCurso($_GET['excluir']);
    if ($cursoExcluido) {
        header("Location: cursos.php");
        exit();
    } else {
        echo "Não foi possível excluir o curso. Existem alunos matriculados.";
    }
    exit();
}

// Verificar se o curso deve ser atualizado
if (isset($_POST['atualizar'])) {
    atualizarCurso($_POST['nomeAntigo'], $_POST['novoNome'], $_POST['novaDuracao']);
    header("Location: cursos.php");
    exit();
}

// Buscar todos os cursos
$cursos = buscarCursos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
    <style>
        .lista-cursos {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .curso {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
        }

        .curso p {
            margin: 0;
        }

        .curso a {
            color: red;
            text-decoration: none;
        }

        .curso a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <main>
        <div>
            <form method="POST" action="">
                Nome: <input type="text" name="nome">
                <input type="submit" value="Pesquisar">
            </form>
            <button onclick="window.location.href='cadastrarcurso.php'">Cadastrar</button>
            <button onclick="window.location.href='principal.php'">Voltar</button>
        </div>
        <div class="lista-cursos">
            <!-- Div onde a lista de cursos será exibida -->
            <?php if (!empty($cursos)): ?>
                <!-- Se houver cursos no array $cursos, exibe cada um deles -->
                <?php foreach ($cursos as $curso): ?>
                    <div class="curso">
                        <p><strong>Nome do Curso:</strong> <?php echo htmlspecialchars($curso['nome']); ?></p>
                        <p><strong>Duração:</strong> <?php echo htmlspecialchars($curso['duracao']); ?> hora</p>
                        <a href="?excluir=<?php echo urlencode($curso['nome']); ?>">Excluir Curso</a>
                        <a href="editarcurso.php?nome=<?php echo urlencode($curso['nome']); ?>">Editar Curso</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum curso encontrado.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>