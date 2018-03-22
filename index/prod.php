<?php
if(!file_exists("connection_db.php"))
{ header('Location:404.php');exit; }
                include_once"connection_db.php";
class Prodotto{
        private $Cod = '';
        private $Nome = '';
        private $Prezzo = '';
        private $Lingua = '';
        private $Cat = '';
        private $SubCat = '';
        private $Anno = '';
        private $Prod = '';
        private $cod = '';
        private $nom = '';
        private $prz = '';
        private $lng = '';
        private $cat = '';
        private $scat = '';
        private $ann = '';
        private $prod = '';
        function __construct($c , $n , $p , $C , $sc , $a , $pr , $l){
        $this->cod = $this->setCod($c);
        $this->nom = $this->setNome($n);
        $this->prz = $this->setPrezzo($p);
        $this->lng = $this->setLingua($l);
        $this->cat = $this->setCat($C);
        $this->scat = $this->setSubCat($sc);
        $this->ann = $this->setAnno($a);
        $this->prod = $this->setProd($pr);
        }
        public function getErrCod() { return $this->cod; }
        public function getErrNom() { return $this->nom; }
        public function getErrPr() { return $this->prz; }
        public function getErrLingua() { return $this->lng; }
        public function getErrProd() { return $this->prod; }
        public function getErrCat() { return $this->cat; }
        public function getErrSubCat() { return $this->scat; }
        public function getErrAnno() { return $this->ann; }
        public function getCod() { return $this->Cod; }
        public function getLingua() { return $this->Lingua; }
	public function getNome() { return $this->Nome; }
        public function getPrezzo() { return $this->Prezzo; }
        public function getCat() { return $this->Cat; }
        public function getSubCat() { return $this->SubCat; }
        public function getAnno() { return $this->Anno; }
        public function getProd() { return $this->Prod; }
        public function noErrors(){
                if(!$this->cod && !$this->nom && !$this->prz && !$this->cat &&
                        !$this->scat && !$this->ann && !$this->prod && !$this->lng)return true;
                        return false; }
            public function setCod($n){
                if(ctype_digit($n) && strlen($n) <= 6)$this->Cod = $n;
                else return("errore: formato codice non corretto.");
                return false; }
            public function setLingua($n){
                $ok = false;
                $arr = array("it" , "en" , "de" , "fr");
                for($i = 0; $i < 4 && !$ok; $i++){ (strcmp($arr[$i] , $n)!==0) ? $ok = true : $ok = false; }
                if($ok && strlen($n) <= 2)$this->Lingua = $n;
                else return("errore: formato lingua non corretto.");
                return false; }
            public function setNome($n){
                if(checkTesto($n , 30))$this->Nome = $n;
                else return("errore: formato nome non corretto.");
                return false; }
            public function setProd($n){
                if(checkTesto($n , 40))$this->Prod = $n;
                else return("errore: formato produttore non corretto.");
                return false; }
            public function setCat($n){
		ucfirst($n);
                if(checkTesto($n , 20))$this->Cat = $n;
                else return("errore: formato categoria non corretto.");
                return false; }
            public function setSubCat($n){
                if($n === "" || checkTesto($n , 20))$this->SubCat = $n;
                else return("errore: formato sotto categoria non corretto.");
                return false; }
        public function setAnno($d){
                $d = str_replace(" " , "" , $d);
		if($d === "" || strlen($d) <= 4 && $d[0] > 0 && ctype_digit($d) && $d <= date('Y')){ $this->Anno = $d; }
                else{ return("errore: formato anno non corretto."); }
                return false; }
        public function setPrezzo($n){
                $n = str_replace(" " , "" , $n);
                if(strlen($n) <= 11 && preg_match("/^(\d)+(\.\d{1,2})?$/", $n) === 1)$this->Prezzo = $n;
                else{ return("errore: formato prezzo non corretto."); }
                return false;
        }
	public function NomExists(){
    $host = "localhost";
$user = "gdelmoro";
$password = "mei9duyee9xae8Po";
$db = "gdelmoro";
$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_errno) {
echo "Connessione fallita (". $conn->connect_errno
. "): " . $conn->connect_error;
exit; }
        $ok = '';
	if($in = $conn->prepare("SELECT * FROM Prodotto WHERE Nome = ?")){
        $in->bind_param('s' , $this->Nome);
        if($in->execute()){ if($in->num_rows >= 1) $ok = "errore : nome <span xml:lang='en'>file</span> già in uso"; }
        $in->close(); }
        $conn->close();
        return $ok; }
        public function save($conn){
    $host = "localhost";
$user = "gdelmoro";
$password = "mei9duyee9xae8Po";
$db = "gdelmoro";
$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_errno) {
echo "Connessione fallita (". $conn->connect_errno
. "): " . $conn->connect_error;
exit; }
        $ok = false;
        $cod = $this->Cod;
        $nome = $this->Nome;
        $ln = $this->Lingua;
        $pre = $this->Prezzo;
        $cat = $this->Cat;
        $subcat = $this->SubCat;
        $ann = $this->Anno;
        $prod = $this->Prod;
if($in = $conn->prepare("INSERT INTO Prodotto (Codice , Nome, Lingua , Prezzo, Categoria, 
                        Sottocategoria, Anno, Produttore) VALUES (? , ? , ? , ? , ? , ? , ? , ?)")){
        $in->bind_param('issdssis' , $cod , $nome , $ln , $pre , $cat , $subcat , $ann , $prod);
        if($in->execute()){ $ok = true; }
        $in->close(); }
        $conn->close();
        return $ok; }
        public function insert($vcod){
        global $conn;
        $ok = false;
        $n= $this->Nome;
        $ln = $this->Lingua;
        $pre = $this->Prezzo;
        $cat = $this->Cat;
        $scat = $this->SubCat;
        $ann = $this->Anno;
        $prod = $this->Prod;
        if($in = $conn->prepare("UPDATE Prodotto SET  Nome = ? , Lingua = ? , Prezzo = ? , Categoria = ? , 
                                SottoCategoria = ? , Anno = ? , Produttore = ? WHERE Codice = ?")){
	 $in->bind_param('ssdssisi' , $n , $ln , $pre , $cat , $scat , $ann , $prod , $vcod);
        if($in->execute()){ $ok = true; }
        $in->close(); }
        $conn->close();
        return $ok; }
}
            function checkTesto($n , $l){
		$aux = str_replace(" " , "" , $n);
                $aux = str_replace("-" , "" , $aux);
                $aux = str_replace("." , "" , $aux);
		$aux = str_replace("_" , "" , $aux);
		$aux = str_replace("'" , "" , $aux);
		$aux = str_replace("/" , "" , $aux);
		$aux = str_replace("," , "" , $aux);
                if(ctype_alnum($aux) && strlen($n) <= $l)
                        return true;
                return false;
                }
?>
