<?php
include "sessao.php";

// Função para buscar e ordenar alunos no JSON
function buscarAlunos($termo = "") {
    if (file_exists('json/alunos.json')) {
        $alunos = json_decode(file_get_contents('json/alunos.json'), true);
        
        // Filtrar os alunos conforme o termo de pesquisa
        if ($termo) {
            $alunos = array_filter($alunos, function($aluno) use ($termo) {
                return stripos($aluno['nome'], $termo) !== false;
            });
        }

        // Ordenar os alunos por nome (ordem alfabética)
        usort($alunos, function($a, $b) {
            return strcmp($a['nome'], $b['nome']);
        });

        return $alunos;
    }
    return [];
}

// Função para verificar se o aluno está matriculado em algum curso
function verificarMatriculaAluno($idAluno) {
    if (file_exists('json/matricula.json')) {
        $matriculas = json_decode(file_get_contents('json/matricula.json'), true);
        
        // Verifica se o aluno tem alguma matrícula registrada
        foreach ($matriculas as $matricula) {
            if ($matricula['idAluno'] === $idAluno) {
                return true; // O aluno está matriculado
            }
        }
    }
    return false; // O aluno não está matriculado
}

// Excluir aluno somente se não estiver matriculado
function excluirAluno($idAluno) {
    if (verificarMatriculaAluno($idAluno)) {
        echo "Não é possível excluir o aluno, pois ele está matriculado em algum curso.";
    } else {
        // Código para excluir o aluno
        if (file_exists('json/alunos.json')) {
            $alunos = json_decode(file_get_contents('json/alunos.json'), true);
            $alunos = array_filter($alunos, function($aluno) use ($idAluno) {
                return $aluno['id'] !== $idAluno;
            });
            file_put_contents('json/alunos.json', json_encode(array_values($alunos), JSON_PRETTY_PRINT));
            echo "Aluno excluído com sucesso.";
        }
    }
}

// Verifica se a exclusão foi solicitada
if (isset($_GET['excluir'])) {
    excluirAluno($_GET['excluir']);
}

// Busca de alunos com base no termo de pesquisa
$termoPesquisa = isset($_POST['nome']) ? $_POST['nome'] : "";
$alunos = buscarAlunos($termoPesquisa);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunos</title>

    <style>
        .lista-alunos {
            max-height: 200px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .aluno {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <main>
        <div>
            <form method="POST">
                Nome <input type="text" placeholder="Nome do aluno" name="nome">
                <input type="submit" value="Pesquisar">
            </form>
            <button onclick="window.location.href='cadastroaluno.php'">Cadastrar</button>
            <button onclick="window.location.href='principal.php'">Voltar</button>
        </div> 

        <div class="lista-alunos">
            <!-- Div onde a lista de alunos será exibida -->
            <?php if (!empty($alunos)): ?>
                <!-- Se houver alunos no array $alunos, exibe cada um deles -->
                <?php foreach ($alunos as $aluno){ ?>
                    <div class="aluno">
                        <!-- Exibe o nome e o ID do aluno -->
                        <p><strong>Nome:</strong> <?php echo htmlspecialchars($aluno['nome']); ?></p>
                        <p><strong>ID:</strong> <?php echo htmlspecialchars($aluno['id']); ?></p>

                        <div class="botoes">
                            <!-- Botão de Editar que redireciona para uma página de edição -->
                            <a href="editaraluno.php?id=<?php echo $aluno['id']; ?>">Editar</a>
                            <!-- Botão de Excluir -->
                            <a href="?excluir=<?php echo $aluno['id']; ?>">Excluir</a>
                        </div>
                    </div>
                <?php } ?>
            <?php else: ?>
                <p>Nenhum aluno encontrado.</p>
                <!-- Exibe esta mensagem se não houver alunos na lista -->
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
