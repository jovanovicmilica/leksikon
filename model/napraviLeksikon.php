<?php
    require "konekcija.php";
    header('Content-Type:application/json');
    if(isset($_POST['dugmeNapravi'])){
        $korIme=$_POST['korIme'];
        $loz=$_POST['pristupnaLoz'];

        $regKorIme="/^[\d\w]{3,50}$/";
        $regLozinka="/^.{8,50}$/";
        $greske=[];

        if(!preg_match($regKorIme,$korIme)){
            array_push($greske,"Ime mora imati najmanje 3 karaktera");
        }
        if(!preg_match($regLozinka,$loz)){
            array_push($greske,"Pristupna lozinka mora imati najmanje 8 karaktera");
        }
        $poruka="";
        if(count($greske)==0){
            $idkor=$_SESSION['korisnik'];
            $id=$idkor['idKorisnika'];
            $daLiImaLeksikon="SELECT * FROM napravileksikon WHERE korIme=:user";
            $priprema7=$konekcija->prepare($daLiImaLeksikon);
            $priprema7->bindParam(":user",$korIme);
                $priprema7->execute();
                $priprema7->fetch();
                if($priprema7->rowCount()==0){
                $upitNapraviLeksikon="INSERT INTO napravileksikon VALUES(null,:idVl,:korIme,:loz,:datum)";
                $loz=md5($loz);
                $datum=date("Y-m-d H:i:s");
                $priprema=$konekcija->prepare($upitNapraviLeksikon);
                $priprema->bindParam(":idVl",$id);
                $priprema->bindParam(":korIme",$korIme);
                $priprema->bindParam(":loz",$loz);
                $priprema->bindParam(":datum",$datum);
                    try{
                        $priprema->execute();
                        $kod=201;
                        $poruka="Uspešno ste napravili leksikon";
                    }
                    catch(PDOException $e){
                        $kod=500;
                    }
                }
                else{
                    $kod=200;
                    $poruka="Postoji korisnik sa tim korisničkim imenom";
                }
        }
        else{
            $poruka="Niste ispravno popunili formu";
        }
    }
    else{
        $kod=404;
    }
    echo json_encode($poruka);
    http_response_code($kod);
?>