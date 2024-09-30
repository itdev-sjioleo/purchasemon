<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $connection = "ascend";
    protected $table = "dbo.AP_PurchaseOrders";
    protected $primaryKey = 'POID';

    public function poitems()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'POID', 'POID');
    }

    public function pis()
    {
        return AP_Purchases::where('PONumbers', 'LIKE', '%'.$this->PONumber.'%')->where('Void', 0)->get();
    }
}
