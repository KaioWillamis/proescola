<?php
class Curso{
    private $nome;
    private $duracao;
    private $quantidadealunos;
    private $alunos;

    private function getNome(){
        return $this->nome;
    }

    private function setNome($nome){
        $this->nome = $nome;
    }

    private function getDuracao(){
        return $this->duracao;
    }

    private function setDuracao($duracao){
        $this->duracao = $duracao;
    }

    private function getQuantidadeAlunos(){
        return $this->quantidadealunos;
    }

    private function setQuantidadedeAlunos($quantidade){
        $this->quantidadealunos = $quantidade;
    }

    private function getAlunos(){
        return $this->alunos;
    }

    private function setAlunos($alunos){
        $this->alunos = $alunos;
    }

    public function __construct($nomecurso,$duracaocurso){
        $this->setNome($nomecurso);
        $this->setDuracao($duracaocurso);
        $this->setQuantidadedeAlunos(0);
    }
}

?>