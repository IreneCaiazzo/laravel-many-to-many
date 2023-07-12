<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function projects()
    {
        //hasMany si usa sul model della tabella che NON ha la chiave esterna in una relazione uno a molti, 
        //hasOne si usa sul model della tabella che NON ha la chiave esterna in una relazione uno a uno

        return $this->hasMany(Project::class);
    }
}
