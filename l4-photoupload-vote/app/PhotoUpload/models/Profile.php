<?php namespace PhotoUpload\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * Query the user that belongs to the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
  public function user()
    {
        return $this->belongsTo('\PhotoUpload\Models\User');
    }
}
