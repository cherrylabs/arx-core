<?php

require_once __DIR__.DS. 'PHPMailer' . DS . 'class.phpmailer.php';

class a_PHPmailer extends PHPMailer
{
      /////////////////////////////////////////////////
  // PROPERTIES, PUBLIC
  /////////////////////////////////////////////////

  /**
   * Email priority (1 = High, 3 = Normal, 5 = low).
   * @var int
   */
  public $Priority          = 3;

  /**
   * Sets the CharSet of the message.
   * @var string
   */
  public $CharSet           = 'utf-8';

  /**
   * Sets the Content-type of the message.
   * @var string
   */
  public $ContentType       = 'text/plain';

  /**
   * Sets the Encoding of the message. Options for this are
   *  "8bit", "7bit", "binary", "base64", and "quoted-printable".
   * @var string
   */
  public $Encoding          = '8bit';

  /**
   * Holds the most recent mailer error message.
   * @var string
   */
  public $ErrorInfo         = '';

  /**
   * Sets the From email address for the message.
   * @var string
   */
  public $From              = 'root@localhost';

  /**
   * Sets the From name of the message.
   * @var string
   */
  public $FromName          = 'Root User';

  /**
   * Sets the Sender email (Return-Path) of the message.  If not empty,
   * will be sent via -f to sendmail or as 'MAIL FROM' in smtp mode.
   * @var string
   */
  public $Sender            = '';

  /**
   * Sets the Subject of the message.
   * @var string
   */
  public $Subject           = '';

  /**
   * Sets the Body of the message.  This can be either an HTML or text body.
   * If HTML then run IsHTML(true).
   * @var string
   */
  public $Body              = '';

  /**
   * Sets the text-only body of the message.  This automatically sets the
   * email to multipart/alternative.  This body can be read by mail
   * clients that do not have HTML email capability such as mutt. Clients
   * that can read HTML will view the normal Body.
   * @var string
   */
  public $AltBody           = '';

  /**
   * Stores the complete compiled MIME message body.
   * @var string
   * @access protected
   */
  protected $MIMEBody       = '';

  /**
   * Stores the complete compiled MIME message headers.
   * @var string
   * @access protected
   */
  protected $MIMEHeader     = '';

  /**
   * Stores the complete sent MIME message (Body and Headers)
   * @var string
   * @access protected
  */
  protected $SentMIMEMessage     = '';

  /**
   * Sets word wrapping on the body of the message to a given number of
   * characters.
   * @var int
   */
  public $WordWrap          = 0;

  /**
   * Method to send mail: ("mail", "sendmail", or "smtp").
   * @var string
   */
  public $Mailer            = 'mail';

  /**
   * Sets the path of the sendmail program.
   * @var string
   */
  public $Sendmail          = '/usr/sbin/sendmail';

  /**
   * Path to PHPMailer plugins.  Useful if the SMTP class
   * is in a different directory than the PHP include path.
   * @var string
   */
  public $PluginDir         = '';

  /**
   * Sets the email address that a reading confirmation will be sent.
   * @var string
   */
  public $ConfirmReadingTo  = '';

  /**
   * Sets the hostname to use in Message-Id and Received headers
   * and as default HELO string. If empty, the value returned
   * by SERVER_NAME is used or 'localhost.localdomain'.
   * @var string
   */
  public $Hostname          = '';

  /**
   * Sets the message ID to be used in the Message-Id header.
   * If empty, a unique id will be generated.
   * @var string
   */
  public $MessageID         = '';

  /////////////////////////////////////////////////
  // PROPERTIES FOR SMTP
  /////////////////////////////////////////////////

  /**
   * Sets the SMTP hosts.  All hosts must be separated by a
   * semicolon.  You can also specify a different port
   * for each host by using this format: [hostname:port]
   * (e.g. "smtp1.example.com:25;smtp2.example.com").
   * Hosts will be tried in order.
   * @var string
   */
  public $Host          = 'localhost';

  /**
   * Sets the default SMTP server port.
   * @var int
   */
  public $Port          = 25;

  /**
   * Sets the SMTP HELO of the message (Default is $Hostname).
   * @var string
   */
  public $Helo          = '';

  /**
   * Sets connection prefix.
   * Options are "", "ssl" or "tls"
   * @var string
   */
  public $SMTPSecure    = '';

  /**
   * Sets SMTP authentication. Utilizes the Username and Password variables.
   * @var bool
   */
  public $SMTPAuth      = false;

  /**
   * Sets SMTP username.
   * @var string
   */
  public $Username      = '';

  /**
   * Sets SMTP password.
   * @var string
   */
  public $Password      = '';

  /**
   * Sets the SMTP server timeout in seconds.
   * This function will not work with the win32 version.
   * @var int
   */
  public $Timeout       = 10;

  /**
   * Sets SMTP class debugging on or off.
   * @var bool
   */
  public $SMTPDebug     = false;

  /**
   * Prevents the SMTP connection from being closed after each mail
   * sending.  If this is set to true then to close the connection
   * requires an explicit call to SmtpClose().
   * @var bool
   */
  public $SMTPKeepAlive = false;

  /**
   * Provides the ability to have the TO field process individual
   * emails, instead of sending to entire TO addresses
   * @var bool
   */
  public $SingleTo      = false;

   /**
   * If SingleTo is true, this provides the array to hold the email addresses
   * @var bool
   */
  public $SingleToArray = array();

 /**
   * Provides the ability to change the line ending
   * @var string
   */
  public $LE              = "\n";

  /**
   * Used with DKIM DNS Resource Record
   * @var string
   */
  public $DKIM_selector   = 'phpmailer';

  /**
   * Used with DKIM DNS Resource Record
   * optional, in format of email address 'you@yourdomain.com'
   * @var string
   */
  public $DKIM_identity   = '';

  /**
   * Used with DKIM DNS Resource Record
   * @var string
   */
  public $DKIM_passphrase   = '';

  /**
   * Used with DKIM DNS Resource Record
   * optional, in format of email address 'you@yourdomain.com'
   * @var string
   */
  public $DKIM_domain     = '';

  /**
   * Used with DKIM DNS Resource Record
   * optional, in format of email address 'you@yourdomain.com'
   * @var string
   */
  public $DKIM_private    = '';

  /**
   * Callback Action function name
   * the function that handles the result of the send email action. Parameters:
   *   bool    $result        result of the send action
   *   string  $to            email address of the recipient
   *   string  $cc            cc email addresses
   *   string  $bcc           bcc email addresses
   *   string  $subject       the subject
   *   string  $body          the email body
   * @var string
   */
  public $action_function = ''; //'callbackAction';

  /**
   * Sets the PHPMailer Version number
   * @var string
   */
  public $Version         = '5.2.1';

  /**
   * What to use in the X-Mailer header
   * @var string
   */
  public $XMailer         = '';

  public $_error = array();

  public function __construct()
  {
          $args = func_get_args();

          parent::__construct(true);

          if ($GLOBALS['ZE_MAIL']['type'] == 'smtp') {

              $this->IsSMTP(); // telling the class to use SMTP
            $this->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
            $this->SMTPAuth   = true;                  // enable SMTP authentication
            $this->SMTPSecure = "ssl";                 // sets the prefix to the servier
            $this->Host       = $GLOBALS['ZE_MAIL']['host'];      // sets GMAIL as the SMTP server
            $this->Port       = $GLOBALS['ZE_MAIL']['port'];                   // set the SMTP port for the GMAIL server
            $this->Username   = $GLOBALS['ZE_MAIL']['login'];  // GMAIL username
            $this->Password   = $GLOBALS['ZE_MAIL']['password'];            // GMAIL password

        }

        $this->SetFrom($GLOBALS['ZE_MAIL']['email'], $GLOBALS['ZE_MAIL']['name']);
  }

  public function info()
  {
          $info = new c_info();

          return $info->output();
  }

  /**
   * Simple send_email function
   *
   * @param $
   *
   * @return
   *
   * @code
   *
   * @endcode
   */
  public function send_email($to, $subject, $html, $param = null)
  {
          $this->MsgHTML($html);

        if (is_array($to)) {
            foreach($to as $email=>$name)
                $this->AddAddress($email, $name);
        } else {
            $this->AddAddress($to, $to);
        }

        switch (true) {
            case (is_array($param)):

                foreach ($param as $key => $mParam) {
                    try {
                        call_user_func_array(array($this, $key), $mParam);
                    } catch (Exception $e) {
                       $this->_error[] = array("function" => $key, "param" => $param);
                    }
                }
            break;
            default:

            break;
        }

        $this->Subject = $subject;

        try {
           return $this->Send();

        } catch (Exception $e) {

           $this->_error['error'] = $e;

           return false;
        }
  }

}
