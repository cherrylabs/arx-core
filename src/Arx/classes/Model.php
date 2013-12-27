<?php namespace Arx\classes;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * Class Model
 *
 * usable outside Laravel
 *
 * @todo make it usable outside a Laravel structure
 * @package Arx\classes
 */
class Model extends \Eloquent implements UserInterface, RemindableInterface{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    protected $fillable = array('email', 'password');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function crypt($value){
        return \Hash::make($value);
    }

    public static function login($email, $password){

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public static function loginPassword($password)
    {
        return \User::where('password', '=', $password)->find(1);
    }
}