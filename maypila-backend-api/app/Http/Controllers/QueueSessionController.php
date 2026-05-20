<?php

namespace App\Http\Controllers;

use App\Http\Requests\QueueSession\AddRemoveUserQueueSessionRequest;
use App\Http\Requests\QueueSession\IndexQueueSessionRequest;
use App\Http\Requests\QueueSession\StoreQueueSessionRequest;
use App\Http\Resources\ApiBaseResponse;
use App\Http\Resources\QueueSession\QueueSessionResource;
use App\Services\QueueSession\QueueSessionService;

class QueueSessionController extends Controller
{

    public function __construct(
        private QueueSessionService $queueSessionService
        )
    {
    }

    public function index(IndexQueueSessionRequest $request)
    {
        return ApiBaseResponse::success(
            data: QueueSessionResource::collection(
                $this->queueSessionService->listQueueSessions($request->validated(), $request->user())
            ),
            message: 'Queue sessions fetched successfully'
        );
    }

    public function show(int $id)
    {
        return ApiBaseResponse::success(
            data: new QueueSessionResource(
                $this->queueSessionService->getQueueSessionById($id)
            ),
            message: 'Queue session fetched successfully'
        );
    }

    public function store(StoreQueueSessionRequest $request)
    {
        //todojeph: implement expiry of session
        $validated = $request->validated();

        return ApiBaseResponse::success(
            data: new QueueSessionResource($this->queueSessionService->createQueueSession($validated)),
            message: 'Queue session created successfully',
            status: 201
        );
    }

    public function update(StoreQueueSessionRequest $request, int $id)
    {
        $validated = $request->validated();

        return ApiBaseResponse::success(
            data: new QueueSessionResource($this->queueSessionService->updateQueueSession($id, $validated)),
            message: 'Queue session updated successfully'
        );
    }

    public function destroy(int $id)
    {
        $this->queueSessionService->deleteQueueSession($id);

        return ApiBaseResponse::success(
            message: 'Queue session deleted successfully'
        );
    }

    public function addQueueUser(AddRemoveUserQueueSessionRequest $request)
    {
        $result = $this->queueSessionService->addQueueUser($request->validated());

        return ApiBaseResponse::success(
            data: [
                'userAddedToQue' => $result['userAddedToQueue'],
                'queueSession' => (new QueueSessionResource($result['data']))->resolve($request),
            ],
            message: 'User added to queue session successfully'
        );
    }

    public function removeQueueUser(AddRemoveUserQueueSessionRequest $request)
    {
        $result = $this->queueSessionService->removeQueueUser($request->validated());

        return ApiBaseResponse::success(
            data: [
                'userRemovedFromQue' => $result['userRemovedFromQue'],
                'queueSession' => (new QueueSessionResource($result['data']))->resolve($request),
            ],
            message: 'User removed from queue session successfully'
        );
    }
}
