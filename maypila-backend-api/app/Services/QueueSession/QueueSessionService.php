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
        $actor = Auth::user();
        if (! $actor instanceof User) {
            throw new AuthorizationException('Unauthenticated.');
        }

        $queueSessionId = (int) $data['queueSessionId'];
        $userId = (int) $data['userId'];
        $companyId = (int) $data['companyId'];

        //validate if $companyId supplied is included in the 
        $belongsToCompany = $actor->companies()
            ->whereKey($companyId)
            ->exists();
        if (! $belongsToCompany) {
            throw new AuthorizationException(
                'You do not belong to this company.'
            );
        }

        $queueSessionBelongsToCompany = $actor->queueSession()->whereKey($queueSessionId)->exists();
        if(!$queueSessionBelongsToCompany) {
            throw new AuthorizationException(
                'Queue session does not belong to this company.'
            );
        }

        return DB::transaction(function () use ($queueSessionId, $userId, $companyId) {
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

            $user = User::query()
                ->lockForUpdate()
                ->whereKey($userId)
                ->firstOrFail();

            if ($user->queue_session_id !== null) {
                return [
                    'userAddedToQue' => false,
                    'data' => QueueSession::query()
                        ->whereKey($user->queue_session_id)
                        ->firstOrFail(),
                ];
            }

            $queueSession = QueueSession::query()
                ->whereKey($queueSessionId)
                ->firstOrFail();

            $user->queue_session_id = $queueSession->id;
            $user->save();

            return [
                'userAddedToQueue' => true,
                'data' => $queueSession->refresh(),
            ];
        });
    }

    public function removeQueueUser(array $data): array
    {
        $queueSessionId = $data['queueSessionId'];
        $userId = $data['userId'];

        return DB::transaction(function () use ($queueSessionId, $userId) {
            $queueSession = QueueSession::query()
                ->whereKey($queueSessionId)
                ->firstOrFail();

            $user = User::query()
                ->lockForUpdate()
                ->whereKey($userId)
                ->where('queue_session_id', $queueSession->id)
                ->firstOrFail();

            $user->update([
                'queue_session_id' => null,
            ]);

            return [
                'userRemovedFromQue' => true,
                'data' => $queueSession->refresh(),
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

    public function listQueueSessions(array $data, User $actor)
    {
        $companyId = (int) $data['companyId'];

        if (! $actor->companies()->whereKey($companyId)->exists()) {
            throw new AuthorizationException('You do not belong to this company.');
        }

        return QueueSession::query()
            ->where('company_id', $companyId)
            ->latest()
            ->get();
    }
}
