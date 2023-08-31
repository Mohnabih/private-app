<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class DailyQuote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete pending orders that have exceeded 3 days';

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
        $orders=Order::where('status',0)->get();
        foreach($orders as $order){
            if(Carbon::now()>=$order->end_at)
                $order->status=2;
                $order->save();
                $sender=$order->sender;
                $sender->status=0;
                $sender->save();
                $recipient=$order->recipient;
                $recipient->status=0;
                $recipient->save();
        }
    }
}
