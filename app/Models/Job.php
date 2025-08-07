<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'jobs';

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        protected $primaryKey = 'id';
        protected $fillable = ['job','start_date','end_date','description','opd_id','status'];
        protected $casts = [
            'type' => 'array',
            'study' => 'array'
        ];
        protected $dates = ['created_at', 'updated_at','published_at','deleted_at'];
}
