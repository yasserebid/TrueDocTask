<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class SendImportResult extends Mailable
{
    use Queueable, SerializesModels;

    public $file_name ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $result["success"] = Cache::pull($this->file_name."_success");
        $result["fail"] = Cache::pull($this->file_name."_fail");
        return $this->markdown('emails.importResult')->with("result",$result);
    }
}
