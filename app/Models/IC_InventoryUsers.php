<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IC_InventoryUsers extends Model
{
    use HasFactory;

    protected $connection = "ascend";
    protected $table = "dbo.IC_InventoryUsers";
    protected $primaryKey = 'InventoryUserID';
}
