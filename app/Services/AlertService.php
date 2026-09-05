<?php

namespace App\Services;

class AlertService
{
    public static function created(string $message): void
    {
        session()->flash('alert', [
            'type' => 'success',
            'message' => $message,
        ]);
    }

    public static function updated(string $message): void
    {
        session()->flash('alert', [
            'type' => 'success',
            'message' => $message,
        ]);
    }

    public static function deleted(string $message): void
    {
        session()->flash('alert', [
            'type' => 'success',
            'message' => $message,
        ]);
    }

    public static function error(string $message): void
    {
        session()->flash('alert', [
            'type' => 'error',
            'message' => $message,
        ]);
    }
}
