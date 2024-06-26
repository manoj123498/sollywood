<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReferralTranslation
 *
 * @property int $id
 * @property int $referral_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @property string|null $faq
 * @property Referral|null $referral
 * @method static Builder|ReferralTranslation actualTranslation($lang)
 * @method static Builder|ReferralTranslation newModelQuery()
 * @method static Builder|ReferralTranslation newQuery()
 * @method static Builder|ReferralTranslation query()
 * @method static Builder|ReferralTranslation whereDescription($value)
 * @method static Builder|ReferralTranslation whereFaq($value)
 * @method static Builder|ReferralTranslation whereId($value)
 * @method static Builder|ReferralTranslation whereLocale($value)
 * @method static Builder|ReferralTranslation whereReferralId($value)
 * @method static Builder|ReferralTranslation whereTitle($value)
 * @method static Builder|ReferralTranslation whereDeletedAt($value)
 * @mixin Eloquent
 */
class ReferralTranslation extends Model
{
    protected $guarded = ['id'];
}
