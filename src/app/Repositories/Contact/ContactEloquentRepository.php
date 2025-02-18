<?php

namespace App\Repositories\Contact;

use App\Models\Contact;
use LongAoDai\Repositories\BaseRepository;

/**
 * Class ContactEloquentRepository
 *
 * @package App\Repositories\Contact
 */
class ContactEloquentRepository extends BaseRepository implements ContactRepositoryInterface
{
    /**
     * @return mixed
     */
    public function model()
    {
        return Contact::class;
    }

    /**
     * Create data with tag
     *
     * @param $data
     *
     * @return mixed
     */
    public function createWithTag($data)
    {
        $contact = $this->method('create', $data['contact']);

        if (!empty($data['tags'])) {
            $contact->tags()->sync($data['tags']);
        }

        return $contact;
    }

    /**
     * Update data with tag
     *
     * @param \App\Models\Contact $contact 
     * @param $data
     *
     * @return mixed
     */
    public function updateWithTag($contact, $data)
    {
        $this->update($data['contact'], ['id' => $contact->id]);
        
        if (!empty($data['tags'])) {
            $contact->tags()->sync($data['tags']);
        } else {
            $contact->tags()->detach();
        }

        return $this->first(['id' => $contact->id], ['with_tags']);
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
     * @return ContactEloquentRepository
     */
    protected function filter($params): ContactEloquentRepository
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

        if ($params->option('with_tags')) {
            $this->method('with', 'tags');
        }

        return parent::filter($params);
    }

    /**
     * @param mixed $params
     * 
     * @return ContactEloquentRepository
     */
    protected function mark($params): ContactEloquentRepository
    {
        if ($params->option('id')) {
            $this->method('where', 'id', $params->option('id'));
        }

        return parent::mark($params);
    }
}
