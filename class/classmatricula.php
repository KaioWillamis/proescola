<?php
class Matricula{
    private $numero;
    private $iddoaluno;
    private $iddocurso;
    private $datainicio;

    public function getNumero(){
        return $this->numero;
    }

    private function setNumero($numero){
        $this->numero = $numero;
    }

    private function getIddoAluno(){
        return $this->iddoaluno;
    }

    private function setIddoAluno($idaluno){
        $this->iddoaluno = $idaluno;
    }

    private function getIddoCurso(){
        return $this->iddocurso;
    }

    private function setIddoCurso($idcurso){
        $this->iddocurso = $idcurso;
    }

    private function getDataIncio(){
        return $this->datainicio;
    }

    private function setDataInicio($data){
        $this->datainicio = $data;
    }

    public function __construct($idaluno,$idcurso,$datainicio){
        $this->setIddoAluno($idaluno);
        $this->setIddoCurso($idcurso);
        $this->setDataInicio($datainicio);
        $this->setNumero($this->imprimirNmatricula());
    }

    private function geradorNmatricula(){
        $min = 1;
        $max = 9;
        $numeroDigitos = 5;
        $numeros = [];
        
        for($i=0;$i < $numeroDigitos;$i++ ){
            $numeros[$i]= rand($min,$max);
        }

        return $numeros;
    }

    private function imprimirNmatricula(){
        $resultado = "";
        $idsExistentes = [];

        if (file_exists('json/nmatriculas.json')) {
            $idsExistentes = json_decode(file_get_contents('json/nmatriculas.json'), true);
        }

        do {
            $resultado = "";
            $idGerado = $this->geradorNmatricula(); 
    
            for($j = 0; $j < count($idGerado); $j++) {
                $resultado .= $idGerado[$j];
            }
    
        } while (isset($idsExistentes[$resultado]));

        $idsExistentes[$resultado] = true;

        file_put_contents('json/nmatriculas.json', json_encode($idsExistentes));

        return $resultado;
        }
}
?>