<?php
include "class/classmatricula.php";
include "sessao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idAluno = $_POST['aluno'];
    $idCurso = $_POST['curso'];
    $data = $_POST['data'];

    // Carregar os arquivos JSON de alunos e cursos
    $alunosData = json_decode(file_get_contents('json/alunos.json'), true);
    $cursosData = json_decode(file_get_contents('json/cursos.json'), true);

    // Verificar se o ID do aluno existe
    $alunoExiste = false;
    foreach ($alunosData as $aluno) {
        if ($aluno['id'] == $idAluno) {
            $alunoExiste = true;
            break;
        }
    }

    // Verificar se o curso existe (usando o nome como ID)
    $cursoExiste = false;
    foreach ($cursosData as $curso) {
        if ($curso['nome'] == $idCurso) {
            $cursoExiste = true;

            // Verificar se o aluno já está matriculado no curso
            if (isset($curso['alunos']) && in_array($idAluno, $curso['alunos'])) {
                echo "O aluno já está matriculado neste curso!";
                exit(); // Interrompe o processo caso o aluno já esteja matriculado
            }
            break;
        }
    }

    if ($alunoExiste && $cursoExiste) {
        // Verificar se a pasta "json" existe, se não, criar a pasta
        if (!is_dir('json')) {
            mkdir('json', 0777, true);
        }
        
        // Verificar se o arquivo "matricula.json" existe, se não, criar o arquivo com um array vazio
        if (!file_exists('json/matricula.json')) {
            file_put_contents('json/matricula.json', json_encode([]));
        }
        
        // Carregar as matrículas existentes
        $matriculasData = json_decode(file_get_contents('json/matricula.json'), true);
        if (!is_array($matriculasData)) {
            $matriculasData = [];
        }
        
        // Criar uma nova matrícula
        $matricula = new Matricula($idAluno, $idCurso, $data);
        
        // Adicionar a nova matrícula ao array
        $novaMatricula = [
            'idAluno' => $idAluno,
            'idCurso' => $idCurso,
            'data' => $data,
            'numeroMatricula' => $matricula->getNumero() // Usar o número gerado automaticamente
        ];
        $matriculasData[] = $novaMatricula;
    
        // Salvar as matrículas no arquivo
        file_put_contents('json/matricula.json', json_encode($matriculasData, JSON_PRETTY_PRINT));
        
        // Atualizar informações do aluno com o curso e número de matrículas
        foreach ($alunosData as &$aluno) {
            if ($aluno['id'] == $idAluno) {
                $aluno['curso'] = $idCurso;
        
                // Verificar se a chave 'numeros_matriculas' existe, se não, criar um array vazio
                if (!isset($aluno['numeros_matriculas'])) {
                    $aluno['numeros_matriculas'] = [];
                }
        
                // Adicionar o novo número de matrícula ao array
                $aluno['numeros_matriculas'][] = $matricula->getNumero();
        
                // Incrementar o número de matrículas
                if (!isset($aluno['numero_matriculas'])) {
                    $aluno['numero_matriculas'] = 0;
                }
                $aluno['numero_matriculas']++;
        
                break;
            }
        }
        
        file_put_contents('json/alunos.json', json_encode($alunosData, JSON_PRETTY_PRINT));
        
        // Adicionar o aluno na lista de alunos do curso
        foreach ($cursosData as &$curso) {
            if ($curso['nome'] == $idCurso) {
                if (!isset($curso['alunos'])) {
                    $curso['alunos'] = [];
                }
                $curso['alunos'][] = $idAluno; // Adiciona o ID do aluno ao curso
                break;
            }
        }
        file_put_contents('json/cursos.json', json_encode($cursosData, JSON_PRETTY_PRINT));
    
        header("Location: matricula.php");
        exit();
    } else {
        echo "ID do aluno ou curso inválido!";
    }
}
