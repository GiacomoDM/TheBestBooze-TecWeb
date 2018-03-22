<?php
if(!file_exists("connection_db.php"))
	{ header('Location:404.php');exit; }
                include_once"connection_db.php"; 
class ClienteR {
        private $dat = array('passwd' => '' , 'nome' => '' , 'cogn' => '' , 'data' => '' ,
                                 'citta' => '' , 'iva' => '' , 'cartaT' => '' ,
                                 'cartaN' => '' , 'ind' => '' , 'tel' => '');
        function __construct($e){
    $host = "localhost";
$user = "gdelmoro";
$password = "mei9duyee9xae8Po";
$db = "gdelmoro";
$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_errno) {
echo "Connessione fallita (". $conn->connect_errno
. "): " . $conn->connect_error;
exit;
}
	if($in = $conn->prepare("SELECT Passwd , Nome , Cognome , Data , Indirizzo , 
                                Citta , Telefono , PartitaIVA , TipoCarta ,
                                NumeroCarta FROM Cliente WHERE Email = ?")){
        $in->bind_param('s' , $e);
          if($in->execute()){
                                $in->bind_result($pswd , $n , $c , $d , $i , $cc , $t , $pi , $ct , $cn);
                                $in->fetch();
				$this->dat['passwd'] = $pswd;
                                $this->dat['nome'] = $n ;
                                $this->dat['cogn'] = $c ;
				$a = substr($d,0,4);
				$m = substr($d,5,2);
				$g = substr($d,8,2);
                                $this->dat['data'] = $g . '/' . $m . '/' . $a;
                                $this->dat['citta'] = $cc ;
                                $this->dat['iva'] = $pi ;
                                $this->dat['cartaT'] = $ct ;
                                $this->dat['cartaN'] = $cn ;
                                $this->dat['ind'] = $i ;
                                $this->dat['tel'] = $t ;
                                $in->close();
                                $conn->close();
                                return true; }
                $in->close(); }
        $conn->close();
        return false; }
        public function getPasswd() { return $this->dat['passwd']; }
        public function getNome() { return $this->dat['nome']; }
        public function getCogn() { return $this->dat['cogn']; }
        public function getData() { return $this->dat['data']; }
        public function getCitta() { return $this->dat['citta']; }
        public function getIva() { return $this->dat['iva']; }
        public function getCartaT() { return $this->dat['cartaT']; }
        public function getCartaN() { return $this->dat['cartaN']; }
        public function getInd() { return $this->dat['ind']; }
        public function getTel() { return $this->dat['tel']; }
	function delAll($e , $conn){
global $conn;
$ok = true;
if($ok && $aux = $conn->prepare("SELECT * FROM OrdineInCorso WHERE Cliente = ?")){
        $aux->bind_param('s' , $e);
        if(!$aux->execute())$ok = false;
        $aux->store_result();
        if($aux->num_rows() > 0 ){
if($ok && $del = $conn->prepare("DELETE FROM OrdineInCorso WHERE Cliente = ?")){
        $del->bind_param('s' , $e);
        if(!$del->execute())$ok = false;
        $del->close(); }
        else $ok = false; }
        $aux->free_result();
        $aux->close(); }
else $ok = false;
if($ok && $aux = $conn->prepare("SELECT * FROM Carrello WHERE OrdineInCorso IN(SELECT ID FROM OrdineInCorso WHERE Cliente = ?)")){
        $aux->bind_param('s' , $e);
        if(!$aux->execute())$ok = false;
        $aux->store_result();
        if($aux->num_rows() > 0 ){
if($ok && $del = $conn->prepare("DELETE FROM Carrello WHERE OrdineInCorso IN(SELECT ID FROM OrdineInCorso WHERE Cliente = ?)")){
        $del->bind_param('s' , $e);
        if(!$del->execute())$ok = false;
        $del->close(); }
        else $ok = false; }
        $aux->free_result();
        $aux->close(); }
else $ok = false;
if($ok && $aux = $conn->prepare("SELECT * FROM OrdineConcluso WHERE Fattura IN(SELECT ID FROM Fattura WHERE Intestatario = ?)")){
        $aux->bind_param('s' , $e);
        if(!$aux->execute())$ok = false;
        $aux->store_result();
        if($aux->num_rows() > 0 ){
if($ok && $del = $conn->prepare("DELETE FROM OrdineConcluso WHERE Fattura IN(SELECT ID FROM Fattura WHERE Intestatario = ?)")){
    $del->bind_param('s' , $e);
        if(!$del->execute())$ok = false;
        $del->close(); }
        else $ok = false; }
        $aux->free_result();
        $aux->close(); }
else $ok = false;
if($ok && $aux = $conn->prepare("SELECT * FROM DettaglioFattura WHERE Fattura IN(SELECT ID FROM Fattura WHERE Intestatario = ?)")){
        $aux->bind_param('s' , $e);
        if(!$aux->execute())$ok = false;
        $aux->store_result();
        if($aux->num_rows() > 0 ){
if($ok && $del = $conn->prepare("DELETE FROM DettaglioFattura WHERE Fattura IN(SELECT ID FROM Fattura WHERE Intestatario = ?)")){
        $del->bind_param('s' , $e);
        if(!$del->execute())$ok = false;
        $del->close(); }
        else $ok = false; }
        $aux->free_result();
        $aux->close(); }
else $ok = false;
if($ok && $aux = $conn->prepare("SELECT * FROM Fattura WHERE Intestatario = ?")){
        $aux->bind_param('s' , $e);
        if(!$aux->execute())$ok = false;
        $aux->store_result();
        if($aux->num_rows() > 0 ){
if($ok && $del = $conn->prepare("DELETE FROM Fattura WHERE Intestatario = ?")){
        $del->bind_param('s' , $e);
        if(!$del->execute())$ok = false;
        $del->close(); }
        else $ok = false; }
        $aux->free_result();
        $aux->close(); }
else $ok = false;
if($ok && $aux = $conn->prepare("SELECT * FROM Cliente WHERE Email = ?")){
        $aux->bind_param('s' , $e);
        if(!$aux->execute())$ok = false;
        $aux->store_result();
        if($aux->num_rows() > 0 ){
if($ok && $del = $conn->prepare("DELETE FROM Cliente WHERE Email = ?")){
        $del->bind_param('s' , $e);
        if(!$del->execute())$ok = false;
        $del->close(); }
        else $ok = false; }
        $aux->free_result();
        $aux->close(); }
else $ok = false;
$conn->close();
if(!$ok)return false;
return true; }
}
?>
