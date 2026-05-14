<?php

namespace App\Http\Controllers;

use App\Http\Requests\QueueSession\AddRemoveUserQueueSessionRequest;
use App\Http\Requests\QueueSession\IndexQueueSessionRequest;
use App\Http\Requests\QueueSession\StoreQueueSessionRequest;
use App\Http\Resources\QueueSession\QueueSessionResource;
use App\Services\QueueSession\QueueSessionService;

class QueueSessionController extends Controller
{
    private QueueSessionService $queueSessionService;

    public function __construct(QueueSessionService $queueSessionService)
    {
        $this->queueSessionService = $queueSessionService;
    }

    public function index(IndexQueueSessionRequest $request)
    {
        return QueueSessionResource::collection(
            $this->queueSessionService->listQueueSessions($request->validated(), $request->user())
        );
    }

    public function show(int $id)
    {
        return new QueueSessionResource($this->queueSessionService->getQueueSessionById($id));
    }

    public function store(StoreQueueSessionRequest $request)
    {
        $validated = $request->validated();
        return new QueueSessionResource($this->queueSessionService->createQueueSession($validated));
    }

    public function update(StoreQueueSessionRequest $request, int $id)
    {
        $validated = $request->validated();
        return new QueueSessionResource($this->queueSessionService->updateQueueSession($id, $validated));
    }

    public function destroy(int $id)
    {
        $this->queueSessionService->deleteQueueSession($id);
        return response()->noContent();
    }

    public function addQueueUser(AddRemoveUserQueueSessionRequest $request)
    {
        $result = $this->queueSessionService->addQueueUser($request->validated());

        return response()->json([
            'userAddedToQue' => $result['userAddedToQue'],
            'data' => (new QueueSessionResource($result['data']))->resolve($request),
        ]);
    }

    public function removeQueueUser(AddRemoveUserQueueSessionRequest $request)
    {
        $result = $this->queueSessionService->removeQueueUser($request->validated());

        return response()->json([
            'userRemovedFromQue' => $result['userRemovedFromQue'],
            'data' => (new QueueSessionResource($result['data']))->resolve($request),
        ]);
    }
}
