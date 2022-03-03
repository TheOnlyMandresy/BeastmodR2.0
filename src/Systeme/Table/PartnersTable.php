<?php

namespace Systeme\Table;

use Systeme;

class PartnersTable extends Table
{
    protected static $table = 'partners';

    public static function all ()
    {
        return static::find(null, null, true);
    }

    public static function getPartner ($id)
    {
        $statement = [
            'where' => 'id = ?',
            'att' => $id
        ];
        
        return static::find($statement);
    }

    public function getUrl ()
    {
        return '/events/' .$this->id;
    }
}