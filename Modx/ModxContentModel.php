<?php namespace App\Modx;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;


class ModxContentModel extends Model {
    //
    protected $table = "modx_site_content";
    protected $with = [];

    /**
     * Get all date columns from database
     */
    public function getDates() {
        return ['editedon', 'pub_date', 'createdon', 'publishedon'];
    }

    public function scopePublished($query){
        return $query->where('publishedon','!=',0);
    }

    public function scopeNotDeleted($query){
        return $query->where('deleted','=',0);
    }

    public function scopeMenuindex($query){
        return $query->orderBy('menuindex', 'asc');
    }

    public function scopeSortPublished($query){
        return $query->orderBy('publishedon','desc');
    }

    public function templateVars(){
        return $this->belongsToMany('App\Modx\ModxTemplateVar', 'modx_site_tmplvar_contentvalues', 'contentid','tmplvarid')->withPivot('value');
    }

    public function getTemplateVariablesAttribute(){
        $aTemplateVars = array();
        foreach($this->templateVars as $aTemplateVar){

            $aTemplateVars[$aTemplateVar->name] = $aTemplateVar->pivot->value;

            if($aTemplateVar->type == "migx"){
                $aTemplateVars[$aTemplateVar->name] = json_decode($aTemplateVar->pivot->value);
            }
            if($aTemplateVar->type == "checkbox"){
                $aTemplateVars[$aTemplateVar->name] = explode('||', $aTemplateVar->pivot->value);

            }
        }
        return new Collection($aTemplateVars);
    }

}