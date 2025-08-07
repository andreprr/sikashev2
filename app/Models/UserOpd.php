<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class UserOpd extends Model
{
    use HasFactory;

    protected $table = 'user_opd';

        /**
         * The primary key associated with the table.
         *
         * @var string
         */

        protected $fillable = ['opd_id', 'user_id'];

        protected $dates = ['created_at', 'updated_at'];
}
