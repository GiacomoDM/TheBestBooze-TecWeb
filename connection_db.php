<?php
$host = 'localhost';
$user = 'gdelmoro';
$db = 'gdelmoro';
$password = 'mei9duyee9xae8Po';
$conn= new mysqli($host, $user, $password, $db);
if ($conn->connect_errno) {
echo "Connessione fallita (". $conn->connect_errno
. "): " . $conn->connect_error;
exit();
}
?>
