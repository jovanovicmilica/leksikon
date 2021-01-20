<?php
    require_once "konekcija.php";
    header('Content-Type:application/json');
    if(isset($_POST['dugmeGlasaj'])){
        $poruka="";
        $idOdgovora=$_POST['idOdgovora'];
        $idAnkete=$_POST['idAnkete'];
        $korisnik=$_SESSION['korisnik'];
        $idKorisnika=$korisnik['idKorisnika'];
        $daLiJeVecPopunioAnketu="SELECT * FROM rezultati WHERE idKorisnika=:id AND idAnkete=:idA";
        $priprema=$konekcija->prepare($daLiJeVecPopunioAnketu);
        $priprema->bindParam("id",$idKorisnika);
        $priprema->bindParam("idA",$idAnkete);
        try{
            $priprema->execute();
            $priprema->fetch();
            if($priprema->rowCount()==0){
                $kod=200;
                $poruka="Nije popunio";
                $dodajOdgovor="INSERT INTO rezultati VALUES(null,:idAnk,:idOdg,:idKor)";
                $priprema2=$konekcija->prepare($dodajOdgovor);
                $priprema2->bindParam(":idAnk",$idAnkete);
                $priprema2->bindParam(":idOdg",$idOdgovora);
                $priprema2->bindParam("idKor",$idKorisnika);
                try{
                    $priprema2->execute();
                    $kod=201;
                    $poruka="Uspešno ste popunili anketu";
                }
                catch(PDOException $e){
                    $kod=500;
                    $poruka="Nema veze sa serverom,pokušajte kasnije";
                }
            }
            else{
                $kod=200;
                $poruka="Već ste glasali, pogledajte rezultate ankete";
            }
        }
        catch(PDOException $e){
            $kod=500;
            $poruka="Nema veze sa serverom,pokušajte kasnije";
        }
    }
    else{
        echo "Nemate pristup";
    }


    echo json_encode($poruka);
    http_response_code($kod);
?>