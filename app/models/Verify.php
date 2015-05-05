<?php

class Verify extends \Eloquent
{
    protected $table = "verify";
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

    public function confirm($id, $key)
    {
        // Make sure the id value is a valid numeric to avoid exceptions
        if (!is_numeric($id)) {
            return false;
        }

        $storedId = intval($this->id);
        $storedKey = $this->key;
        $confirmed = false;
        if (intval($id) === $storedId && strcasecmp($key, $storedKey) == 0) {
            $confirmed = true;
            $this->verified = true;
            $this->save();
        }
        return $confirmed;
    }

}
