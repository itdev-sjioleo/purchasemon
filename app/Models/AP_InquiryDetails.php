<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AP_InquiryDetails extends Model
{
    use HasFactory;

    protected $connection = "ascend";
    protected $table = "dbo.AP_InquiryDetails";
    protected $primaryKey = 'InquiryDetailID';

    public function item()
    {
        return $this->belongsTo(IC_Items::class, 'ItemID', 'ItemID');
    }

    public function itemUOM()
    {
        return IC_UOM::find(IC_Items::find($this->ItemID)->{'UOMID'.$this->UOMLevel})->UOMCode;        
    }    
}
