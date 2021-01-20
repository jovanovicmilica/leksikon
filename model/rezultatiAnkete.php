<?php
header('Content-Type:application/json');
    require_once "konekcija.php";
    if(isset($_POST['dugmeGlasaj'])){
        $idAnkete=$_POST['idAnkete'];
        $proba="SELECT CEIL(AVG(SUBSTRING(o.tekstOdgovora,1,1))) AS prosecnaOcena FROM rezultati r INNER JOIN odgovorianketa o ON r.idOdgovora=o.idOdgovora WHERE r.idAnkete=:id";
        $priprema=$konekcija->prepare($proba);
        $priprema->bindParam(":id",$idAnkete);
        try{
            $priprema->execute();
            $rezultat=$priprema->fetch();
            $kod=200;
            $ocena=$rezultat['prosecnaOcena'];
            $opisnaOcena="SELECT tekstOdgovora FROM odgovorianketa WHERE SUBSTRING(tekstOdgovora,1,1)=$ocena";
            $opisnaOcena=$konekcija->query($opisnaOcena)->fetch();
            $poruka="Prosečna ocena je: ".$opisnaOcena['tekstOdgovora'];
        }
        catch(PDOException $e){
            $kod=500;
            $poruka="Nema veze sa serverom";
        }
        
    }
    else{
        $kod=404;
        $poruka="nemate pristup";
    }

    echo json_encode($poruka);
    http_response_code($kod);
?>