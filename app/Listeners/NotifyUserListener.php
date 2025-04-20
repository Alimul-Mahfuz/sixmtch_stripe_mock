<?php

namespace App\Listeners;

use App\Events\TaskCreateEvent;
use App\Events\TaskModificationEvent;
use App\Service\NotificationService;


class NotifyUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected NotificationService $notificationService
    )
    {

    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        $task = $event->task;
        $user_id = auth()->user()->id;
        if ($event instanceof TaskCreateEvent) {
            if ($user_id != $task->assigned_to_id) {
                $this->notificationService->create('New Task Created', 'Dear, sir/man new task is assigned to you.', $task->assigned_to_id);
            }
        }
        if ($event instanceof TaskModificationEvent) {
            if ($user_id != $task->assigned_to_id) {
                $this->notificationService->create('Task is modified', 'Dear, sir/ma,am task which is assigned to you is recently modified.', $task->assigned_to_id);
            }

        }
    }
}
