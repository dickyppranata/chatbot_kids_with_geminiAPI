<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Relasi: Topic memiliki banyak prompt (Few-Shot).
     */
    public function prompts(): HasMany
    {
        return $this->hasMany(Prompt::class);
    }

    /**
     * Relasi: Topic memiliki banyak contoh pertanyaan (Example Prompts).
     */
    public function examplePrompts(): HasMany
    {
        return $this->hasMany(ExamplePrompt::class);
    }

    /**
     * Relasi: Topic memiliki banyak chat sessions.
     */
    public function chatSessions(): HasMany
    {
        return $this->hasMany(ChatSession::class);
    }
}
