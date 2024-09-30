<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class AP_Purchases extends Model
{
    use HasFactory;

    protected $connection = "ascend";
    protected $table = "dbo.AP_Purchases";
    protected $primaryKey = 'PurchaseID';

    protected $casts = [];

    public function piitems()
    {
        return $this->hasMany(AP_PurchaseDetails::class, 'PurchaseID', 'PurchaseID');
    }
}
