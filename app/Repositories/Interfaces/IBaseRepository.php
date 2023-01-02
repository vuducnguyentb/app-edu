<?php


namespace App\Repositories\Interfaces;


interface IBaseRepository
{
    /**
     * Create an entry
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, $attributes = []);


    /**
     * Create new instance
     *
     * @return mixed
     */
    public function createInstance();

    /**
     * Get all
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Get list with key => value
     *
     * @param $valueCol
     * @param $keyCol
     *
     * @return mixed
     */
    public function pluck($valueCol, $keyCol);

    /**
     * Get list with key => value
     *
     * @param $valueCol
     * @param $keyCol
     *
     * @return mixed
     */
    public function pluckArray($valueCol, $keyCol);

    /**
     * Find one by Id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * Find one by Id or show fail response
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */

    public function findOrFail($id, $columns = ['*']);

    /**
     * Destroy by Ids
     * @param $ids
     *
     * @return mixed
     */
    public function destroy($ids);

    public function findWithRelationships($id, $relationships = [], $columns = ['*']);

}
