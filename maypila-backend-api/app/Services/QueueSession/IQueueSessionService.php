<?php

namespace App\Services\QueueSession;

interface IQueueSessionService
{
    /**
     * Create a new QueueSession.
     * @param array $data
     * @return mixed
     */
    public function createQueueSession(array $data);

    /**
     * Get a QueueSession by ID.
     * @param int $id
     * @return mixed
     */
    public function getQueueSessionById(int $id);

    /**
     * Update a QueueSession by ID.
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateQueueSession(int $id, array $data);

    /**
     * Delete a QueueSession by ID.
     * @param int $id
     * @return bool
     */
    public function deleteQueueSession(int $id): bool;

    /**
     * List all QueueSessions.
     * @return array
     */
    public function listQueueSessions(): array;
}
