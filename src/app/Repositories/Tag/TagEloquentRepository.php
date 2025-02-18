<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use LongAoDai\Repositories\BaseRepository;

/**
 * Class TagEloquentRepository
 *
 * @package App\Repositories\Tag
 */
class TagEloquentRepository extends BaseRepository implements TagRepositoryInterface
{
    /**
     * @return mixed
     */
    public function model()
    {
        return Tag::class;
    }

    /**
     * @param mixed $data
     * @param mixed $options
     */
    public function update($data = null, $options = null)
    {
        $this->resetModel();

        return parent::update($data, $options);
    }

    /**
     * @param mixed $params
     * 
     * @return TagEloquentRepository
     */
    protected function filter($params): TagEloquentRepository
    {
        if ($params->get('name')) {
            $this->method('where', 'name', $params->get('name'));
        }

        if ($params->get('id')) {
            $this->method('where', 'id', $params->get('id'));
        }

        if ($params->get('ids')) {
            $this->method('whereIn', 'id', $params->get('ids'));
        }

        return parent::filter($params);
    }

    /**
     * @param mixed $params
     * 
     * @return TagEloquentRepository
     */
    protected function mark($params)
    {
        if ($params->option('id')) {
            $this->method('where', 'id', $params->option('id'));
        }

        return parent::mark($params);
    }
}
