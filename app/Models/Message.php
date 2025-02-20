<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Los atributos que son asignables
    protected $fillable = ['message', 'status'];

    // Los atributos que deben ser ocultados en los arrays
    protected $hidden = [];

    // Definir el estado inicial de los mensajes
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';

}
