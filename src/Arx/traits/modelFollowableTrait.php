<?php namespace Arx\traits;

use Arx\models\FollowModel;

/**
 * Class modelUtilsTrait
 *
 * Some usefull modelUtilsTrait to use in your model
 *
 * @package Arx\traits
 */
trait modelFollowableTrait
{

    public function getFollowModel(){

        if (property_exists($this, 'follows_table')) {
            return $this->follows_table;
        }

        return FollowModel::class;
    }


    public function follows($type, $id = null){

        $type = $this->resolveFollowableRelation($type);

        if ($id) {
            $type = (new $type)->getKey();
        }

        $this->followed()->save($type);

        return $this->followed;
    }

    public function unfollows($type, $id = null){

        $type = $this->resolveFollowableRelation($type);

        if ($id) {
            $type = (new $type)->getKey();
        }

        $this->followed()->detach($type);

        return $this->followed;
    }

    /**
     * @param null $type
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function followed($type = null){
        $type = $this->resolveFollowableRelation($type);

        $result = $this->morphMany($this->getFollowModel(), 'follower', $type);

        return $result;
    }

    /**
     * @param null $type
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function follower($type = null)
    {
        $type = $this->resolveFollowableRelation($type);

        return $this->morphMany($this->getFollowModel(), "followed", $type);
    }

    public function resolveFollowableRelation($type){

        if (property_exists($this, 'followable')) {
            if(isset($this->followable[$type])){
                $type = $this->followable[$type];
            }
        }

        return $type;
    }
}