<?php
 
namespace Models{
 
    require '../../vendor/autoload.php';    
    use \Models\Contracts\CrudInterface;
    use \Repository\CargoRepository;
 
class Cargo extends BaseModel implements CrudInterface {
        
        private $nome;
 
        public function __construct($id = 0, $nome = '', $departamento='')
        {
            $this->id = $id;
            $this->nome = $nome;
            $this->departamento = $departamento;
        }
 
        public function getNome()
        {
            return $this->nome;
        }
 
        public function getDepartamento()
        {
            return $this->departamento;
        }


        public function find($id){}
        public function findAll(){
            $repository = new CargoRepository();
            $cargos = $repository->findAll();
            return $cargos;
        }
        public function save(){}
        public function delete($id){}
   }   
}
?>