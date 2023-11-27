<?php
    include("connection.php");
    trait constructable
    {
        public function __construct() 
        { 
            $a = func_get_args(); 
            $i = func_num_args(); 
            if (method_exists($this,$f='__construct'.$i)) { 
                call_user_func_array([$this,$f],$a); 
            } 
        } 
    }
    class Aktualis_Pizzaink
    {
        use constructable;
        protected $Nev;
        protected $Nev_regi;
        protected $Feltet;

        function __construct($Nev, $Feltet){
            $this->nev = $Nev;
            $this->feltet = $Feltet;
        }
        function __construct1($Nev, $Feltet, $Nev_regi){
            $this->nev = $Nev;
            $this->feltet = $Feltet;
            $this->nev_regi = $Nev_regi;
        }

        function pizza_uj(){

            //BELERAKJUK A CONNECTION-T
            include("connection.php");
            //ELLENŐRIZZÜK HOGY VAN-E MÁR ILYEN PIZZA
            $sql_check = "SELECT * FROM aktualis_pizzak WHERE nev = '$this->nev'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0){
                echo '<script>alert("Ilyen pizza már van az adatbázisunkban!")</script>';
            }else {
                //BELERAKJUK MAGÁT A PIZZÁT
                $sql = "INSERT INTO aktualis_pizzak (nev, feltet) VALUES ('$this->nev', '$this->feltet')";
                if (mysqli_query($conn, $sql)) {
                    echo '<script>alert("Új pizza Létrehozva!")</script>';
                } else {
                    echo '<script>alert("Hmm valami hiba történt!")</script>';
                }
                //MIVEL MINDEN PIZZÁNK MINDEN MÉRETBE ELÉRHETŐ EZÉRT VÉGIG MEGYÜNK A MÉRET TÁBLÁN ÉS ANNYISZOR MAJD HOZZÁADJUK A KAPCSOLÓTÁBLÁHOZ AZ ADOTT PIZZÁT AHÁNY MÉRET LETT DEFINIÁLVA A MERET_TABLA TÁBLÁBAN
                $sql_meret_loop = "SELECT * FROM meret_tabla";
                $result_meret_loop = mysqli_query($conn, $sql_meret_loop);
                while ($row = mysqli_fetch_assoc($result_meret_loop)){
                    $Id = $row['Id'];
                    $sql_kapcsolat_tabla = "INSERT INTO pizzak_aruk (pizzanev, meretid) VALUES ('$this->nev', '$Id')";
                    mysqli_query($conn, $sql_kapcsolat_tabla);
                }
            }
            
        }
        function pizza_modosit(){
            include("connection.php");
            //CSAK AZ ADMIN FOGJA HASZNÁLNI
            $sql = "UPDATE aktualis_pizzak nev = '$this->nev', feltet = '$this->feltet' WHERE nev = '$this->nev_regi'";
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("A pizza sikeresen módosítva!")</script>';
            }else {
                echo '<script>alert("Hmm valami hiba történt!")</script>';
            }


        }
        function pizza_kiir_admin_elado(){
            //AZ ELADONAK IS EZ A FUGGVENY FOGJA KIIRATNI A PIZZÁKAT
            //ITT CSAK EGYSZERŰ HTML ELEMEKKEL LESZ KI ECHO-ZVA MERT NEM KELL A CSICSA


        }
        function pizza_kiir_vevo(){
            
        }
    }
    

    class Rendeles
    {
        protected $PizzaNev;
        protected $FeltetNev;
        protected $RendelesMeret;
        protected $RendelesAr;
        protected $RendelesMennyiseg;
        protected $RendeleIdeje;
        protected $SzallitasiCim;
        protected $Telefonszam;
        protected $Kezbesites; //ALAPÉRTELMEZETT
        protected $KezbesitesVarhatoIdeje;
        protected $Statusz; //ALAPÉRTELMEZETT

        function __construct($PizzaNev, $FeltetNev, $RendelesMeret, $RendelesAr, $RendelesMennyiseg, $RendelesIdeje, $SzallitasiCim, $Telefonszam, $Kezbesites, $KezbesitesVarhatoIdeje, $Statusz){
            $this->pizzanev = $PizzaNev;
            $this->feltetnev = $FeltetNev;
            $this->rendelesmeret = $RendelesMeret;
            $this->rendelesar = $RendelesAr;
            $this->rendelesmennyiseg = $RendelesMennyiseg;
            $this->rendelesideje = $RendelesIdeje;
            $this->szallitasicim = $SzallitasiCim;
            $this->telefonszam = $Telefonszam;
            $this->kezbesites = $Kezbesites;
            $this->kezbesitesvarhatoideje = $KezbesitesVarhatoIdeje;
            $this->statusz = $Statusz;
        }
        
        function rendelesek_kiirasa(){
            //TÁBLÁZATOS FORMÁBAN KIIRJA A CUCCOKAT
        }
        function rendeles_leadas(){
            try {
                include("connection.php");
                $sql = "INSERT INTO rendelesek (pizzanev, feltetnev, meret, ar, mennyiseg, rendeles_ideje, szallitasi_cim, telefonszam, kezbesites_statusz, kiszallitas_ideje, rendeles_statusz) VALUES ('$this->pizzanev', '$this->feltetnev', '$this->rendelesmeret', $this->rendelesar, $this->rendelesmennyiseg,'$this->rendelesideje','$this->szallitasicim','$this->telefonszam','$this->kezbesites', '$this->kezbesitesvarhatoideje','$this->statusz')";

                $result = $conn->prepare($sql);
                $result->execute();

                
            } catch (\Throwable $th) {
                throw $th;
            }
            
           

            

        }
        function rendeles_statusz_modositas(){
            //MAJD AZ ŰRLAPON AZ ELADO SELECTEK-BŐL VÁLASZTJA KI AZ HOGY A KEZBESÍTES VAGY A RENDELES STATUSZAT MODOSITJA
        }
        
    }
    abstract class Users
    {
        use constructable;

        protected $FNev; 
        protected $Jelszo;
        protected $Jogkor;

        public function __construct1($FNev, $Jelszo, $Jogkor){
            $this->fnev = $FNev;
            $this->jelszo = $Jelszo;
            $this->jogkor = $Jogkor;
        }
        public function __construct2($FNev, $Jelszo){
            $this->fnev = $FNev;
            $this->jelszo = $Jelszo;
        }
        function belep_user(){
            session_start();
            include("connection.php");
            //CSEKKOLJUK A BELÉPÉSI ADATOKAT
            $sql = "SELECT * FROM admin_elado WHERE fnev = '$this->fnev' AND jelszo = '$this->jelszo'";

            $result = $conn->prepare($sql);
            $result->execute();
            //HA VAN HELYES USER ÉS PASSW PÁROS AKKOR MEGNÉZZÜK HOGY MI A JOGKÖRE A USERNAK ÉS UGY IRÁNYÍTJUK ÁT A MEGFELELŐ OLDALRA
            if ($result->rowCount() > 0) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                if ($row['jogkor'] == "admin") {
                    $_SESSION['admin_user'] = $this->fnev;
                    header("Location: index_admin.php");
                }else {
                    $_SESSION['elado_user'] = $this->fnev;
                    header("Location: index_elado.php");
                }
                
            }else {
                echo "Helytelen felhasználónév és jelszó páros!";
            }
        }
        function rendeles_lekérdezés(){
            
        }
        function rendeles_kereses(){
            //ITT EGY ADOTT RENDELÉSRE KERESÜNK RÁ ÉS AZT IRJUK KI UGYAN ÍGY MINT FELETTE
        }
        function aktualis_pizzak(){
            //gomb ami kiirja majd tablazatban pizza_kiir_admin_elado fgv. 
        }
        function rendeles_frissites(){
            //MINT ADMIN MINT ELADO TUDJA MODOSITANI rendeles_statusz_modositas fgv.
        }
        
    }
    class Admin extends Users
    {
        function uj_user(){
            include("connection.php");
            //REGISZTRÁLJUK A USERT MINT ADMIN VAGY ELADO CSAK ADMIN TUDJA
            //ELLENŐRIZZÜK HOGY A MEGADOTT FNEV MÁR SZEREPEL-E A RENDSZERBEN
            $sql_check = "SELECT * FROM admin_elado WHERE fnev = '$this->fnev'"; 
            $result_check = $conn->prepare($sql_check);
            if (mysqli_num_rows($result_check) > 0) {
                echo '<script>alert("Ilyen felhasználó már létezik!")</script>';
            }else {
                $passw_hash = hash("sha256",$this->jelszo);
                $sql_insert = "INSERT INTO admin_elado (fnev, jelszo, jogkor) VALUES ('$this->fnev','$passw_hash','$this->jogkor')";
                if (mysqli_query($conn, $sql_insert)) {
                    echo '<script>alert("Sikeres regisztráció!")</script>';
                }

            }

        }
        function pizza_hozzáad($pizzanev, $pizzafeltet){
            //EGY ŰRLAP AHOL HA MAJD KITÖLTI AKKOR PÉLDÁNYOSÍT EGY PIZZA-T ÉS PIZZA_UJ FGV.
            $p = new Aktualis_Pizzaink($pizzanev, $pizzafeltet);
            $p->pizza_uj();
        }
        function pizza_modositas(){
            //EGY ŰRLAP AHOL HA MAJD KITÖLTI AKKOR PÉLDÁNYOSÍT EGY PIZZA-T ÉS PIZZA_MODOSIT FGV.
            $p = new Aktualis_Pizzaink($pizzanev, $pizzafeltet, $pizzanev_regi);
            $p->pizza_modosit();
        }
        //function 

    }
    class Elado extends Users{}

    
    //$user = new Admin("admin1", "admin1", "admin");
    //$user->pizza_hozzáad("VALAMI", "VALAMI");

    /*
    $sql = "SELECT * FROM aktualis_pizzak";
    $result = mysqli_query($conn, $sql);
    while ($row1 = mysqli_fetch_assoc($result)){
        $nev = $row1['nev'];
        $sql_meret_loop = "SELECT * FROM meret_tabla";
        $result_meret_loop = mysqli_query($conn, $sql_meret_loop);
        while ($row2 = mysqli_fetch_assoc($result_meret_loop)){
            $id = $row2['Id'];
            $sql_kapcsolat_tabla = "INSERT INTO pizzak_aruk (pizzanev, meretid) VALUES ('$nev', '$id')";
            mysqli_query($conn, $sql_kapcsolat_tabla);
        }
    }
    */
?>