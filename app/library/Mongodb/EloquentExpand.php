<?php

class MoloquentExpand{
    /**
     * increment record's column value if exists or insert new record.
     *
     * @param  array  $values
     * @param  array  $options
     * @return int
     */
    public function incrementUpsert($column, $amount = 1, array $where = array(), array $extra = array())
    {   
        $db = DB::connection('mongodb')->collection($this->table);
        $query = array('$inc' => array($column => $amount));

        if ( ! empty($extra))
        {
            $query['$set'] = $extra;
        }
       
        // Protect
        $db->where(function($query) use ($column)
        {
            $query->where($column, 'exists', false);

            $query->orWhereNotNull($column);
        });

        if( ! empty($where))
        {
            $db->where($where);
        }

        return $db->update($query, array('upsert' => true, 'multiple' => 0));

    }
    /**
     * Decrement a column's value by a given amount.
     *
     * @param  string  $column
     * @param  int     $amount
     * @param  array   $extra
     * @return int
     */
    public function decrementUpsert($column, $amount = 1, array $extra = array())
    {
        return $this->incrementUpsert($column, -1 * $amount, $extra);
    }

}