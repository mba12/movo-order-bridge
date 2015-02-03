<?php

class Charity extends \Eloquent
{
    protected $fillable = [];

    public static function getList()
    {
        if (Cache::has("charities")) {
            return Cache::get("charities");
        }
        $charities = Charity::where("active", "=", 1)->get();
        Cache::put("charities", $charities, 1440);
        return $charities;
    }
}