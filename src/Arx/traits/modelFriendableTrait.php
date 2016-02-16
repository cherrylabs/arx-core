<?php namespace Arx\traits;

use Arx\models\FriendModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class modelUtilsTrait
 *
 * Some usefull modelUtilsTrait to use in your model
 *
 * @package Arx\traits
 */
trait modelFriendableTrait
{
    public function getFriendModel(){

        if (property_exists($this, 'friendship_table')) {
            return $this->friendship_table;
        }

        return FriendModel::class;
    }

    public function friends()
    {
        return $this->morphMany($this->getFriendModel(), 'sender');
    }

    public function befriend(Model $recipient)
    {
        if ($this->isFriendsWith($recipient)) {
            return;
        }

        $model = $this->getFriendModel();

        $friendship = (new $model)->fill([
            'recipient_id' => $recipient->id,
            'recipient_type' => get_class($recipient),
            'status' => self::STATUS_FRIENDABLE_PENDING,
        ]);

        $this->friends()->save($friendship);

        return $friendship;
    }

    public function unfriend(Model $recipient)
    {
        if (!$this->isFriendsWith($recipient)) {
            return;
        }

        return $this->findFriendship($recipient)->delete();
    }

    public function isFriendsWith(Model $recipient, $status = null)
    {
        $exists = $this->findFriendship($recipient);

        if (!empty($status)) {
            $exists = $exists->where('status', $status);
        }

        return $exists->count();
    }

    public function acceptFriendRequest(Model $recipient)
    {
        if (!$this->isFriendsWith($recipient)) {
            return;
        }

        return $this->findFriendship($recipient)->update([
            'status' => STATUS_FRIENDABLE_ACCEPTED,
        ]);
    }

    public function denyFriendRequest(Model $recipient)
    {
        if (!$this->isFriendsWith($recipient)) {
            return;
        }

        return $this->findFriendship($recipient)->update([
            'status' => static::STATUS_FRIENDABLE_DENIED,
        ]);
    }

    public function blockFriendRequest(Model $recipient)
    {
        if (!$this->isFriendsWith($recipient)) {
            return;
        }

        return $this->findFriendship($recipient)->update([
            'status' => static::STATUS_FRIENDABLE_BLOCKED,
        ]);
    }

    public function unblockFriendRequest(Model $recipient)
    {
        if (!$this->isFriendsWith($recipient)) {
            return;
        }

        return $this->findFriendship($recipient)->update([
            'status' => static::STATUS_FRIENDABLE_PENDING,
        ]);
    }

    public function getFriendship($recipient)
    {
        return $this->findFriendship($recipient)->first();
    }

    public function getAllFriendships($limit = null, $offset = null)
    {
        return $this->findFriendshipsByStatus(null, $limit, $offset);
    }

    public function getPendingFriendships($limit = null, $offset = 0)
    {
        return $this->findFriendshipsByStatus(static::STATUS_FRIENDABLE_PENDING, $limit, $offset);
    }

    public function getAcceptedFriendships($limit = null, $offset = 0)
    {
        return $this->findFriendshipsByStatus(static::STATUS_FRIENDABLE_ACCEPTED, $limit, $offset);
    }

    public function getDeniedFriendships($limit = null, $offset = 0)
    {
        return $this->findFriendshipsByStatus(static::STATUS_FRIENDABLE_DENIED, $limit, $offset);
    }

    public function getBlockedFriendships($limit = null, $offset = 0)
    {
        return $this->findFriendshipsByStatus(static::STATUS_FRIENDABLE_BLOCKED, $limit, $offset);
    }

    public function hasBlocked(Model $recipient)
    {
        return $this->getFriendship($recipient)->status === static::STATUS_FRIENDABLE_BLOCKED;
    }

    public function isBlockedBy(Model $recipient)
    {
        $friend = $this->getFriendModel();

        $friendship = $friend::where(function ($query) use ($recipient) {
            $query->where('sender_id', $this->id);
            $query->where('sender_type', get_class($this));

            $query->where('recipient_id', $recipient->id);
            $query->where('recipient_type', get_class($recipient));
        })->first();

        return $friendship ? ($friendship->status === static::STATUS_FRIENDABLE_BLOCKED) : false;
    }

    public function getFriendRequests()
    {
        $friend = $this->getFriendModel();

        return $friend::where(function ($query) {
            $query->where('recipient_id', $this->id);
            $query->where('recipient_type', get_class($this));
            $query->where('status', static::STATUS_FRIENDABLE_PENDING);
        })->get();
    }

    private function findFriendship(Model $recipient)
    {
        $friend = $this->getFriendModel();

        return $friend::where(function ($query) use ($recipient) {
            $query->where('sender_id', $this->id);
            $query->where('sender_type', get_class($this));

            $query->where('recipient_id', $recipient->id);
            $query->where('recipient_type', get_class($recipient));
        })->orWhere(function ($query) use ($recipient) {
            $query->where('sender_id', $recipient->id);
            $query->where('sender_type', get_class($recipient));

            $query->where('recipient_id', $this->id);
            $query->where('recipient_type', get_class($this));
        });
    }

    private function findFriendshipsByStatus($status, $limit, $offset)
    {
        $friendships = [];
        $friend = $this->getFriendModel();

        $query = $friend::where(function ($query) use ($status) {
            $query->where('sender_id', $this->id);
            $query->where('sender_type', get_class($this));

            if (!empty($status)) {
                $query->where('status', $status);
            }
        })->orWhere(function ($query) use ($status) {
            $query->where('recipient_id', $this->id);
            $query->where('recipient_type', get_class($this));

            if (!empty($status)) {
                $query->where('status', $status);
            }
        });

        if (!empty($limit)) {
            $query->take($limit);
        }

        if (!empty($offset)) {
            $query->skip($offset);
        }

        foreach ($query->get() as $friendship) {
            $friendships[] = $this->getFriendship($this->find(
                ($friendship->sender_id == $this->id)  ? $friendship->recipient_id : $friendship->sender_id
            ));
        }

        return $friendships;
    }
}