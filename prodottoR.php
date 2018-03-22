<?php
if(!file_exists("connection_db.php")){ header('Location:404.php');exit; }
        include_once"connection_db.php"; 
class ProdottoR{
        private $Cod = '';
        private $Nom = '';
        private $Prz = '';
        private $Cat = '';
        private $SCat = '';
        private $Ann = '';
        private $Prd = '';
        private $Lng = '';
        private $Disp = '';
        function __construct($cod){
                global $conn;
                $err = false;
                if($i = $conn->prepare("SELECT * FROM Prodotto WHERE Codice = ?")){
                        $i->bind_param( 'i' , $cod);
                        if($i->execute()){
                                $i->bind_result($c , $nom , $l , $prz , $ct , $sct , $ann , $prd , $disp);
                                $i->fetch();
                                $this->Cod = $c;
                                (!$disp) ? $this->Disp = 'NO' : $this->Disp = 'SI';
                                (!$sct) ? $this->SCat = 'NULL' : $this->SCat = $sct;
                                (!$ann) ? $this->Ann = 'NULL' : $this->Ann = $ann;
                                $this->Nom = $nom;
                                $this->Prz = $prz;
                                $this->Cat = $ct;
                                $this->Lng = $l;
                                $this->Prd = $prd; }
                        $i->close(); }
                        else { $err = true; }
                        $conn->close();
                        if($err) { header('Location:404.php');exit; }
        }
        public function getCod() { return $this->Cod; }
        public function getNome() { return $this->Nom; }
        public function getPrezzo() { return $this->Prz; }
        public function getCat() { return $this->Cat; }
        public function getSubCat() { return $this->SCat; }
        public function getAnno() { return $this->Ann; }
	public function getProd() { return $this->Prd; }
        public function getDisp() { return $this->Disp; }
        public function getLingua() { return $this->Lng; }
};
?>
