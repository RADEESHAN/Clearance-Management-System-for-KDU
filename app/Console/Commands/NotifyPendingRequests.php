<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Department;
use Illuminate\Support\Facades\Mail;
use App\Mail\PendingRequestNotification;

class NotifyPendingRequests extends Command
{
    protected $signature = 'notify:pending-requests';
    protected $description = 'Send notifications for pending application requests daily';

    public function handle()
    {
        // Get departments with at least one pending request
        $departments = Department::whereHas('applicationStatuses', function ($query) {
            $query->where('status', 'PENDING');
        })->get();

        foreach ($departments as $department) {
            $pendingCount = $department->applicationStatuses()->where('status', 'PENDING')->count();

            // Only send email if there is at least 1 pending request and department email is not empty
            if ($pendingCount >= 1 && !empty($department->email)) {
                // Send the notification email
                Mail::to($department->email)->send(new PendingRequestNotification($department, $pendingCount));
                $this->info("Notification sent to {$department->dep_name}.");

                // Update last notification date
                $department->last_notification_date = now();
                $department->save();
            } else {
                $this->warn("No valid email found for department: {$department->dep_name} or pending count is 0.");
            }
        }
    }

}
