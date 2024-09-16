<?php
include "sessao.php";

// Função para buscar matrículas
function buscarMatriculas($termo = "") {
    if (file_exists('json/matricula.json')) {
        $matriculas = json_decode(file_get_contents('json/matricula.json'), true);
        
        // Filtrar as matrículas conforme o termo de pesquisa
        if ($termo) {
            $matriculas = array_filter($matriculas, function($matricula) use ($termo) {
                return stripos($matricula['idAluno'], $termo) !== false;
            });
        }

        // Ordenar as matrículas por nome do aluno (ordem alfabética)
        $alunos = json_decode(file_get_contents('json/alunos.json'), true);
        usort($matriculas, function($a, $b) use ($alunos) {
            $nomeA = '';
            $nomeB = '';
            foreach ($alunos as $aluno) {
                if ($aluno['id'] == $a['idAluno']) {
                    $nomeA = $aluno['nome'];
                }
                if ($aluno['id'] == $b['idAluno']) {
                    $nomeB = $aluno['nome'];
                }
            }
            return strcmp($nomeA, $nomeB);
        });

        return $matriculas;
    }
    return [];
}

// Função para excluir uma matrícula
function excluirMatricula($numeroMatricula) {
    // Carregar as matrículas existentes
    $matriculas = json_decode(file_get_contents('json/matricula.json'), true);
    $matriculasAtualizadas = array_filter($matriculas, function($matricula) use ($numeroMatricula) {
        return $matricula['numeroMatricula'] !== $numeroMatricula;
    });
    file_put_contents('json/matricula.json', json_encode(array_values($matriculasAtualizadas), JSON_PRETTY_PRINT));

    // Atualizar o arquivo do aluno
    $alunos = json_decode(file_get_contents('json/alunos.json'), true);
    foreach ($alunos as &$aluno) {
        if (isset($aluno['numeros_matriculas'])) {
            $aluno['numeros_matriculas'] = array_filter($aluno['numeros_matriculas'], function($matricula) use ($numeroMatricula) {
                return $matricula !== $numeroMatricula;
            });
            // Remover o curso se a lista de matrículas ficar vazia
            if (empty($aluno['numeros_matriculas'])) {
                unset($aluno['curso']);
                unset($aluno['numeros_matriculas']);
            }
        }
    }
    file_put_contents('json/alunos.json', json_encode($alunos, JSON_PRETTY_PRINT));

    // Atualizar o arquivo dos cursos
    $cursos = json_decode(file_get_contents('json/cursos.json'), true);
    foreach ($cursos as &$curso) {
        if (isset($curso['alunos'])) {
            $curso['alunos'] = array_filter($curso['alunos'], function($idAluno) use ($numeroMatricula) {
                // Buscar todas as matrículas do aluno
                $matriculas = json_decode(file_get_contents('json/matricula.json'), true);
                foreach ($matriculas as $matricula) {
                    if ($matricula['idAluno'] == $idAluno && $matricula['numeroMatricula'] == $numeroMatricula) {
                        return false; // Remove o ID do aluno da lista do curso
                    }
                }
                return true;
            });
        }
    }
    file_put_contents('json/cursos.json', json_encode($cursos, JSON_PRETTY_PRINT));
}

// Verificar se há uma matrícula para excluir
if (isset($_GET['excluir'])) {
    excluirMatricula($_GET['excluir']);
    header("Location: matricula.php"); // Redirecionar após exclusão
    exit();
}

// Busca de matrículas com base no termo de pesquisa
$termoPesquisa = isset($_POST['nome']) ? $_POST['nome'] : "";
$matriculas = buscarMatriculas($termoPesquisa);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrículas</title>
    <style>
        .matricula {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .lista-matriculas {
            max-height: 400px; /* Defina a altura máxima conforme necessário */
            overflow-y: auto; /* Adiciona a barra de rolagem vertical */
            border: 1px solid #ddd;
            padding: 10px;
        }
    </style>
</head>
<body>
    <main>
        <div>
            <form method="POST">
                Nome do aluno: <input type="text" name="nome" value="<?php echo htmlspecialchars($termoPesquisa); ?>">
                <input type="submit" value="Pesquisar">
            </form>
            <button onclick="window.location.href='cadastrarmatricula.php'">Cadastrar</button>
            <button onclick="window.location.href='principal.php'">Voltar</button>
        </div>

        <div class="lista-matriculas">
            <!-- Div onde a lista de matrículas será exibida -->
            <?php if (!empty($matriculas)): ?>
                <!-- Se houver matrículas no array $matriculas, exibe cada uma delas -->
                <?php foreach ($matriculas as $matricula): ?>
                    <div class="matricula">
                        <p><strong>Número da Matrícula:</strong> <?php echo htmlspecialchars($matricula['numeroMatricula']); ?></p>
                        <?php
                        // Buscar nome do aluno
                        $alunos = json_decode(file_get_contents('json/alunos.json'), true);
                        $nomeAluno = '';
                        foreach ($alunos as $aluno) {
                            if ($aluno['id'] == $matricula['idAluno']) {
                                $nomeAluno = $aluno['nome'];
                                break;
                            }
                        }
                        ?>
                        <p><strong>Nome do Aluno:</strong> <?php echo htmlspecialchars($nomeAluno); ?></p>
                        <a href="?excluir=<?php echo htmlspecialchars($matricula['numeroMatricula']); ?>" onclick="return confirm('Tem certeza que deseja excluir esta matrícula?');">Excluir Matrícula</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhuma matrícula encontrada.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>