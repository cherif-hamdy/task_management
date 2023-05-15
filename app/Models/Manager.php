<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function employees() : HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
