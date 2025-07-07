<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ["url"];
    protected $appends = ["url_resource"];
    public function products(): MorphToMany{
        return $this->morphedByMany(Product::class, 'imageable');
    }

    protected function urlResource(): Attribute{
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => env('APP_URL').Storage::url('global/'.$attributes['url'])
        );
    }
}
