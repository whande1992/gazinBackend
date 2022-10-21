<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    /**
     * Disable timestamps
     */
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level'
    ];

    public function developers() {
        return $this->hasMany(Developer::class, 'level_id', 'id');
    }

    public function count_developers() {
        return $this->hasMany(Developer::class, 'level_id', 'id')->count();
    }
}
