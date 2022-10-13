<?php
// CRIANDO A CONEXÃO COM O BANCO DE DADOS COM PDO
namespace App\Db;

use \PDO;
use \PDOException;

class Database  {

    /**
     * Host de conexão com o banco de dados
     * @var string
     */
    const HOST = 'localhost';

    /**
     * Nome do banco de dados
     * @var string
     */
    const NAME = 'wdev_vagas';

    /**
     * Usuário do banco
     * @var string
     */
    const USER = 'root';

    /**
     * Senha de acesso
     */
    const PASS = '';

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private $table;

    /**
     * Instância de conexão com o banco de dados
     * @var string
     */
    private $connection;

    /**
     * Define a tabela e instancia a conexão
     * @param string $table
     */
    public function __construct($table = null)  
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Método responsável por criar uma conexão com o banco de dados
     */
    public function setConnection()
    {
        try {
            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }
    /**
     * Método responsável por executar queries dentro do banco de dados
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function execute($query, $params = [])
    {
        try {
            $statemant = $this->connection->prepare($query);
            $statemant->execute($params);
            return $statemant;           
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    /**
     * Método responsável por inserir dados no banco
     * @param array field => value
     * @return integer ID inserido
     */
    public function insert($values)
    {
        // DADOS DA QUERY
        $fields = array_keys($values);// Pegando o nome do campos do formulario
        $binds = array_pad([],count($fields),'?');// Cria campos de acordo com os parâmetros passados
        // echo "<pre>"; print_r($binds); echo "</pre>"; exit;// Debugando

        // MONTA A QUERY
        $query = 'INSERT INTO ' .$this->table. ' ('.implode(',', $fields).') VALUES ('.implode(',',$binds).') ';
        
        // EXECUTA O INSERT
        $this->execute($query,array_values($values));

        // RETORNA O ID INSERIDO
        return $this->connection->lastInsertId();
        // echo $query;
        // exit;
    }

    /**
     * Método responsável por executar uma consulta no banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        // DADOS DA QUERY
        // Verificação ternária
        // Se tiver valor recebe ******* senão recebe vazia
        $where = strlen($where) ? 'WHERE '.$where : ''; // strlen obsoleta em PHP8
        $order = strlen($order) ? 'ORDER BY '.$order : ''; // strlen obsoleta em PHP8
        $limit = strlen($limit) ? 'LIMIT '.$limit : ''; // strlen obsoleta em PHP8
        // MONTA A QUERY
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        // EXECUTA O QUERY
        return $this->execute($query);
    }

    /**
   * Método responsável por executar atualizações no banco de dados
   * @param  string $where
   * @param  array $values [ field => value ]
   * @return boolean
   */
  public function update($where,$values){
    //DADOS DA QUERY
    $fields = array_keys($values);

    //MONTA A QUERY
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

    //EXECUTAR A QUERY
    $this->execute($query,array_values($values));

    //RETORNA SUCESSO
    return true;
  }

  /**
   * Método responsável por excluir dados do banco
   * @param  string $where
   * @return boolean
   */
  public function delete($where){
    //MONTA A QUERY
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

    //EXECUTA A QUERY
    $this->execute($query);

    //RETORNA SUCESSO
    return true;
  }

}