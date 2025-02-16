<?php

namespace App\Repositories\User;

use App\Models\User;
use LongAoDai\Repositories\BaseRepository;

/**
 * Class UserEloquentRepository
 *
 * @package App\Repositories\User
 */
class UserEloquentRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @return mixed
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @param mixed $params
     * 
     * @return UserEloquentRepository
     */
    protected function filter($params): UserEloquentRepository
    {
        if ($params->get('name')) {
            $this->method('where', 'name', $params->get('name'));
        }

        if ($params->get('id')) {
            $this->method('where', 'id', $params->get('id'));
        }

        return parent::filter($params);
    }
}
