<?php namespace Arx\classes;


use Swift_Mailer;
use Swift_SmtpTransport as SmtpTransport;
use Swift_MailTransport as MailTransport;
use Swift_SendmailTransport as SendmailTransport;
use Swift_Message;

/**
 * Class Mail
 *
 * Mail class usable outside Laravel
 *
 * @package Arx\classes
 */
class Mail extends Singleton {
    /**
     * Swift mailer instance.
     *
     * @var \Swift_Mailer
     */
    protected $_mailer;

    protected $_transport;

    protected $_message;
    
    // --- Private members
    private static $_aInstances = array();

    public static function config($param = array()){

        $default = array(

            'driver' => 'smtp',

            'host' => getenv('SERVER_NAME'),

            'port' => 25,

            'from' => array('address' => 'no-reply@'.getenv('SERVER_NAME'), 'name' => 'No Reply'),

            'encryption' => 'tls',

            'username' => '',

            'password' => '',

            'sendmail' => '/usr/sbin/sendmail -bs',

            'pretend' => false,

        );

        $config = Arr::merge($default, $param);

        $t = self::getInstance();

        switch ($config['driver'])
        {
            case 'smtp':
                extract($config);

                // The Swift SMTP transport instance will allow us to use any SMTP backend
                // for delivering mail such as Sendgrid, Amazon SMS, or a custom server
                // a developer has available. We will just pass this configured host.
                $transport = SmtpTransport::newInstance($config['host'], $config['port']);

                if (isset($config['encryption']))
                {
                    $transport->setEncryption($config['encryption']);
                }

                // Once we have the transport we will check for the presence of a username
                // and password. If we have it we will set the credentials on the Swift
                // transporter instance so that we'll properly authenticate delivery.
                if (isset($username))
                {
                    $transport->setUsername($config['username']);

                    $transport->setPassword($config['password']);
                }

                $t->_transport = $transport;
             break;

            case 'sendmail':
                $t->_transport = SendmailTransport::newInstance($config['sendmail']);
                break;

            case 'mail':
                $t->_transport = MailTransport::newInstance();
                break;

            default:
                throw new \InvalidArgumentException('Invalid mail driver.');
        }

        $t->_mailer = Swift_Mailer::newInstance($t->_transport);


        return $t;
    }

    public static function message(){
        return \Swift_Message::newInstance();
    }

    public static function send($mView, array $data = array(), $callback = null){
        $t = self::getInstance();

        if($mView instanceof \Swift_Message){
            $message = $mView;
        } else {
            Throw new \Exception('This feature is not yet available sorry!');
        }

        return $t->_mailer->send($message);
    }

    /**
     * Get Instance
     * @return mixed
     */
    public static function getInstance(){
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    }
    
} 