<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importe este

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recebedor_user_id',
        'tipo',
        'valor',
        'status',
    ];

    protected $casts = [
        'valor' => 'decimal:2', // Casting para garantir a precisão ao trabalhar com o modelo
    ];

    /**
     * Get the user who sent the transaction.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who received the transaction.
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recebedor_user_id');
    }
}