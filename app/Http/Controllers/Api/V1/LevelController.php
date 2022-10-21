<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateLevel;
use App\Http\Resources\LevelResource;
use App\Services\LevelService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class LevelController extends Controller
{

    protected LevelService $levelService;

    public function __construct(LevelService $levelService)
    {
        $this->levelService = $levelService;
    }


    public function index(Request $request): AnonymousResourceCollection
    {
        $levels = $this->levelService->getLevels($request->all());

        return LevelResource::collection($levels);
    }

    public function search(Request $request)
    {
        $levels = $this->levelService->searchLevel($request);

        return LevelResource::collection($levels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUpdateLevel $request
     * @return LevelResource
     */
    public function store(StoreUpdateLevel $request): LevelResource
    {
        $level = $this->levelService->createLevel($request->validated());

        return new LevelResource($level);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return LevelResource|JsonResponse
     */
    public function show(int $id): LevelResource|JsonResponse
    {
        try {
            $level = $this->levelService->getLevelById($id);

            return new LevelResource($level);

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
     * @param StoreUpdateLevel $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StoreUpdateLevel $request, int $id): JsonResponse
    {
        $this->levelService->updateLevel($request->validated(), $id);

        return response()->json([
            'updated' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $status_code = $this->levelService->deleteLevel($id) ? 204 : 400;
            return response()->json([], $status_code);
        } catch (QueryException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getCode() . ' -  Não é possível excluir um nível com programadores vinculados.'
            ], 501);
        }
    }
}
