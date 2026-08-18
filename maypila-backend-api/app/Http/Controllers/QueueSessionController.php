<?php

namespace App\Http\Controllers;

use App\Http\Requests\QueueSession\AddRemoveUserQueueSessionRequest;
use App\Http\Requests\QueueSession\GetAllQueueSessionsRequest;
use App\Http\Requests\QueueSession\StoreQueueSessionRequest;
use App\Http\Resources\ApiBaseResponse;
use App\Http\Resources\QueueSession\QueueSessionResource;
use App\Services\QueueSession\QueueSessionService;
use Knuckles\Scribe\Attributes\Response;
use App\Constants\ApiDocs\QueueSessionDocs;

class QueueSessionController extends Controller
{

    public function __construct(
        private QueueSessionService $queueSessionService
    ) {}

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => QueueSessionDocs::QUEUE_SESSION_COLLECTION,
        'meta' =>  new \stdClass()
    ])]
    public function getAllQueueSessions(GetAllQueueSessionsRequest $request)
    {
        return ApiBaseResponse::success(
            data: QueueSessionResource::collection(
                $this->queueSessionService->getAllQueueSessions($request->validated(), $request->user())
            ),
            message: 'Queue sessions retrieved all successfully'
        );
    }

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => QueueSessionDocs::QUEUE_SESSION,
        'meta' =>  new \stdClass()
    ])]
    public function getQueueSessionDetails(int $id)
    {
        $data = new QueueSessionResource(
            $this->queueSessionService->getQueueSessionById($id)
        );
        return ApiBaseResponse::success(
            data: $data,
            message: 'Queue session fetched successfully'
        );
    }

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => QueueSessionDocs::QUEUE_SESSION,
        'meta' =>  new \stdClass()
    ])]
    public function crateQueueSession(StoreQueueSessionRequest $request)
    {
        //todojeph: implement expiry of session
        $validated = $request->validated();
        $data =  new QueueSessionResource($this->queueSessionService->createQueueSession($validated));

        return ApiBaseResponse::success(
            data: $data,
            message: 'Queue session created successfully',
            status: 201
        );
    }

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => new \stdClass(),
        'meta' =>  new \stdClass()
    ])]
    public function update(StoreQueueSessionRequest $request, int $id)
    {
        $validated = $request->validated();
        return ApiBaseResponse::success(
            data: new QueueSessionResource($this->queueSessionService->updateQueueSession($id, $validated)),
            message: 'Queue session updated successfully'
        );
    }

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => new \stdClass(),
        'meta' =>  new \stdClass()
    ])]
    public function destroy(int $id)
    {
        $this->queueSessionService->deleteQueueSession($id);
        return ApiBaseResponse::success(
            message: 'Queue session deleted successfully'
        );
    }

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => new \stdClass(),
        'meta' =>  new \stdClass()
    ])]
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

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => new \stdClass(),
        'meta' =>  new \stdClass()
    ])]
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
