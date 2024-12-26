<?php

namespace App\Models;

use Database\Factories\TaskStatusFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class TaskStatus extends Model
{
    /** @use HasFactory<TaskStatusFactory> */
    use HasFactory, Notifiable;

    protected $fillable = ['name'];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'status_id');
    }

//    protected $dateFormat = 'd.m.Y';
//    protected function serializeDate(DateTimeInterface $date): string
//    {
//        return $date->format('d.m.Y');
//    }
    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('d.m.Y');
    }
}
