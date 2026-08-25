<?php

namespace App\Services\QueueSession;

use App\Enum\QueueSessionStatus;
use App\Models\QueueSession;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class QueueSessionService
{

    public function addQueueUser(array $data): array
    {
        //retrieve logged in user
        $actor = Auth::user();
        if (! $actor instanceof User) {
            throw new AuthorizationException('Unauthenticated.');
        }

        $queueSessionId = (int) $data['queueSessionId'];
        $userId = (int) $data['userId'];
        $companyId = (int) $data['companyId'];

        $this->validateQueueUserCompanyAccess($actor, $queueSessionId, $userId, $companyId);

        return DB::transaction(function () use ($queueSessionId, $userId) {

            $user = User::query()
                ->lockForUpdate()
                ->whereKey($userId)
                ->firstOrFail();

            if ($user->queue_session_id !== null) {
                return [
                    'userAddedToQue' => false,
                    'data' => null
                ];
            }

            $user->queue_session_id = $queueSessionId;
            $user->save();



            return [
                'userAddedToQueue' => true,
                'data' => $user->refresh(),
            ];
        });
    }

    public function removeQueueUser(array $data): array
    {
        //retrieve logged in user
        $actor = Auth::user();
        if (! $actor instanceof User) {
            throw new AuthorizationException('Unauthenticated.');
        }

        $queueSessionId = (int) $data['queueSessionId'];
        $userId = (int) $data['userId'];
        $companyId = (int) $data['companyId'];

        $this->validateQueueUserCompanyAccess($actor, $queueSessionId, $userId, $companyId);

        return DB::transaction(function () use ($queueSessionId, $userId) {

            $user = User::query()
                ->lockForUpdate()
                ->whereKey($userId)
                ->where('queue_session_id', $queueSessionId)
                ->firstOrFail();

            $user->queue_session_id = null;
            $user->save();

            return [
                'userRemovedFromQue' => true,
                'data' => $user->refresh(),
            ];
        });
    }

    public function createQueueSession(array $validatedData)
    {
        $actor = Auth::user();

        if (! $actor instanceof User) {
            throw new AuthorizationException('Unauthenticated.');
        }

        $companyId = (int) $validatedData['companyId'];

        if (! $actor->companies()->whereKey($companyId)->exists()) {
            throw new AuthorizationException('You do not belong to this company.');
        }

        return DB::transaction(function () use ($validatedData, $companyId, $actor) {
            return QueueSession::create([
                'created_by' => $actor->id,
                'company_id' => $companyId,
                'queue_status' => QueueSessionStatus::Active->value,
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ])->refresh();
        });
    }

    public function getQueueSessionById(int $id)
    {
        return QueueSession::query()
            ->whereKey($id)
            ->firstOrFail();
    }

    public function updateQueueSession(int $id, array $validatedData)
    {
        return DB::transaction(function () use ($id, $validatedData) {
            $queueSession = QueueSession::query()
                ->whereKey($id)
                ->firstOrFail();

            $queueSession->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ]);

            return $queueSession->refresh();
        });
    }


    public function deleteQueueSession(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $queueSession = QueueSession::query()
                ->whereKey($id)
                ->firstOrFail();

            User::query()
                ->where('queue_session_id', $queueSession->id)
                ->update(['queue_session_id' => null]);

            Customer::query()
                ->where('queue_session_id', $queueSession->id)
                ->update(['queue_session_id' => null]);

            return (bool) $queueSession->delete();
        });
    }

    public function getAllQueueSessions(array $data, User $actor)
    {
        $companyId = (int) $data['companyId'];
        $perPage = (int) ($data['perPage'] ?? 5);

        if (! $actor->companies()->whereKey($companyId)->exists()) {
            throw new AuthorizationException('You do not belong to this company.');
        }

        return QueueSession::query()
            ->where('company_id', $companyId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    private function validateQueueUserCompanyAccess(User $actor, int $queueSessionId, int $userId, int $companyId): void
    {
        //check if company ID belongs to logged in user
        $belongsToCompany = $actor->companies()
            ->whereKey($companyId)
            ->exists();

        if (! $belongsToCompany) {
            throw new AuthorizationException(
                'You do not belong to this company.'
            );
        }

        //check if queue session ID belongs to logged in company ID
        $queueSessionBelongsToCompany = QueueSession::query()
            ->where('company_id', $companyId)
            ->whereKey($queueSessionId)
            ->exists();

        if (! $queueSessionBelongsToCompany) {
            throw new AuthorizationException(
                'Queue session does not belong to this company.'
            );
        }

        //check if users belongs to the company
        $userBelongsToCompany = User::query()
            ->whereKey($userId)
            ->whereHas('companies', function ($query) use ($companyId) {
                $query->whereKey($companyId);
            })
            ->exists();

        if (! $userBelongsToCompany) {
            throw new AuthorizationException(
                'The selected user does not belong to this company.'
            );
        }
    }
}
