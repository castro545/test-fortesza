<?php

namespace App\Models;
//namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Los atributos que son asignables en su totalidad.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'receiver_id', 'message', 'sent_at','attachment',
    ];

    /**
     * Relación con la tabla de usuarios.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relación con la tabla de usuarios.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
