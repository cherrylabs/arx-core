<?php namespace Arx\interfaces;

use Illuminate\Database\Eloquent\Model;

interface FriendableInterface
{

    public function friends();

    public function befriend(Model $recipient);

    public function unfriend(Model $recipient);

    public function isFriendsWith(Model $recipient, $status = null);

    public function acceptFriendRequest(Model $recipient);

    public function denyFriendRequest(Model $recipient);

    public function blockFriendRequest(Model $recipient);

    public function unblockFriendRequest(Model $recipient);

    public function getFriendship($recipient);

    public function getAllFriendships($limit = null, $offset = null);

    public function getPendingFriendships($limit = null, $offset = 0);

    public function getAcceptedFriendships($limit = null, $offset = 0);

    public function getDeniedFriendships($limit = null, $offset = 0);

    public function getBlockedFriendships($limit = null, $offset = 0);

    public function hasBlocked(Model $recipient);

    public function isBlockedBy(Model $recipient);

    public function getFriendRequests();
}