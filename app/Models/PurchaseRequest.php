<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;
use Illuminate\Support\Carbon;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $connection = "ascend";
    protected $table = "dbo.AP_PR";
    protected $primaryKey = 'PRID';

    public function pritems()
    {
        return $this->hasMany(PurchaseRequestItem::class, 'PRID', 'PRID');
    }

    public function pos()
    {
        return PurchaseOrder::where('PRNumbers', 'LIKE', '%'.$this->PRNumber.'%')->where('Void', 0)->where('Closed', 0)->get();
    }

    public function requestby()
    {
        return $this->belongsTo(IC_InventoryUsers::class, 'InventoryUserID', 'InventoryUserID');
    }

    public function inquiries()
    {
        return $this->hasMany(AP_Inquiries::class, 'PRNumbers', 'PRNumber');
    }

}
