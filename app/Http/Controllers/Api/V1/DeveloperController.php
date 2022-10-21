<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateDeveloper;
use App\Http\Resources\DeveloperResource;
use App\Services\DeveloperService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeveloperController extends Controller
{

    protected DeveloperService $developerService;

    public function __construct(DeveloperService $developerService)
    {
        $this->developerService = $developerService;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $developers = $this->developerService->getDevelopers($request->all());

        return DeveloperResource::collection($developers);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request): mixed
    {
        $developers = $this->developerService->searchDeveloper($request);

        return DeveloperResource::collection($developers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUpdateDeveloper $request
     * @return Response|DeveloperResource
     */
    public function store(StoreUpdateDeveloper $request): Response|DeveloperResource
    {
        $developer = $this->developerService->createDeveloper($request->validated());

        return new DeveloperResource($developer);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($id): JsonResponse|DeveloperResource
    {
        try {
            $developer = $this->developerService->getDeveloperById($id);

            return new DeveloperResource($developer);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StoreUpdateDeveloper $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StoreUpdateDeveloper $request, $id): JsonResponse
    {
        $this->developerService->updateDeveloper($request->validated(), $id);

        return response()->json([
            'updated' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {

        try {
            $status_code = $this->developerService->deleteDeveloper($id) ? 204 : 400;

            return response()->json([], $status_code);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
