<?php

namespace App\Entity;
// Dependências
use App\Db\Database;
use PDO;

class Vaga
{
    /**
     * Identificador único da vaga
     * @var integer
     */
    public $id;

    /**
     * Título da vaga
     * @var string
     */
    public $titulo;

    /**
     * Descrição da vaga (pode conter html)
     * @var string
     */
    public $descricao;

    /**
     * Define se a vaga está ativa
     * @var string (s/n)
     */
    public $ativo;

    /**
     * Data de publicação
     * @var string
     */
    public $data;

    /**
     * Método responsável por cadastrar uma nova vaga
     * @return boolean
     */
    public function cadastrar()
    {
        // Definir a data
        $this->data = date('Y-m-d H:i:s');

        // Inserir a data no banco
        $obDatabase = new Database('vagas');
        // Debugando o código
        // echo "<prev>"; print_r($obDatabase); echo "</pre>"; exit;
        // Atribuir o id da vaga na instância
        $this->id = $obDatabase->insert([
            'titulo'        => $this->titulo,
            'descricao'     => $this->descricao,
            'ativo'         => $this->ativo,
            'data'          => $this->data
        ]);
        // echo "<pre>"; print_r($this); echo "</pre>"; exit;

        // Retornar sucesso
        return true;
    }

    /**
     * Método responsável por atualizar a vaga no banco
     * @return boolean
     */
    public function atualizar()
    {
        return (new Database('vagas'))->update('id = ' . $this->id, [
            'titulo'    => $this->titulo,
            'descricao' => $this->descricao,
            'ativo'     => $this->ativo,
            'data'      => $this->data
        ]);
    }

    /**
     * Método responsável por excluir a vaga do banco
     * @return boolean
     */
    public function excluir()
    {
        return (new Database('vagas'))->delete('id = ' . $this->id);
    }

    /**
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getVagas($where = null, $order = null,  $limit = null)
    {
        return (new Database('vagas'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class); // fetchAll retorna um array
    }

    /**
     * Método reponsável por buscar uma vaga com base no ID
     * @param integer $id
     * @return Vaga
     */
    public static function getVaga($id)
    {
        return (new Database('vagas'))->select('id = ' . $id)
            ->fetchObject(self::class); // fetchObject retorna somente um registro
    }
}
