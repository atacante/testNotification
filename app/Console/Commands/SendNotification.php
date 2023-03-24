<?php

namespace App\Console\Commands;

use App\Notifications\TestNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-notification {phone : The phone number} {email : The email address} {message : The message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and send a message via SMS and email';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $validator = $this->validate();

        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return;
        }

        $this->notify();

        $this->info('Message sent successfully!');

    }

    /**
     * @return \Illuminate\Validation\Validator
    */
    private function validate(): \Illuminate\Validation\Validator {
        return Validator::make([
            'phone' => $this->argument('phone'),
            'email' => $this->argument('email'),
            'message' => $this->argument('message'),
        ], [
            'phone' => 'required|string|min:10|max:10',
            'email' => 'required|email',
            'message' => 'required|string|max:100',
        ]);
    }

    /**
     * @return void
    */
    private function notify(): void {
        Notification::route('mail', $this->argument('email'))
            ->route('vonage', $this->argument('phone'))
            ->notify(new TestNotification($this->argument('message')));
    }
}
