<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    // هذه القيم الافتراضية التي تستخدمها لارافيل، يعني مش ضروري أكتبها
    // لكن هذه الطريقة لتغيير القيم الافتراضية لقيم أخرى

    const CREATED_AT = 'created_at'; // لو بدك تغير اسم العمود في قاعدة البيانات
    const UPDATED_AT = 'updated_at';
    
    protected $connection = 'mysql'; // لو بدك تغير القيم
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'int';

    public $incrementation = true; // يعني استخدمهم بالجدول
    public $timestamps = true;

    protected $fillable = [
        'name', 'slug', 'parent_id', 'description', 'status'
    ];



    // Accessors : get{attributeName}Attribute
    // Exists Attribute
    // $model->name
    public function getNameAttribute($value)
    {
        if ($this->trashed()) {
            return $value . ' (Deleted)';
        }
        return $value;
    }

    // Non-exists Attribute
    // $model->original_name
    public function getOriginalNameAttribute()
    {
        return $this->attributes['name'];
    }

}
