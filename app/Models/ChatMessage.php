<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatMessage extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * @var list<string>
     */
    protected $fillable = [
        'chat_session_id',
        'sender_type',
        'message',
    ];

    /**
     * Relasi: ChatMessage dimiliki oleh ChatSession.
     */
    public function chatSession(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class);
    }

    /**
     * Relasi: ChatMessage memiliki banyak data favorit.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
