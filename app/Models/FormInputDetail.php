<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class FormInputDetail extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'form_input_details';

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        protected $primaryKey = 'id';
        protected $fillable = ['form_input_id','step_id','field_name','field_label','field_description','field_type','allowed_type','default_value','model_referer','need_verif','is_required','field_order','value','reason','isValid'];

        protected $dates = ['valid_at','created_at', 'updated_at'];
}
