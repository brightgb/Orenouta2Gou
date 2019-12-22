<?php

namespace App\Jobs;

use App\Model\AdminMessageTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class QueueMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $to;
    private $template_id;
    private $subject;
    private $message_data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $template_id, $subject, $message_data)
    {
        //
        $this->to = $to;
        $this->template_id = $template_id;
        $this->subject = $subject;
        $this->message_data = $message_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger()->info("It works! | ".$this->to);

        $message_template = AdminMessageTemplate::where('id', $this->template_id)->first();
        $to = $this->to;
        $subject = $this->subject;
        $from = 'supp@'.config('app.support_mail_domain');
        Mail::send($message_template->file_name, $this->message_data, function($message) use ($to, $subject, $from){
            $message->to($to)->subject($subject);
            $message->from($from, 'クレアサポート係');
        });
    }
}
