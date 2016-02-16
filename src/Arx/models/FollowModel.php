<?php namespace Arx\models;

use Illuminate\Database\Eloquent\Model;

class FollowModel extends Model
{
    protected $table = 'follows';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function followed()
    {
        return $this->morphTo('followed');
    }

    public function follower()
    {
        return $this->morphTo('follower');
    }
}