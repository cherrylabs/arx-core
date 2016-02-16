<?php namespace Arx\classes;

/**
 * Class EmailReader
 *
 * Email retriever and parser (needs imap extension and Open Ssl)
 *
 * @compatibility php_>_5.4,mod_imap
 * @package Arx\classes
 */
class EmailReader
{
    public $conn;
    public $bodyHTML = '';
    public $bodyPlain = '';
    public $attachments;
    public $getAttachments = true;
    public $messageNumber;

    public $inbox;
    public $msg_cnt;
    public $server = null;
    public $user = null;

    private $pass = null;

    /**
     * Build the email reader
     *
     * @param null $server
     * @param null $user
     * @param null $pass
     */
    public function __construct($server = null, $user = null, $pass = null)
    {

        $params = ['server', 'user', 'pass'];

        foreach ($params as $key) {
            if (${$key}) {
                $this->{$key} = ${$key};
            }
        }

        $this->connect();
        $this->inbox();
    }


    /**
     * Close the connection
     */
    public function close()
    {
        $this->inbox = array();
        $this->msg_cnt = 0;

        imap_close($this->conn);
    }

    /**
     * Open the imap connection
     */
    public function connect()
    {
        $this->conn = imap_open($this->server, $this->user, $this->pass);
    }

    /**
     * @param int $limit
     */
    public function inbox($limit = null)
    {
        $this->msg_cnt = imap_num_msg($this->conn);

        if($limit && $limit < $this->msg_cnt){
            $this->msg_cnt = $limit;
        }

        $in = array();

        for ($i = 1; $i <= $this->msg_cnt; $i++) {
            $in[] = array(
                'index' => $i,
                'header' => @imap_headerinfo($this->conn, $i),
                'body' => @imap_body($this->conn, $i),
                'structure' => @imap_fetchstructure($this->conn, $i)
            );
        }

        $this->inbox = $in;
    }

    /**
     * Fetch structure by index
     *
     * @param null $index
     * @param array $params
     * @return bool
     */
    public function fetch($index = null, $params = array(
        'index' => true,
        'overview' => true,
        'structure' => true,
        'header' => true,
        'body' => true,
        'plain' => true,
        'attachments' => true,
    )){
        $params = Arr::mergeWithDefaultParams($params);

        $this->attachments = [];

        if (!$index) {
            $index = 1;
        }

        $this->messageNumber = $index;

        $structure = @imap_fetchstructure($this->conn, $index);

        if (!$structure) {
            return false;
        } else {
            $data = [];

            if($params['index']){
                $data['index'] = $index;
            }

            if($params['overview']){
                $data['overview'] = @imap_fetch_overview($this->conn, $index);
            }

            if($params['structure']){
                $data['structure'] = $structure;
            }

            if($params['header']){
                $data['header'] = @imap_header($this->conn, $index);
            }

            if($params['body']){
                $this->bodyHTML = $data['body'] = @imap_body($this->conn, $index);
            }

            if($params['plain']){
                $data['plain'] = @imap_fetchbody($this->conn, $index, 1.2);
            }

            if($params['attachments']){
                $this->recurse($structure->parts);
                $data['attachments'] = $this->attachments;
            }

            return $data;
        }

    }

    /**
     * @param null $msg_index
     * @return array
     */
    public function get($msg_index = NULL)
    {
        if (!$this->inbox) {
            $this->inbox($msg_index);
        }

        if (!is_null($msg_index) && isset($this->inbox[$msg_index])) {
            return $this->inbox[$msg_index];
        }

        return false;
    }

    /**
     * Get Count of a folder
     *
     * @param null $folder
     * @return int
     */
    public function getCount($folder = null){

        if ($folder) {
            $conn = $this->getFolder($folder);
        } else {
            $conn = $this->conn;
        }

        return imap_num_msg($conn);
    }

    /**
     * Get folder conn
     *
     * @param $folder
     * @return string
     */
    public function getFolder($folder = ''){
        $conn = substr($this->server,0,strpos($this->server, '}') + 1).$folder;
        return $conn;
    }

    /**
     * Get part
     *
     * @param $partNumber
     * @param $encoding
     * @return string
     */
    public function getPart($partNumber, $encoding)
    {
        $data = imap_fetchbody($this->conn, $this->messageNumber, $partNumber);
        switch ($encoding) {
            case 0:
                return $data; // 7BIT
            case 1:
                return $data; // 8BIT
            case 2:
                return $data; // BINARY
            case 3:
                return base64_decode($data); // BASE64
            case 4:
                return quoted_printable_decode($data); // QUOTED_PRINTABLE
            case 5:
                return $data; // OTHER
        }
    }

    /**
     * Get The filename from part
     *
     * @param $part
     * @return string
     */
    public function getFilenameFromPart($part)
    {

        $filename = '';

        if ($part->ifdparameters) {
            foreach ($part->dparameters as $object) {
                if (strtolower($object->attribute) == 'filename') {
                    $filename = $object->value;
                }
            }
        }

        if (!$filename && $part->ifparameters) {
            foreach ($part->parameters as $object) {
                if (strtolower($object->attribute) == 'name') {
                    $filename = $object->value;
                }
            }
        }

        return $filename;

    }

    /**
     * Move mail to folder
     *
     * @param $msg_index
     * @param string $folder
     */
    public function move($msg_index, $folder = 'INBOX.Processed')
    {

        // move on server
        imap_mail_move($this->conn, $msg_index, $folder);
        imap_expunge($this->conn);

        // re-read the inbox
        $this->inbox($this->msg_cnt);
    }

    /**
     * Recursive function to get message parts
     *
     * @param $messageParts
     * @param string $prefix
     * @param int $index
     * @param bool $fullPrefix
     */
    public function recurse($messageParts, $prefix = '', $index = 1, $fullPrefix = true)
    {

        foreach ($messageParts as $part) {

            $partNumber = $prefix . $index;

            if ($part->type == 0) {
                if ($part->subtype == 'PLAIN') {
                    $this->bodyPlain .= $this->getPart($partNumber, $part->encoding);
                } else {
                    $this->bodyHTML .= $this->getPart($partNumber, $part->encoding);
                }
            } elseif ($part->type == 2) {
                $msg = new self($this->conn, $this->messageNumber);
                $msg->getAttachments = $this->getAttachments;
                $msg->recurse($part->parts, $partNumber . '.', 0, false);
                $this->attachments[] = array(
                    'type' => $part->type,
                    'subtype' => $part->subtype,
                    'filename' => '',
                    'data' => $msg,
                    'inline' => false,
                );
            } elseif (isset($part->parts)) {
                if ($fullPrefix) {
                    $this->recurse($part->parts, $prefix . $index . '.');
                } else {
                    $this->recurse($part->parts, $prefix);
                }
            } elseif ($part->type > 2) {
                if (isset($part->id)) {
                    $id = str_replace(array('<', '>'), '', $part->id);
                    $this->attachments[$id] = array(
                        'type' => $part->type,
                        'subtype' => $part->subtype,
                        'filename' => $this->getFilenameFromPart($part),
                        'data' => $this->getAttachments ? $this->getPart($partNumber, $part->encoding) : '',
                        'inline' => true,
                    );
                } else {
                    $this->attachments[] = array(
                        'type' => $part->type,
                        'subtype' => $part->subtype,
                        'filename' => $this->getFilenameFromPart($part),
                        'data' => $this->getAttachments ? $this->getPart($partNumber, $part->encoding) : '',
                        'inline' => false,
                    );
                }
            }

            $index++;

        }

        return $this->attachments;

    }

}