<?php

namespace App\Models;

use App\Models\Type;
use App\Models\Technology;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

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

    public static function slugger($string)
    {
        //Project::slugger($title)

        //generare slug base
        $baseSlug = Str::slug($string);
        $i = 1;

        $slug = $baseSlug;

        //finchè lo slug generato è presente nella tabella
        while (self::where('slug', $slug)->first()) {
            //genera un nuovo slug concatenando il contatore
            $slug = $baseSlug . '-' . $i;
            //incrementa il contatore
            $i++;
        }

        //ritornare lo slug trovato
    }
}
