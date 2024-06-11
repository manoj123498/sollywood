<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Settings;
use App\Traits\Loggable;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class BaseImport
{
    use Loggable;

    /**
     * @param Product|Model $model
     * @param string|null $imgUrls
     * @return bool
     */
    protected function downloadImages(mixed $model, ?string $imgUrls): bool
    {
        try {

            if (empty($imgUrls)) {
                return false;
            }

            $urls = explode(',', $imgUrls);

            $images  = [];
            $storage = [];

            foreach ($urls as $url) {

                if (str_contains($url, 'http://') || str_contains($url, 'https://')) {
                    $images[] = file_get_contents($url,'test');
                }

                $dir      = Str::lower(str_replace('App\Models\\', '', get_class($model)));

                $lastChar = mb_substr($dir, -1);

                $dir      = $lastChar === 'y' ? substr_replace($dir, '', -1) . 'ies' : $dir . 's';

                $date     = Str::slug(Carbon::now()->format('Y-m-d h:i:s')) . Str::random(6);

                $name     = substr(strrchr(Str::replace(['https://', 'http://'], '', $url), "."), 1);

                foreach ($images as $image) {

                    $storage[] = "$dir/$date.$name";

                    $isAws = Settings::adminSettings()->where('key', 'aws')->first()?->value;

                    Storage::disk($isAws ? 's3' : 'public')->put("images/$dir/$date.$name", $image, 'public');
                }

            }

            DB::transaction(function () use ($model, $storage) {
                $model?->galleries()->delete();

                $model?->update(['img' => data_get($storage, 0)]);

                $model?->uploads($storage);
            });

            return true;
        } catch (Throwable $e) {
            $this->error($e);
        }

        return false;
    }
}
