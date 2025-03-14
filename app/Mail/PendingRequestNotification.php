<?php

// app/Mail/PendingRequestNotification.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $department;
    public $pendingCount;

    public function __construct($department, $pendingCount)
    {
        $this->department = $department;
        $this->pendingCount = $pendingCount;
    }

    public function build()
    {
        return $this->view('emails.pending_request_notification')
                    ->with([
                        'departmentName' => $this->department->dep_name,
                        'pendingCount' => $this->pendingCount,
                    ])
                    ->subject('Pending Application Requests');
    }
}
