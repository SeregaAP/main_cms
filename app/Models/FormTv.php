<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormTv extends Model
{
    protected $table = 'forms_tv';

    protected $fillable = ['template_id','name','caption','form'];


    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function documentTvs()
    {
        return $this->hasMany(DocumentTv::class, 'form_tv_id');
    }
}