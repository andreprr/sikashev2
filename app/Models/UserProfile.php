<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_profiles';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    
    protected $fillable = ['user_id','nik','nip','gender','phone','birth_date','address','pangkat','satker','instansi','jabatan','pendidikan','img_url']; 

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(Users::class, 'id', 'user_id');
    }
}
