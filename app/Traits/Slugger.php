<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Slugger
{
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
        return $slug;
    }
}
