<?php
    require_once "konekcija.php";
    header('Content-Type:application/json');
    if(isset($_POST['dugmeLoz'])){
        if(isset($_SESSION['korisnik'])){
            $korisnik=$_SESSION['korisnik'];
            $idKorisnika=$korisnik['idKorisnika'];
            $poruka="";
            $idLeksikona=$_POST['idLeks'];
            $lozinka=$_POST['inpSifra'];
            $lozinka=md5($lozinka);
            $daLiJePotpisan="SELECT * FROM potpisnici WHERE idKorisnika=:id AND idLeksikona=:idLeks";
            $priprema=$konekcija->prepare($daLiJePotpisan);
            $priprema->bindParam(":id",$idKorisnika);
            $priprema->bindParam(":idLeks",$idLeksikona);
            try{
                $priprema->execute();
                $priprema->fetch();
                if($priprema->rowCount()==1){
                    $kod=200;
                    $poruka="Popunili ste leksikon ovog korisnika";
                }
                else{
                    $proveraLozinke="SELECT * FROM napravileksikon WHERE idLeksikona=:idLeks AND pristupnaLozinka=:loz";
                    $priprema2=$konekcija->prepare($proveraLozinke);
                    $priprema2->bindParam(":idLeks",$idLeksikona);
                    $priprema2->bindParam(":loz",$lozinka);
                    $priprema2->execute();
                    $priprema2->fetch();
                    if($priprema2->rowCount()==1){
                        $kod=200;
                        $poruka="Odvedi na leksikon";
                    }
                    else{
                        $kod=200;
                        $poruka="Pogrešna lozinka";
                    }
                }
            }
            catch(PDOException $e){
                $kod=404;
                echo $e;
            }
        }
        else{
            $kod=404;
            $poruka="Morate se ulogovati";
        }
    }
    else{
        $kod=404;
        echo "NEMATE PRISTUP STRANICI";
    }
    echo json_encode($poruka);
    http_response_code($kod);
?>