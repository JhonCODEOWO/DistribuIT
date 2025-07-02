<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'stock', 'url_image', 'product_status_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images(): MorphToMany{
        return $this->morphToMany(Image::class, 'imageable');
    }

    protected static function booted(){
        static::creating(function(Product $product){
            $product->slug = strtolower(str_replace(" ", "_", $product->name));
        });

        static::updating(function(Product $product) {
            //Create slug
            $slug = strtolower(str_replace(" ", "_", $product->name));
            $count = 1;

            if(Product::where('slug', $slug)->exists()) $slug = $slug . '-' . $count++;
            $product->slug = $slug;
        });
    }

    public function productStatus(){
        return $this->belongsTo(ProductStatus::class);
    }

    public function sales(){
        return $this->belongsToMany(Sale::class)->withPivot('quantity', 'subtotal');
    }
}
