<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reminder;
use App\Notifications\ReminderNotification;
use Carbon\Carbon;

class SendReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Envía recordatorios automáticos a los usuarios antes de sus eventos';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $reminders = Reminder::where('reminder_time', '<=', $now)
                             ->where('sent', false) // Solo enviar recordatorios no enviados
                             ->get();

        foreach ($reminders as $reminder) {
            $user = $reminder->user;
            if ($user) {
                $user->notify(new ReminderNotification($reminder));

                // Marcar como enviado
                $reminder->sent = true;
                $reminder->save();

                $this->info('Recordatorio enviado a: ' . $user->email);
            }
        }
    }
}

