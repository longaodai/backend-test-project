<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contact\StoreRequest;
use App\Http\Requests\Api\Contact\UpdateRequest;
use App\Http\Resources\Contact\ListResource;
use App\Http\Resources\Contact\ShowResource;
use App\Repositories\Contact\ContactRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    private $repository;

    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = $request->only(['name']);
        $data = $this->repository->getList($params);

        return new ListResource($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $params = $request->only([
            'name',
            'email',
            'phone'
        ]);
        $data = $this->repository->createWithTag([
            'contact' => $params,
            'tags' => $request->get('tags'),
        ]);

        return new ShowResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->repository->first(['id' => $id], ['with_tags' => true]);

        if (empty($data)) {
            throw ValidationException::withMessages([
                'id' => [__('validation.exists', ['attribute' => 'id'])],
            ]);
        }

        return new ShowResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $contact = $this->repository->find(['id' => $id]);

        if (empty($contact)) {
            throw ValidationException::withMessages([
                'id' => [__('validation.exists', ['attribute' => 'id'])],
            ]);
        }
        
        $params = $request->only([
            'name',
            'email',
            'phone'
        ]);
        $data = $this->repository->updateWithTag($contact, [
            'contact' => $params,
            'tags' => $request->get('tags', []),
        ]);

        return new ShowResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->repository->find(['id' => $id]);

        if (!$data) {
            throw ValidationException::withMessages([
                'id' => [__('validation.exists', ['attribute' => 'id'])],
            ]);
        }

        $data = $this->repository->destroy(['id' => $id]);

        if ($data) {
            return response()->noContent();
        }

        return failResponse(Response::HTTP_BAD_REQUEST, __('common.msg_delete_error'));
    }

    /**
     * Remove the specified resource from storage by list id.
     */
    public function destroyMany(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);
        $ids = $validated['ids'];
        $data = $this->repository->destroy(['ids' => $ids]);

        if ($data) {
            return response()->noContent();
        }

        return failResponse(Response::HTTP_BAD_REQUEST, __('common.msg_delete_error'));
    }
}
