<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kendaraanModels extends Model
{
    use HasFactory;

    protected $table = 'vehicles';


    protected $fillable = [
        'nomor_plat',
        'tahun',
        'model_kendaraan',
        'vendor_kendaraan',
        'brand_kendaraan',
        'expire_tax',
        'expire_plat',
        'expire_kir'
    ];


        public function riwayatOddo()
    {
        return $this->hasOne(OddoHistoryModels::class,'vehicles_id');
    }

}
