<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property bool|mixed $created_by_id
 */
class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'description', 'status_id', 'assigned_to_id'];
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function executer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class);
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
