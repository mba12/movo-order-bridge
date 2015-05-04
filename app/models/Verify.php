<?php

class Verify extends \Eloquent
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'key',
        'verified',
    ];

    public static function updateVerification($id, $verified)
    {
        $idVal = intval($id);
        $userV=Verify::find($idVal)->first();
        $userV->verified = boolval($verified);
        $userV->save();
    }

}
