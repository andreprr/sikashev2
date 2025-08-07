<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessCategory extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'business_categories';

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        protected $primaryKey = 'id';
        protected $fillable = ['name','description'];

        protected $dates = ['created_at', 'updated_at'];
}
