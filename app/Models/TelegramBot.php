<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Telegram\Bot\Traits\Telegram;

class TelegramBot extends Model
{
    use HasFactory, Telegram;
}
