<?php

namespace Rvanmarkus\Modxmodels;


use Illuminate\Database\Eloquent\Model;

class ModxTemplateVar extends Model{

    protected $table = 'modx_site_tmplvars';


    public function getOutputPropertiesAttribute(){
        return json_decode($this->attributes['output_properties']);
    }

    public function setInputPropertiesAttribute($value)
    {
        $this->attributes['output_properties'] = json_encode($value);
    }


}
