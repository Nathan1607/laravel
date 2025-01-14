<?php

namespace App\Jobs;

use App\Models\Report;
use App\Mail\ReportItems;
use App\Mail\ReportOrder;
use Illuminate\Bus\Queueable;
use App\Events\SendReportFinish;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function handle()
    {
        Mail::to('tom@mds.fr')->send(new ReportOrder($this->report));

        SendReportFinish::dispatch($this->report);
    }
}
