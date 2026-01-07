<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $counter_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Counter $counter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CounterEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CounterEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CounterEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CounterEntry whereCounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CounterEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CounterEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CounterEntry whereUpdatedAt($value)
 * @property string|null $note
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CounterEntry whereNote($value)
 * @mixin \Eloquent
 */
class CounterEntry extends Model
{

    protected $fillable = ['note'];
    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }
}
