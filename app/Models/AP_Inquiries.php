<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AP_Inquiries extends Model
{
    use HasFactory;

    protected $connection = "ascend";
    protected $table = "dbo.AP_Inquiries";
    protected $primaryKey = 'InquiryID';

    public function inqitems()
    {
        return $this->hasMany(AP_InquiryDetails::class, 'InquiryID', 'InquiryID');
    }
}
