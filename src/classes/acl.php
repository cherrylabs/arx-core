<?php namespace Arx;

/**
 * ACL arx class
 * @file
 *	include the default orm
 * @package
 * @author Daniel Sum
 * @link 	@endlink
 * @see
 * @description
 *
 * @code 	@endcode
 * @comments
 * @todo
 */

class c_acl
{
    public $perms = array();
    public $userID = 0;
    public $userRoles = array();

    public function __construct($userID = '')
    {
        if ($userID != '') {
            $this->userID = floatval($userID);
        } else {
            $this->userID = floatval($_SESSION['userID']);
        }
        $this->userRoles = $this->getUserRoles($this->userID);

        $this->buildACL();
    }

    public static function setAllRoles($mRoles)
    {
        $aRoles = u::toArray($mRoles);

        if (a_db::table(T_USERSMETA)->where('name','roles')->find_one()) {

        } else {
            a_db::query('INSERT INTO '.T_USERSMETA.' SET name = ?');
        }

    }

    public function buildACL()
    {
        //first, get the rules for the user's role
        if (count($this->userRoles) > 0) {
            $this->perms = array_merge($this->perms,$this->getRolePerms($this->userRoles));
        }
        //then, get the individual user permissions
        $this->perms = array_merge($this->perms,$this->getUserPerms($this->userID));
    }

    public function getPermKeyFromID($permID)
    {
        $strSQL = "SELECT `permKey` FROM `permissions` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
        $data = mysql_query($strSQL);
        $row = mysql_fetch_array($data);

        return $row[0];
    }

    public function getPermNameFromID($permID)
    {
        $strSQL = "SELECT `permName` FROM `permissions` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
        $data = mysql_query($strSQL);
        $row = mysql_fetch_array($data);

        return $row[0];
    }

    public function getRoleNameFromID($roleID)
    {
        $strSQL = "SELECT `roleName` FROM `roles` WHERE `ID` = " . floatval($roleID) . " LIMIT 1";
        $data = mysql_query($strSQL);
        $row = mysql_fetch_array($data);

        return $row[0];
    }

    public static function getUserRoles($iID = null)
    {
        if(! $iID)	$iID = $this->userID;

        $data = a_db::query("SELECT role FROM '".ZE_DBPREFIX."users' WHERE `id` = $iID");

        while ($row = $data) {
            $resp[] = $row['role'];
        }

        return $resp;
    }

    public function getAllRoles($format='ids')
    {
        $format = strtolower($format);
        $strSQL = "SELECT * FROM `roles` ORDER BY `roleName` ASC";
        $data = mysql_query($strSQL);
        $resp = array();
        while ($row = mysql_fetch_array($data)) {
            if ($format == 'full') {
                $resp[] = array("ID" => $row['ID'],"Name" => $row['roleName']);
            } else {
                $resp[] = $row['ID'];
            }
        }

        return $resp;
    }

    public function getAllPerms($format='ids')
    {
        $format = strtolower($format);
        $strSQL = "SELECT * FROM `permissions` ORDER BY `permName` ASC";
        $data = mysql_query($strSQL);
        $resp = array();
        while ($row = mysql_fetch_assoc($data)) {
            if ($format == 'full') {
                $resp[$row['permKey']] = array('ID' => $row['ID'], 'Name' => $row['permName'], 'Key' => $row['permKey']);
            } else {
                $resp[] = $row['ID'];
            }
        }

        return $resp;
    }

    public function getRolePerms($role)
    {
        if (is_array($role)) {
            $roleSQL = "SELECT * FROM `role_perms` WHERE `roleID` IN (" . implode(",",$role) . ") ORDER BY `ID` ASC";
        } else {
            $roleSQL = "SELECT * FROM `role_perms` WHERE `roleID` = " . floatval($role) . " ORDER BY `ID` ASC";
        }
        $data = mysql_query($roleSQL);
        $perms = array();
        while ($row = mysql_fetch_assoc($data)) {
            $pK = strtolower($this->getPermKeyFromID($row['permID']));
            if ($pK == '') { continue; }
            if ($row['value'] === '1') {
                $hP = true;
            } else {
                $hP = false;
            }
            $perms[$pK] = array('perm' => $pK,'inheritted' => true,'value' => $hP,'Name' => $this->getPermNameFromID($row['permID']),'ID' => $row['permID']);
        }

        return $perms;
    }

    public function getUserPerms($userID)
    {
        $strSQL = "SELECT * FROM `user_perms` WHERE `userID` = " . floatval($userID) . " ORDER BY `addDate` ASC";
        $data = mysql_query($strSQL);
        $perms = array();
        while ($row = mysql_fetch_assoc($data)) {
            $pK = strtolower($this->getPermKeyFromID($row['permID']));
            if ($pK == '') { continue; }
            if ($row['value'] == '1') {
                $hP = true;
            } else {
                $hP = false;
            }
            $perms[$pK] = array('perm' => $pK,'inheritted' => false,'value' => $hP,'Name' => $this->getPermNameFromID($row['permID']),'ID' => $row['permID']);
        }

        return $perms;
    }

    public function userHasRole($roleID)
    {
        foreach ($this->userRoles as $k => $v) {
            if (floatval($v) === floatval($roleID)) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission($permKey)
    {
        $permKey = strtolower($permKey);
        if (array_key_exists($permKey,$this->perms)) {
            if ($this->perms[$permKey]['value'] === '1' || $this->perms[$permKey]['value'] === true) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getUsername($userID)
    {
        $strSQL = "SELECT `username` FROM `users` WHERE `ID` = " . floatval($userID) . " LIMIT 1";
        $data = mysql_query($strSQL);
        $row = mysql_fetch_array($data);

        return $row[0];
    }
}
