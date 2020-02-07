<?php
namespace Models{
    
    require '../../vendor/autoload.php';

    // Classe Abstrada só pode ser Herdada
    abstract class BaseModel {

        protected $id;
        protected $dataCriacao;
        protected $usuarioCriacao;
        protected $dataAlteracao;
        protected $usuarioAlteracao;

        // Magigos - Dispensa Criar os GETs e SETs
        public function __set($atrib, $value){
            $this->$atrib = $value;
        }

        public function __get($atrib){
            return $this->$atrib;
        }

        public function getId(){
            return $this->id;
        }
    }
}
?>