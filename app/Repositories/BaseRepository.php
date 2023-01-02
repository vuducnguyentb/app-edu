<?php


namespace App\Repositories;


use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Reliese\Database\Eloquent\Model;


class BaseRepository implements Interfaces\IBaseRepository
{

    protected $model;
    protected $perPage = 10;
    protected $with = [];

    protected function callModelStaticFunction($functionName, $params)
    {
        return $this->model->$functionName($params);
    }

    public function model()
    {
        return $this->model;
    }

    public function getMorphClass()
    {
        return $this->model()->getMorphClass();
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function createInstance()
    {
        return new $this->model();
    }

    public function update($id, $attributes = [])
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return false;

    }

    public function whereIn($ids, $searchColumn, $columns = ['*'])
    {
        $query = $this->model->newQuery();
        return $query->whereIn($searchColumn, $ids)->get($columns);
    }

    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function pluck($valueCol, $keyCol)
    {
        return $this->model->pluck($valueCol, $keyCol);
    }

    public function pluckArray($valueCol, $keyCol)
    {
        return $this->pluck($valueCol, $keyCol)->toArray();
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    public function findBySlug($slug, $columns = ['*'])
    {
        return $this->model->select($columns)->where('slug', $slug)->first();
    }

    public function findByName($name, $columns = ['*'])
    {
        return $this->model->select($columns)->where('name', $name)->first();
    }

    public function findOrFail($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function findOrFailWithTrashed($id, $columns = ['*'])
    {
        return $this->model->withTrashed()->findOrFail($id, $columns);
    }

    public function destroy($ids)
    {
        return $this->model->destroy($ids);
    }

    public function findAllWithOptions($queryOptions = [])
    {
        return $this->findAllWithOptionsQuery($queryOptions)->get();
    }

    public function findAllWithOptionsWithPagination($queryOptions = [], $perPage = 0)
    {
        $perPage = $perPage ?: $this->perPage;
        return $this->findAllWithOptionsQuery($queryOptions)->paginate($perPage);
    }

    public function findAllWithTrashedWithOptionsWithPagination($queryOptions = [], $perPage = 0)
    {
        $perPage = $perPage ?: $this->perPage;
        return $this->findAllWithOptionsQuery($queryOptions)->withTrashed()->paginate($perPage);
    }

    public function findPublishedWithOptionsWithPagination($queryOptions = [], $perPage = 0)
    {
        $perPage = $perPage ?: $this->perPage;
        $queryOptions['status'] = 1;

        return $this->findAllWithOptionsQuery($queryOptions)->paginate($perPage);
    }

    /** PROTECTED METHODS */

    /**
     * Default query with Options
     * @param array $queryOptions
     *
     * @return mixed
     */

    public function buildQueryWithOptions($query, $queryOptions = [])
    {
        if (isset($queryOptions['id']) && $queryOptions['id'] > 0) {
            $query = $query->where('id', $queryOptions['id']);
        }
        if (isset($queryOptions['in_ids']) && is_array($queryOptions['in_ids']) && $queryOptions['in_ids']) {
            $query = $query->whereIn('id', $queryOptions['in_ids']);

            if (isset($queryOptions['order_by_in_ids']) && $queryOptions['order_by_in_ids'] == true) {
                $inIdsString = implode(',', $queryOptions['in_ids']);
                $query = $query->orderByRaw(DB::raw("FIELD(id, $inIdsString)"));
            }
        }

        if (isset($queryOptions['not_in_ids']) && is_array($queryOptions['not_in_ids']) && $queryOptions['not_in_ids']) {
            $query = $query->whereNotIn('id', $queryOptions['not_in_ids']);
        }

        if (isset($queryOptions['status'])) {
            $query->where('status', (int)$queryOptions['status']);
        }

        if (isset($queryOptions['created_at_from']) && $queryOptions['created_at_from']) {
            $query->where('created_at', '>=', $queryOptions['created_at_from']);
        }

        if (isset($queryOptions['created_at_to']) && $queryOptions['created_at_to']) {
            $query->where('created_at', '<=', $queryOptions['created_at_to']);
        }

        if (isset($queryOptions['updated_at_from']) && $queryOptions['updated_at_from']) {
            $query->where('updated_at', '>=', $queryOptions['updated_at_from']);
        }

        if (isset($queryOptions['updated_at_to']) && $queryOptions['updated_at_to']) {
            $query->where('updated_at', '<=', $queryOptions['updated_at_to']);
        }

        /**
         * [
         *  'type' => 'or', // 'and'
         *  'field' => 'column_name',
         *  'operator' => '=',
         *  'value' => 'value'
         * ]
         */
        /**
         * @var QueryBuilder $query
         */
        if (isset($queryOptions['conditions']) && $queryOptions['conditions']) {
            foreach ($queryOptions['conditions'] as $condition) {
                switch (strtolower($condition['type'])) {
                    case 'has':
                        $query->whereHas($condition['field'], $condition['value']);
                        break;
                    case 'in':
                        $query->whereIn($condition['field'], $condition['value']);
                        break;
                    case 'notin':
                        $query->whereNotIn($condition['field'], $condition['value']);
                        break;
                    case 'notnull':
                        $query->whereNotNull($condition['field']);
                        break;
                    case 'null':
                        $query->whereNull($condition['field']);
                        break;
                    case 'or':
                        $query->orWhere($condition['field'], $condition['operator'], $condition['value']);
                        break;
                    case 'in_array':
                        $sql = sprintf("FIND_IN_SET('%s', REPLACE(REPLACE(%s, '[', ''), ']', '')) > 0", $condition['value'], $condition['field']);
                        $query->where(DB::raw($sql));
                        break;
                    case 'function':
                        $query->where($condition['function']);
                        break;
                    default:
                        $query->where($condition['field'], $condition['operator'], $condition['value']);
                        break;
                }
            }
        }
        return $query;
    }

    /**
     * Build Sort Queries
     * @param       $query
     * @param array $queryOptions
     *
     * @return mixed
     */
    protected function buildSortQuery($query, $queryOptions = [])
    {
        if (isset($queryOptions['sorts']) && is_array($queryOptions['sorts']) && !empty($queryOptions['sorts'])) {
            foreach ($queryOptions['sorts'] as $sortColumn => $sortDirection) {
                if (Schema::hasColumn($this->model->getTable(), $sortColumn)) {
                    $query->orderBy($sortColumn, $sortDirection);
                }
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }

    /**
     * Building Queries with options, default using the OptionsDefaultQuery
     * @param array $queryOptions
     *
     * @return mixed
     */
    protected function findAllWithOptionsQuery($queryOptions = [])
    {
        $query = $this->model->query();
        $query = $this->buildQueryWithOptions($query, $queryOptions);
        $query = $this->buildSortQuery($query, $queryOptions);
        return $query;
    }

    public function findWithRelationships($id, $relationships = [], $columns = ['*'])
    {
        $query = $this->model->query()->with($relationships);
        return $query->find($id, $columns);
    }

}
