<?php namespace Rvanmarkus\Modxmodels;


trait PageTrait {

    /**
     * Boot the scope.
     *
     * @return void
     */
    public static function bootPageTrait()
    {
        static::addGlobalScope(new PageScope());
    }

    /**
     * Get the name of the column for applying the scope.
     *
     * @return string
     */
    public function getParentColumn()
    {
        return defined('static::PARENT_COLUMN') ? static::PARENT_COLUMN : 'template';
    }


    /**
     * @return int ID of the MODX template
     * @throws \Exception if there is no MODX_TEMPLATE_ID const in the model
     */
    public function getParentColumnValue()
    {
        if(defined('static::MODX_TEMPLATE_ID'))
        {
          return static::MODX_TEMPLATE_ID;
        } else {
            throw new \Exception('MODX_TEMPLATE_ID contant not found in Model');
        }
    }

    /**
     * Get the fully qualified column name for applying the scope.
     *
     * @return string
     */
    public function getQualifiedParentColumn()
    {
        return $this->getTable().'.'.$this->getParentColumn();
    }

    /**
     * Get the query builder without the scope applied.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withDrafts()
    {
        return with(new static)->newQueryWithoutScope(new PageScope());
    }
}
