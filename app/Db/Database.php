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
     * @param string
     * @param array
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
     * Método responsável por fazer a inserção dos dados no banco
     * @param array field => value
     * @return integer
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
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        // DADOS DA QUERY
        // Verificação ternária
        // Se tiver valor recebe ******* senão recebe vazia
        $where = !empty($where) ? 'WHERE '.$where : ''; // strlen obsoleta em PHP8
        $order = !empty($order) ? 'ORDER BY '.$order : ''; // strlen obsoleta em PHP8
        $limit = !empty($limit) ? 'LIMIT '.$limit : ''; // strlen obsoleta em PHP8
        // MONTA A QUERY
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        // EXECUTE O QUERY
        return $this->execute($query);
    }

}