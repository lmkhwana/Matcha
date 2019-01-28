<?php
	function str_random($length)
	{
		$alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }
    
    function check_valid_ex($file_name)
    {
        $valid = array('jpg', 'png');

        $extension_upload = strtolower(substr(strrchr($_FILES['file_name']['name'], '.'), 1));
        
        if (!(in_array($extension_upload,$extensions_valides)))
            return (0);
        else
            return (1);
    }

    function Display_flash($alert, $message, $path)
    {
        if (session_status() == PHP_SESSION_NONE) { session_start(); }
        $_SESSION['flash'][$alert] = $message;
        echo '<script language="Javascript">
                 document.location.replace("'.$path .'");
            </script>';
        exit();
    }

    function get_Distance($latitude2, $longitude2) {
        $earth_radius = 6371;

        $latitude1 = $_SESSION['auth']->lati;
        $longitude1 = $_SESSION['auth']->longi;
        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
    }

    function send_mail($to, $subject, $message)
    {

     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


     $headers .= 'To: Mary <bgumede@example.com>, bazil <bazil@example.com>' . "\r\n";
     $headers .= 'From: Matcha <Matcha@example.com>' . "\r\n";
     $headers .= 'Cc: info@example.com' . "\r\n";
     $headers .= 'Bcc: matcha_verif@example.com' . "\r\n";

     mail($to, $subject, $message, $headers);
    }

    function Is_Connected() {
        if (isset($_SESSION['auth']))
            Display_flash('danger', "Error : You cannot access this page.", "./index.php");
    }

    function Is_Not_Connected() {
        if (!isset($_SESSION['auth']))
            Display_flash('danger', "Error : You cannot access this page.", "./index.php");
    }

    function Is_blocked($blocker, $blocked){
        if (session_status() == PHP_SESSION_NONE) { session_start(); }

        require "database.php";

        $req = $pdo->prepare("SELECT * FROM blocked WHERE blocker = ? AND blocked = ?");
        $req->execute([$blocker, $blocked]);

        $res = $req->fetch();

        if ($res)
            return (true);
        return (false);
    }
?>