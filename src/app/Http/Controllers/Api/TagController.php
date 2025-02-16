<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tags\ListResource;
use App\Http\Resources\Tags\ShowResource;
use App\Repositories\Tag\TagRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class TagController extends Controller
{
    private $repository;
    public function __construct(TagRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ListResource
    {
        $params = $request->only(['name']);
        $data = $this->repository->all($params);

        return new ListResource($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): ShowResource
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $params = $request->only(['name']);
        $data = $this->repository->create($params);

        return new ShowResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): ShowResource
    {
        $data = $this->repository->find(['id' => $id]);

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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $data = $this->repository->find(['id' => $id]);

        if (empty($data)) {
            throw ValidationException::withMessages([
                'id' => [__('validation.exists', ['attribute' => 'id'])],
            ]);
        }

        $data = $this->repository->update([
            'name' => $request->get('name'),
        ], ['id' => $id]);

        if (!empty($data)) {
            $data = $this->repository->find(['id' => $id]);

            return new ShowResource($data);
        }

        return failResponse(Response::HTTP_BAD_REQUEST, __('common.msg_update_error'));
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
