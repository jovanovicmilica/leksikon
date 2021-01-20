<?php
    require "konekcija.php";
    header('Content-Type:application/json');
    if(isset($_POST['popuni'])){
        $podaci=$_POST['podaci'];
        $leksikonId=$_POST['leksikon'];
        $korisnik=$_SESSION['korisnik'];
        $idKorisnika=$korisnik['idKorisnika'];
        $dodajPotpisnika="INSERT INTO potpisnici VALUES(null,:leksikonId,:idKorisnika)";
        $priprema2=$konekcija->prepare($dodajPotpisnika);
        $priprema2->bindParam(":leksikonId",$leksikonId);
        $priprema2->bindParam(":idKorisnika",$idKorisnika);
        $poruka="";
        try{
            $priprema2->execute();
            $idP=$konekcija->lastInsertId();
                foreach($podaci as $n){
                    foreach($n as $p=>$o){
                        $upit="INSERT INTO odgovori VALUES(null,:idPitanja,:idPotpisnika,:tekstOdgovora)";
                        $priprema=$konekcija->prepare($upit);
                        $priprema->bindParam(":idPitanja",$p);
                        $priprema->bindParam(":idPotpisnika",$idP);
                        $priprema->bindParam(":tekstOdgovora",$o);
                        try{
                            $uspesno=$priprema->execute();
                            $kod=201;
                            $poruka="Uspešno ste popunili leksikon";
                        }
                        catch(PDOException $e){
                            $kod=200;
                            $poruka="Popunjen";
                        }
                    }
                }
        }
        catch(PDOException $e){
            $kod=500;
        }
    }
    else{
        $kod=404;
    }

    echo json_encode($poruka);
    http_response_code($kod);
?>