<?php
    require_once "konekcija.php";
    header('Content-Type:application/json');
    if(isset($_POST['pogledaj'])){
        $idLeks=$_POST['idLeks'];
        $vidiLeks="SELECT p.idPotpisnika,k.ime,k.prezime,n.idLeksikona from napravileksikon n INNER JOIN potpisnici p ON p.idLeksikona=n.idLeksikona INNER JOIN korisnici k ON k.idKorisnika=p.idKorisnika WHERE n.idLeksikona=:id";
        $priprema=$konekcija->prepare($vidiLeks);
        $priprema->bindParam(":id",$idLeks);
        try{
            $priprema->execute();
            $leks=$priprema->fetchAll();
            if($priprema->rowCount()!=0){
                foreach($leks as $l){
                    $idPotpisnika=$l['idPotpisnika'];
                    $odgovor="SELECT po.idPotpisnika AS idP,p.tekst,o.tekstOdgovora FROM pitanja p INNER JOIN odgovori o ON p.idPitanja=o.idPitanja INNER JOIN potpisnici po ON o.idPotpisnika=po.idPotpisnika WHERE po.idPotpisnika=:idPotpisnika ORDER BY p.idPitanja";
                    $priprema7=$konekcija->prepare($odgovor);
                    $priprema7->bindParam(":idPotpisnika",$idPotpisnika);
                    try{
                        $priprema7->execute();
                        $odg=$priprema7->fetchAll();
                        $data[]=$odg;
                        $kod=200;
                    }
                    catch(PDOException $e){
                        $data="Nema veze sa serverom";
                        $kod=500;
                    }
                }
            }
            else{
                $kod=200;
                $data="Nema potpisanih korisnika";
            }
        }
        catch(PDOException $e){
            $kod=500;
            $data="Nema veze sa serverom";
        }
    }
    else{
        $kod=404;
        $data="Nemate pristup";
    }

    echo json_encode($data);
    http_response_code($kod);
?>