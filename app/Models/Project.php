<?php

namespace App\Models;

use App\Models\Type;
use App\Traits\Slugger;
use App\Models\Technology;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    use Slugger;

    public function getRouteKey()
    {
        return $this->slug;
    }

    public function type()
    {
        //belongsTo si usa nel model della tabella della chiave esterna (quella che sta dala parte del 'molti')
        return $this->belongsTo(Type::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
}
