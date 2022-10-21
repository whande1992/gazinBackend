<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Schema;

class EloquentRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * @Annotation Pode atribuir qualquer coluna da tabela
     * @var string
     */
    protected string $order_by_column = '';

    /**
     * @Annotation asc ou desc
     * @var string
     */
    protected string $order_by_direction = 'asc';

    /**
     * @Annotation Quantidade de itens por página
     * @var int
     */
    protected int $per_page = 10;


    /**
     * @Annotation Retorna todos os dados da tabela com opção de paginação e ordenação por qualquer coluna.
     * @param $request
     * @return mixed
     */
    public function all($request): mixed
    {

        $query = $this->model->newQuery();

        if (isset($request['order_by_direction'])) {
            $this->order_by_direction = trim($request['order_by_direction']) === "desc" ? "desc" : "asc";
        }

        if (isset($request['order_by_column'])) {
            $this->order_by_column = $request['order_by_column'];
        }

        if (isset($request['per_page'])) {
            $this->per_page = $request['per_page'];
        }

        /*Verifica se a coluna que irá ordenar os valor existe na tabela*/
        if (Schema::hasColumn($this->model->getTable(), $this->order_by_column)) {
            $query->orderBy($this->order_by_column, $this->order_by_direction);
        }

        return $query->paginate($this->per_page)->withQueryString();
    }

    /**
     * @Annotation Conferir as colunas permitidas no model para atribuição em massa
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id): mixed
    {
        return $this->model->where('id', $id)
            ->update($data);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Exception $e) {
            throw new \Exception("Ops, não tem nada em ".$this->model->getTable()." com ID $id ",$e->getCode() ,$e->getPrevious());
        }

    }

    /**
     * @Annotation Qualquer coluna da tabela pode ser enviada para o filtro.
     *  Para colunas do tipo string, o operador Like será atribuído, para as demais o operador "="
     * @param $search
     * @return mixed
     */
    public function search($search): mixed
    {
        $query = $this->model->newQuery();

        if (isset($search->order_by_direction)) {
            $this->order_by_direction = trim($search->order_by_direction) === "desc" ? "desc" : "asc";
        }

        if (isset($search->order_by_column)) {
            $this->order_by_column = $search->order_by_column;
        }

        if (isset($search->per_page)) {
            $this->per_page = $search->per_page;
        }

        foreach ($search->all() as $column => $value) {

            if (Schema::hasColumn($this->model->getTable(), $column) && $value !== null && !empty($value)) { /*Verifica se as colunas enviadas existem na tabela*/
                $type_column = Schema::getColumnType($this->model->getTable(), $column); /*Verifica o tipo de dados da coluna*/

                /*Para colunas do tipo string, será utilizado o operador Like para consulta*/
                if ($type_column === "string") {
                    $query->where($column, "like", "%$value%");
                } else {
                    $query->where($column, $value);
                }
            }
        }

        /*Verifica se a coluna que irá ordenar os valor existe na tabela*/
        if (Schema::hasColumn($this->model->getTable(), $this->order_by_column)) {

            $query->orderBy($this->order_by_column, $this->order_by_direction);
        }


        return $query->paginate($this->per_page)->withQueryString();
    }
}
