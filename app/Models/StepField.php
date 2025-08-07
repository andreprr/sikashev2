<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class StepField extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'step_fields';

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        protected $primaryKey = 'id';
        protected $fillable = ['step_id','field_name','field_description','field_order','field_type','allowed_type','default_value','model_referer','need_verif','options','field_label','is_required'];

        protected $dates = ['created_at', 'updated_at'];
}
