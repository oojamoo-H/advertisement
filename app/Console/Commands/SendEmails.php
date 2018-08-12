<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send {nickname} {username} {code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email';

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
        $params = array(
            'code' => $this->argument('code'),
            'uname'  => $this->argument('nickname'),
        );
        Mail::alwaysTo($this->argument('username'));
        $flag = Mail::send('reg_email',$params,function($message){
            $message->subject('EscortPie Account Verification');
        });
        return $flag;
    }
}
