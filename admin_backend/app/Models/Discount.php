<?php

namespace App\Models;

use App\Traits\Loadable;
use App\Traits\SetCurrency;
use Database\Factories\DiscountFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Discount
 *
 * @property int $id
 * @property int $shop_id
 * @property string $type
 * @property float $price
 * @property string $start
 * @property string|null $end
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $img
 * @property-read Collection|ShopProduct[] $products
 * @property-read int|null $products_count
 * @method static DiscountFactory factory(...$parameters)
 * @method static Builder|Discount filter($array)
 * @method static Builder|Discount newModelQuery()
 * @method static Builder|Discount newQuery()
 * @method static Builder|Discount query()
 * @method static Builder|Discount whereActive($value)
 * @method static Builder|Discount whereCreatedAt($value)
 * @method static Builder|Discount whereEnd($value)
 * @method static Builder|Discount whereId($value)
 * @method static Builder|Discount whereImg($value)
 * @method static Builder|Discount wherePrice($value)
 * @method static Builder|Discount whereShopId($value)
 * @method static Builder|Discount whereStart($value)
 * @method static Builder|Discount whereType($value)
 * @method static Builder|Discount whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 */
class Discount extends Model
{
    use HasFactory, SetCurrency,Loadable;
    protected $guarded = [];
    protected $fillable = ['shop_id','type','price','start','end','active','img'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ShopProduct::class, ProductDiscount::class);
    }


    /* Filter Scope */
    public function scopeFilter($value, $array)
    {
        return $value
            ->when(isset($array['type']), function ($q) use ($array) {
                $q->where('type', $array['type']);
            })
            ->when(isset($array['active']), function ($q) use ($array) {
                $q->where('active', $array['active']);
            });
    }}
