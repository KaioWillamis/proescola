<?php
class Aluno{
    private $nome;
    private $telefone;
    private $cpf;
    private $id;
    private $curso;
    private $numeromatricula;

    //gets e sets
    private function getNome(){
        return $this->nome;
    }
    
    private function setNome($nome){
        $this->nome = $nome;
    }

    private function getTelefone(){
        return $this->telefone;
    }

    private function setTelefone($telefone){
        $this->telefone = $telefone;
    }

    private function getCpf(){
        return $this->cpf;
    }

    private function setCpf($cpf){
        $this->cpf = $cpf;
    }

    public function getId(){
        return $this->id;
    }

    private function setId($id){
        $this->id = $id;
    }

    private function getCurso(){
        return $this->curso;
    }

    private function setCurso($curso){
        $this->curso = $curso;
    }

    private function getNumeroMatricula(){
        return $this->numeromatricula;
    }

    private function setNumeroMatricula($numero){
        $this->numeromatricula = $numero;
    }

    //métodos especiais
    public function __construct($nome,$telefone,$cpf){
        $this->setNome($nome);
        $this->setTelefone($telefone);
        $this->setCpf($cpf);
        $this-> setId($this->imprimirNumero());
    }

    private function geradorId(){
        $min = 1;
        $max = 9;
        $numeroDigitos = 10;
        $numeros = [];
        
        for($i=0;$i < $numeroDigitos;$i++ ){
            $numeros[$i]= rand($min,$max);
        }

        return $numeros;
    }

    private function imprimirNumero(){
        $resultado = "";
        $idsExistentes = [];

        if (file_exists('json/ids.json')) {
            $idsExistentes = json_decode(file_get_contents('json/ids.json'), true);
        }

        do {
            $resultado = "";
            $idGerado = $this->geradorId(); 
    
            for($j = 0; $j < count($idGerado); $j++) {
                $resultado .= $idGerado[$j];
            }
    
        } while (isset($idsExistentes[$resultado]));

        $idsExistentes[$resultado] = true;

        file_put_contents('json/ids.json', json_encode($idsExistentes));

        return $resultado;
        }
}
?>
