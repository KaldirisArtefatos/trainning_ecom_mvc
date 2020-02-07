<?php 

namespace Repository {
    
    use \PDO;
    // Tirou essa linha  - use Repository\Contracts\BaseRepositoryInterface;

require '../../vendor/autoload.php';        

    class BaseRepository 
    {
        protected $connection;
        
        public function __construct(PDO $connection = null)
        {
            $this->connection = $connection;
            if ($this->connection === null) {
                $this->connection = new PDO(
                        'mysql:host=localhost:3308;dbname=trainning_ecom_mvc', 
                        'root', 
                        ''
                    );
                // :: Não Abafa a Exceção... sobe a informação
                $this->connection->setAttribute(
                    PDO::ATTR_ERRMODE, 
                    PDO::ERRMODE_EXCEPTION
                );
            }
        }
        
        public function getConnection(){
            return $this->connection;        
        }        

        // inTransaction  -  Flag se tem ou não uma transação.
        protected function beginTransaction(){
            if($this->connection->inTransaction() == 0){
                $this->connection->beginTransaction();
            }
        }

        public function commitChanges(){
            if($this->connection->inTransaction() == 1){
                $this->connection->commit();
            }
        }

        public function rollbackChanges(){
            if($this->connection->inTransaction() == 1){
                $this->connection->rollBack();
            }
        }
    }
}
?>