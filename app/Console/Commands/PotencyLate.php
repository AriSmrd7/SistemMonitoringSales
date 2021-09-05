<?php

namespace App\Console\Commands;

use App\Mail\SendMailReminder;
use App\Potency;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class PotencyLate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'potency:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail if potency late';

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
     * @return int
     */
    public function handle()
    {
        $i = 0;
        $reminders = DB::table('potencies')
            ->LEFTJOIN('customers','potencies.id_pelanggan', '=', 'customers.id_pelanggan')
            ->LEFTJOIN('sales','customers.id_sales', '=', 'sales.id_sales')
            ->LEFTJOIN('services','potencies.id_service', '=', 'services.id_service')
            ->SELECT('sales.id_sales', 'sales.nama_sales', 'potencies.terminating', 'potencies.target_nego', 'potencies.target_quote', 'potencies.target_po', 'sales.email','services.segmen_service')
            ->whereRaw('target_quote = DATE_ADD(CURDATE(), INTERVAL 1 DAY) OR target_nego = DATE_ADD(CURDATE(), INTERVAL 1 DAY) OR target_po = DATE_ADD(CURDATE(), INTERVAL 1 DAY)')
            ->get();

            foreach ($reminders as $reminder) {
                $email = $reminder->email;
                $mail=implode("', '",array($email));
                $sekarang = Carbon::now()->addDays(1)->toDateString();
                Mail::to($mail)->send(new SendMailReminder($reminder,$sekarang));
                $i++;
            }
        $this->info($i.' Reminder messages sent successfully!');
    }
}
