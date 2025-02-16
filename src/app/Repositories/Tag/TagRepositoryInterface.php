<?php

namespace App\Repositories\Tag;

/**
 * Interface TagRepositoryInterface
 *
 * @package App\Repositories\Tag
 */
interface TagRepositoryInterface
{
    /**
     * Get all
     *
     * @param $data
     * @param $options
     *
     * @return mixed
     */
    public function all($data = null, $options = null);

    /**
     * Get data with paginate
     *
     * @param $data
     * @param $options
     *
     * @return mixed
     */
    public function getList($data = null, $options = null);

    /**
     * Get by id
     *
     * @param $data
     *
     * @return mixed
     */
    public function find($data);

    /**
     * Get first by condition
     *
     * @param $data
     * @param $options
     *
     * @return mixed
     */
    public function first($data = null, $options = null);

    /**
     * Create data
     *
     * @param $data
     *
     * @return mixed
     */
    public function create($data = null);

    /**
     * Update data
     *
     * @param $data
     * @param $options
     *
     * @return mixed
     */
    public function update($data = null, $options = null);

    /**
     * Update or Create where condition in options
     *
     * @param $data
     * @param $options
     *
     * @return mixed
     */
    public function updateOrCreate($data = null, $options = null);

    /**
     * Destroy data
     *
     * @param $data
     * @param $options
     *
     * @return mixed
     */
    public function destroy($data = null, $options = null);
}
