<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Carbon;

class Model extends BaseModel
{
    public function formatDate($attribute)
    {
        return (new Carbon($this->{$attribute}))->format('d/m/Y H:i');
    }
}
