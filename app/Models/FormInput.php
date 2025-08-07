<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class FormInput extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'form_inputs';

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        protected $primaryKey = 'id';
        protected $fillable = ['uniq_id','user_id','submit_id','current_step','status','current_step_at','event_id','job_id'];
        protected $dates = ['created_at', 'updated_at'];
}
