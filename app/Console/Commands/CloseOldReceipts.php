<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
class CloseOldReceipts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'close:receipts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	$Current = Carbon::now()->format('Y-m-d H:i');
	\Log::info("Run CloseOldReceipts at: ".$Current);
        DB::Update("update m_receipt set status='Closed' where create_date < DATE(NOW()) - INTERVAL 7 DAY  AND STATUS <> 'Closed'");
    }

}
