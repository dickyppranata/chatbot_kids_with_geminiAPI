<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamplePrompt extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'question_text',
    ];

    /**
     * Relasi: ExamplePrompt dimiliki oleh Topic.
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}
