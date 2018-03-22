<?php
if(!file_exists("connection_db.php"))
{ header('Location:404.php');exit; }
                include_once"connection_db.php";
class Cliente {
        private $Nome = "";
        private $Cogn = "";
        private $Email = "";
        private $Passwd = "";
        private $Passwd2 = "";
        private $Data = "";
        private $Citta = "";
        private $Iva = "";
        private $CartaT = "";
        private $CartaN = "";
        private $Ind = "";
        private $Tel = "";
        private $eN = "" ;
        private $eC = "" ;
        private $eE = "" ;
        private $eP = "" ;
        private $eP2 = "";
        private $eD = "";
        private $eCC = "";
        private $eI = "";
        private $eCT = "";
        private $eCN = "";
        private $eIND = "";
        private $eT = "";
        function __construct($n , $c , $e , $p , $p2 , $d , $cc , $i , $ct , $cn , $ind , $T , $vPsswd){
                $this->eN = $this->setNome($n);
                $this->eC = $this->setCogn($c);
                $this->eE = $this->setEmail($e);
		if($vPsswd){
                	$this->Passwd = $p;
               		$this->Passwd2 = $p2; }
		else{
                	$this->eP = $this->setPasswd($p);
               		$this->eP2 = $this->setPasswd2($p2); }
                $this->eD = $this->setData($d);
                $this->eCC = $this->setCitta($cc);
                $this->eI = $this->setIva($i);
                $this->eCT = $this->setCartaT($ct);
                $this->eCN = $this->setCartaN($cn);
                $this->eIND = $this->setInd($ind);
		    $this->eT = $this->setTel($T);  }
        public function getErrN() { return $this->eN; }
        public function getErrC() { return $this->eC; }
        public function getErrE() { return $this->eE; }
        public function getErrP() { return $this->eP; }
        public function getErrP2() { return $this->eP2; }
        public function getErrD() { return $this->eD; }
        public function getErrCC() { return $this->eCC; }
        public function getErrI() { return $this->eI; }
        public function getErrCT() { return $this->eCT; }
        public function getErrCN() { return $this->eCN; }
        public function getErrIND() { return $this->eIND; }
        public function getErrT() { return $this->eT; }
        public function getNome() { return $this->Nome; }
        public function getCogn() { return $this->Cogn; }
        public function getEmail() { return $this->Email; }
        public function getPasswd() { return $this->Passwd; }
        public function getPasswd2() { return $this->Passwd2; }
        public function getData() { return $this->Data; }
        public function getCitta() { return $this->Citta; }
        public function getIva() { return $this->Iva; }
        public function getCartaT() { return $this->CartaT; }
        public function getCartaN() { return $this->CartaN; }
        public function getInd() { return $this->Ind; }
        public function getTel() { return $this->Tel; }
        public function noErrors(){
                if(!$this->eN && !$this->eC && !$this->eE &&
                        !$this->eD &&
                        !$this->eCC && !$this->eI && !$this->eCT &&
                        !$this->eCN && !$this->eIND && !$this->eT)return true;
                return false; }
        public function noErrorsPwd(){
                if(!$this->eP && !$this->eP2)return true;
                return false; }
            public function setNome($n){
                if(strlen($n) <= 30)$this->Nome = $n;
                else return("errore: formato nome non corretto.");
                return false; }
        public function setCogn($c){
                if(strlen($c) <= 30)$this->Cogn = $c;
                else return("errore: formato cognome non corretto.");
                return false; }
		 public function setEmail($e){
                if(strlen($e) <= 64 && filter_var($e , FILTER_VALIDATE_EMAIL))$this->Email = $e;
                else return("errore: formato <span xml:lang='en'>Email</span> non corretto.");
                return false; }
        public function setPasswd($p){
                if(strlen($p) <= 16 && preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $p) === 1){
                                $this->Passwd = password_hash($p , PASSWORD_BCRYPT); }
                else    { return("errore: la <span xml:lang='en'>password
                                </span>  deve essere di almeno 8 caratteri e contenere 
                                almeno una lettera minuscola , una lettera maiuscola e un numero");}
                return false; }
        public function setPasswd2($p2){
                $p = $this->Passwd;
                if(strlen($p2) <= 16 && password_verify($p2 , $p))$this->Passwd2 = $p;
                else return("<span xml:lang='en'>Password</span> e conferma 
                                <span xml:lang='en'>Password</span> non coincidono.");
                return false; }
        public function setData($d){
                if((strlen($d) == 10) && (preg_match("/^[0-3][0-9]\/[0-1][0-9]\/[0-2][0-9]{3}$/",$d) === 1)){
                $giorno = substr($d,0,2);
                $mese = substr($d,3,2);
                $anno = substr($d,6,4);
		if(intval($anno) > (date('Y') - 18)) { return "errore : i minorenni non possono iscriversi."; }
                if(intval($anno) > 1910 && checkdate($mese, $giorno, $anno)) { $this->Data = $anno . '-' . $mese . '-' . $giorno; }}
                else{ return("errore: formato data non corretto."); }
                return false; }
        public function setCitta($cc){
                if(strlen($cc) <= 30 )$this->Citta = $cc;
                else return("errore: formato citta  non corretto." );
                return false; }
        public function setIva($i){
		if($i){
                $i = strtoupper(str_replace(" " , "" , $i));
                if(preg_match("/^([A-Z])+(\d)+$/" , $i) === 1 && strlen($i) <= 15)$this->Iva = $i;
                else return("errore: formato <abbr title='Imposta sul valore aggiunto'>IVA</abbr> non corretto."); }
                return false; }
  public function setCartaT($ct){
                $ok = false;
                $arr = array("Visa" , "MasterCard" , "AmericanExpress");
                for($i = 0; $i < 3 && !$ok; $i++){ (strcmp($arr[$i] , $ct) === 0) ? $ok = true : $ok = false; }
                if($ok && strlen($ct) <= 30)$this->CartaT = $ct;
		else return("errore: formato tipo carta non corretto.");
                return false; }
        public function setCartaN($cn){
                $dim = strlen($cn);
                $cn = str_replace(' ' , '' , $cn);
                if(ctype_digit($cn) && $dim <= 16 && $dim >= 4)$this->CartaN = $cn;
                else return("errore: formato numero carta non corretto.");
                return false; }
        public function setInd($ind){
                if(preg_match("/[a-zA-Z\d,\- '_]/" , $ind) === 1 && strlen($ind) <= 30)$this->Ind = $ind;
                else return("errore: formato indirizzo non corretto.");
                return false; }
        public function setTel($T){
		if($T){
                $dim = strlen($T);
                $T = str_replace(' ' , '' , $T);
                if(ctype_digit($T) && $dim <= 15 && $dim > 5)$this->Tel = $T;
                else  return("errore: formato numero di telefono non corretto."); }
                return false; }
        public function save(){
global $conn;
if($in = $conn->prepare("INSERT INTO Cliente (Passwd, Nome, Cognome, Data, Indirizzo, Email , Telefono, PartitaIVA , TipoCarta , NumeroCarta
, Citta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")){
        $in->bind_param('ssssssissis' , $this->Passwd , $this->Nome , $this->Cogn , $this->Data , $this->Ind , $this->Email , $this->Tel , $this->Iva , $this->CartaT , $this->CartaN , $this->Citta);
        if($in->execute()){     $in->store_result();
  if($in->num_rows() === 1){ $in->close();$conn->close();return false; }
                                $in->free_result();
                                $in->close();
                                $conn->close();
                                return true; }
        $in->close(); }
$conn->close();
return false; }
 public function insert($vemail){
                global $conn;
                $ok = false;
		$conn->query("SET FOREIGN_KEY_CHECKS = 0");
                $in = $conn->prepare("UPDATE Cliente SET Passwd = ? , Nome = ? , Cognome = ? , Data = ? , Indirizzo = ? , 
                                        Email = ? , Telefono = ? , PartitaIVA = ? , TipoCarta = ? , NumeroCarta = ? , Citta = ?
                                        WHERE Email = ?");
		$res = $conn->prepare("UPDATE Fattura SET Intestatario = ? WHERE Intestatario = ?");
		$ris = $conn->prepare("UPDATE OrdineInCorso SET Cliente = ? WHERE Cliente = ?");
                if($in && $res && $ris){
        $in->bind_param('ssssssississ' , $this->Passwd , $this->Nome , $this->Cogn , $this->Data , $this->Ind , $this->Email , 
					$this->Tel , $this->Iva , $this->CartaT , $this->CartaN , $this->Citta , $vemail);
	$res->bind_param('ss' ,  $this->Email , $vemail);
	$ris->bind_param('ss' ,  $this->Email , $vemail);
        if($in->execute() && $res->execute() && $ris->execute()){ $ok = true; }
        $in->close();$ris->close();$res->close(); }
	$conn->query("SET FOREIGN_KEY_CHECKS = 1");
        $conn->close();
        return $ok; }
}
?>
