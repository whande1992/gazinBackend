<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    /**
     * Disable timestamps
     */
    public  $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level_id', 'name', 'gender', 'birth_date', 'age', 'hobby'
    ];

    public function Level()
    {
        return $this->hasOne(Level::class, 'id','level_id');
    }


}
