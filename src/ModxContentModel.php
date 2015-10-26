<?php namespace Rvanmarkus\ModxModels;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Mockery\CountValidator\Exception;


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

    public function templateVariables(){

        return $this->belongsToMany('Rvanmarkus\Modxmodels\ModxTemplateVar',
            'modx_site_tmplvar_contentvalues', 'contentid','tmplvarid') ->withPivot('value');

    }

    public function getTemplateVariablesAttribute(){

            try {

                if (!isset($this->relations['templateVariables'])) {
                    $this->relations['templateVariables'] = $this->newQuery()->getRelation('TemplateVariables')->get();
                }

                return $this->relations['templateVariables']
                    ->keyBy(function ($aTemplateVar) {
                        return $aTemplateVar->name;
                    })
                    ->map(function ($aTemplateVar) {
                        return $this->castFromModxType($aTemplateVar);
                        //return $aTemplateVar;
                    });

            } catch (Exception $error){
                Throw new Exception($error);
            }
    }

    private function castFromModxType($aTemplateVar) {

        switch($aTemplateVar->type) {
            case "migx":
                return $aTemplateVar->value = json_decode($aTemplateVar->pivot->value);
                break;
            case "checkbox":
                return explode('||', $aTemplateVar->pivot->value);
                break;

            case "date":
                return new Carbon($aTemplateVar->pivot->value);
                break;

            default:
                return $aTemplateVar->pivot->value;
                break;
        }
    }
}
