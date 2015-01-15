<?php

class Charity extends \Eloquent
{
    protected $fillable = [];

    public static function getList()
    {
        if (Cache::has("charities")) {
            return Cache::get("charities");
        }
        $charities = Charity::all();
        Cache::put("charities", $charities, 1440);
        return $charities;
    }
}