<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AP_PurchaseDetails extends Model
{
    use HasFactory;

    protected $connection = "ascend";
    protected $table = "dbo.AP_PurchaseDetails";
    protected $primaryKey = 'PurchaseDetailID';

    protected $casts = [];

    public function item()
    {
        return $this->belongsTo(IC_Items::class, 'ItemID', 'ItemID');
    }
}
