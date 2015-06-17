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

    /**
     * Scopes all published pages
     * @param $query
     * @return mixed
     */
    public function scopePublished($query){
        return $query->where('publishedon','!=',0);
    }

    /**
     * Scopes all deletes pages
     * @param $query
     * @return mixed
     *
     */
    public function scopeNotDeleted($query){
        return $query->where('deleted','=',0);
    }

    /**
     * Scopes all menu indexed
     * @param $query
     * @return mixed
     *
     */
    public function scopeMenuindex($query){
        return $query->orderBy('menuindex', 'asc');
    }


    /**
     * returns ORM Relation to Modx Template Variables
     * @return mixed
     */
    public function templateVars(){
        return $this->belongsToMany('App\Modx\ModxTemplateVar', 'modx_site_tmplvar_contentvalues', 'contentid','tmplvarid')->withPivot('value');
    }


    /**
     * Retuns a Eloquent collection with all template variables
     * @return Collection
     */
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