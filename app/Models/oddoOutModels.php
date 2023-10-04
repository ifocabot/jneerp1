<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class oddoOutModels extends Model
{
    use HasFactory;

    protected $table = 'oddoout';

    protected $id = 'id';

    protected $fillable = ['oddo_meter_out', 'foto_oddo_out', 'areas_id', 'vehicles_id', 'safetytools_id'];


    public function riwayatOddo()
    {
        return $this->hasOne(OddoHistoryModels::class,'oddoout_id');
    }
}
