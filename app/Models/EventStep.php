<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class EventStep extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'event_steps';

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        protected $primaryKey = 'id';
        protected $fillable = ['event_id','event_step','step_description','step_order','step_owner'];

        protected $dates = ['created_at', 'updated_at'];
}
