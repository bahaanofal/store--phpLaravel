<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use NumberFormatter;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS_ACTIVE = 'active';
    const STATUS_DRAFT = 'draft';

    protected $fillable = [
        'name', 'slug', 'category_id', 'description', 'image_path', 'price', 'sale_price',
         'quantity', 'sku', 'width', 'height', 'length', 'weight', 'status'
    ];


    // Global Scope
    protected static function booted()
    {
        // static::addGlobalScope('active', function(Builder $builder)
        // {
        //     $builder->where('status', '=', 'active');
        // });
    }

    // Local Scope
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }
    
    public function scopePrice(Builder $builder, $from, $to)
    {
        $builder->where('price', '>=', $from)->where('price', '<=', $to);
    }

    // Validation Rules
    public static function validateRules() 
    {
        return [
            'name' => 'required|max:255',
            'category_id' => 'required|int|exists:categories,id',
            'description' => 'nullable',
            'image' => 'nullable|image|dimensions:min_width=100,min_height=100',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|int|min:0',
            'sku' => 'nullable|unique:products,sku',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'in:' . self::STATUS_ACTIVE . ',' . self::STATUS_DRAFT,
        ];
    }

    // Accessor
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return asset('images/placeholder.png');
        }

        if(stripos($this->image_path, 'http') === 0) {
            return $this->image_path;
        }

        return asset('storage/' . $this->image_path);
    }

    public function getFormattedPriceAttribute($value)
    {
        $formatter = new NumberFormatter(App::getLocale(), NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($this->price, 'USD');
    }

    // Mutator
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::title($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable', 'rateable_type', 'rateable_id', 'id');
    }
}
