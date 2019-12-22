<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Mail;

class QueueReportMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $view;
    private $data;
    private $subject;
    private $address;
    private $name;
    private $to;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($view, $data, $subject, $address, $name, $to)
    {
        $this->view = $view;
        $this->data = $data;
        $this->subject = $subject;
        $this->address = $address;
        $this->name = $name;
        $this->to = $to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = $this->subject;
        $address = $this->address;
        $name = $this->name;
        $to = $this->to;
        logger()->info("It works! | ".$this->to);
        Mail::send($this->view, $this->data, function($message) use ($subject, $address, $name, $to){
            $message->to($to, 'クレアサポート係')->subject($subject);
            $message->from($address, $name);
        });
    }
}