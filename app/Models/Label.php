<?php

namespace App\Models;

use Database\Factories\LabelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

/**
 * @method static find(int $int)
 * @method static where(string $string, string $string1)
 */
class Label extends Model
{
    /** @use HasFactory<LabelFactory> */
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'description'];

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
}
