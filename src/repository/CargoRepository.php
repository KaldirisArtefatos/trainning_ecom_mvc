<?php 

namespace Repository{

    require '../../vendor/autoload.php';    

    use \PDO;
    use \Models\BaseModel;
    use \Models\Cargo;
    use \Repository\BaseRepository;
    use \Repository\Contracts\BaseRepositoryInterface;    

    class CargoRepository extends BaseRepository implements BaseRepositoryInterface
    {    
        public function find($id)
        {
            $stmt = $this->connection->prepare('
                SELECT 
                    id, 
                    nome,
                    departamento                                          
                FROM cargo 
                WHERE id = :id
            ');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
                    
            $stmt->setFetchMode(PDO::FETCH_INTO, new Cargo());
            return $stmt->fetch();
        }

        public function findAll()
        {
            $stmt = $this->connection->prepare('
                SELECT id, nome, departamento FROM cargo
            ');
            $stmt->execute();            
            $cargos = $stmt->fetchAll();
            $result = [];
            
            if($cargos) {
                foreach($cargos as $cargo) {
                    $result[$cargo['id']] = new Cargo($cargo['id'], $cargo["nome"],$cargo["departamento"]);
                }
            }
            return $result;
            
        }

        public function save(BaseModel $cargo)
        {
            $this->beginTransaction();            

            // Se existir Id, é uma alteração
            if (!empty($cargo->id)) {
                return $this->update($cargo);
            }

            $stmt = $this->connection->prepare('
                INSERT INTO cargo 
                    (nome,departamento) 
                VALUES 
                    (:nome,:departamento)
            ');        
            $stmt->bindParam(':nome', $cargo->nome,':departamento',$cargo->departamento);            
            $stmt->execute();
            $id = $this->connection->lastInsertId();
            return $id;
        }

        public function update(BaseModel $cargo)
        {
            if (!isset($cargo->id)) {
                throw new \LogicException(
                    'Cargo não existe.'
                );
            }
            $stmt = $this->connection->prepare('
                UPDATE cargo
                SET nome = :nome,   
                    departamento = :departamento                  
                WHERE id = :id
            ');
            
            $stmt->bindParam(':departamento', $cargo->departamento);            
            $stmt->bindParam(':nome', $cargo->nome);            
            $stmt->bindParam(':id', $cargo->id);
            return $stmt->execute();
        }    
    }
}
?>