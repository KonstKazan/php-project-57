<?php

namespace App\Models;

use Database\Factories\LabelFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @method static find(int $int)
 * @method static where(string $string, string $string1)
 */
class Label extends Model
{
    /** @use HasFactory<LabelFactory> */
    use HasFactory;
    use Notifiable;

    protected $fillable = ['name', 'description'];
//    protected $dateFormat = 'd.m.Y';

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }

    public function attributes(): array
    {
        return [
            'name' => 'Метка'
        ];
    }

    public function getCreatedAtAttribute(mixed $value): string
    {
        return Carbon::parse($value)->format('d.m.Y');
    }
}
