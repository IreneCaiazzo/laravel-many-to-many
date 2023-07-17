<?php

namespace App\Models;

use App\Traits\Slugger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;
    use Slugger;

    public $timestamps = false;

    public function projects()
    {
        //hasMany si usa sul model della tabella che NON ha la chiave esterna in una relazione uno a molti, 
        //hasOne si usa sul model della tabella che NON ha la chiave esterna in una relazione uno a uno

        return $this->hasMany(Project::class);
    }
}
