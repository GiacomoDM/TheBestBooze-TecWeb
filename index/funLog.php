<?php
function inizio(){
ini_set('session.use_strict_mode', 1);
session_start();
        if(!empty($_SESSION['delTime']) && $_SESSION['delTime'] < time() - 2100) {
                session_unset();
                session_destroy();
                session_start(); }
}
function rigeneraId($p , $p1 , $nomP , $nomP1){
        if(session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
        unset($_SESSION['delTime']);
        unset($_SESSION['newID']);
        $newId = hash('sha512', random_bytes(128));
        $_SESSION['newID'] = $newId;
        $_SESSION['delTime'] = time();
       if($p) $_SESSION[$nomP] = $p;
       if($p1) $_SESSION[$nomP1] = $p1;
        session_commit();
        ini_set('session.use_strict_mode', 0);
        session_id($newId);
        ini_set('session.use_strict_mode', 1);
}
function Login($e , $p , $conn) {
        $ok = false;
        if($stmt = $conn->prepare("SELECT Passwd FROM Cliente WHERE Email = ? ")){
                $stmt->bind_param('s', $e);
                if($stmt->execute()){
                    $stmt->bind_result($Passwd);
                    $stmt->fetch();
                    if(password_verify($p , $Passwd)) {
                        $stmt->free_result();
                        $ok = true; }}
                $stmt->close(); }
                $conn->close();
                return $ok; }

function LoginAM($e , $p , $conn) {
        $ok = false;
        if($stmt = $conn->prepare("SELECT Passwd FROM Admin WHERE Nome = ? ")){
                $stmt->bind_param('s', $e);
		 if($stmt->execute()){
                    $stmt->bind_result($Passwd);
                    $stmt->fetch();
                    if(strcmp($p , $Passwd) === 0) {
                        $stmt->free_result();
                        $ok = true; }}
                $stmt->close(); }
                $conn->close();
                return $ok; }
?>
