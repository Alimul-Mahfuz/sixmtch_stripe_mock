<?php

namespace App\Service;

use App\Events\TaskCreateEvent;
use App\Events\TaskModificationEvent;
use App\Mail\NewTaskWelcomeMail;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

class TaskService
{
    /**
     * @throws Exception
     */
    function create($validatedData): void
    {
        $auth_user = auth()->user();
        $data = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'deadline' => $validatedData['deadline'],
            'assigned_to_id' => $validatedData['assigned_to_id'] ?? $auth_user->id,
            'user_id' => $auth_user->id,
        ];

        try {
            $task = Task::query()->create($data);
            Event::dispatch(new TaskCreateEvent($task));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    /**
     * @throws Exception
     */
    function update($validatedData, $id): void
    {
        $auth_user = auth()->user();
        $data = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'deadline' => $validatedData['deadline'],
            'assigned_to_id' => $validatedData['assigned_to_id'] ?? $auth_user->id,
            'user_id' => $auth_user->id,
        ];
        $task = Task::query()->find($id);
        if ($task->user_id != $auth_user->id) {
            throw new Exception("You are not allowed to edit this task");
        }
        Task::query()->where('id', $id)->update($data);
        $task = Task::query()->find($id);

        Event::dispatch(new TaskModificationEvent($task));
    }

    function getTaskList(): \Illuminate\Pagination\LengthAwarePaginator
    {
        $auth_user = auth()->user();
        return Task::query()->where('user_id', $auth_user->id)
            ->orWhere('assigned_to_id', $auth_user->id)
            ->orderBy('id', 'desc')
            ->paginate(6);
    }

    function getTaskById(int $id): Task
    {
        return Task::query()->findOrFail($id);
    }
}
