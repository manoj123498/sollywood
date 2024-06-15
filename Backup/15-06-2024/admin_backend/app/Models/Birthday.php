<?php

namespace App\Models;

use App\Traits\Loadable;
use App\Traits\Reviewable;
use Database\Factories\UnitFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Unit
 *
 * @property int $id
 * @property Carbon|null $updated_at
 * @method static UnitFactory factory(...$parameters)
 * @method static Builder|Unit newModelQuery()
 * @method static Builder|Unit newQuery()
 * @method static Builder|Unit query()
 * @method static Builder|Unit whereActive($value)
 * @method static Builder|Unit whereCreatedAt($value)
 * @method static Builder|Unit whereId($value)
 * @method static Builder|Unit wherePosition($value)
 * @method static Builder|Unit whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Birthday extends Model
{
    use HasFactory, Loadable, Reviewable;

    protected $fillable = [
        'gift_amount',
    ];
    protected $table = 'gift_settings';
}
