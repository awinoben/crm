<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Snowfire\Beautymail\Beautymail;

class MailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $body;
    /**
     * @var string|null
     */
    private $url;
    /**
     * @var string|null
     */
    private $action;
    /**
     * @var string|null
     */
    private $url2;
    /**
     * @var string|null
     */
    private $action2;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $title
     * @param string $name
     * @param string $body
     * @param string|null $url
     * @param string|null $action
     * @param string|null $url2
     * @param string|null $action2
     */
    public function __construct(string $email, string $title, string $name, string $body, string $url = null, string $action = null, string $url2 = null, string $action2 = null)
    {
        $this->email = $email;
        $this->title = $title;
        $this->name = $name;
        $this->body = $body;
        $this->url = $url;
        $this->action = $action;
        $this->url2 = $url2;
        $this->action2 = $action2;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $beautymail = app()->make(Beautymail::class);
        $beautymail->send('emails.mail', [
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
            'action' => $this->action,
            'url2' => $this->url2,
            'action2' => $this->action2,
        ], function ($message) {
            $message
                ->from(env('MAIL_FROM_ADDRESS'))
                ->to($this->email, $this->name)
                ->subject($this->title);
        });
    }
}
