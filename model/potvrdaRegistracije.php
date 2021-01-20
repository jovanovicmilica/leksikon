<?php
    require "konekcija.php";
    if(isset($_GET['kod'])){
        $kod=$_GET['kod'];
        echo $kod;
        $upit="SELECT * FROM korisnici WHERE aktivacioniKod=:kod";
        $priprema=$konekcija->prepare($upit);
        $priprema->bindParam(":kod",$kod);
        $priprema->execute();

        if($priprema->rowCount()==1){
            $korisnik=$priprema->fetch();

            $upitUpdate="UPDATE korisnici SET aktivan=1 WHERE aktivacioniKod=:kod";
            $pripremaUpdate=$konekcija->prepare($upitUpdate);
            $pripremaUpdate->bindParam(":kod",$kod);
            $pripremaUpdate->execute();
            echo "Aktivirali ste nalog";
            header("location:index.php?page=formaLogReg.php");

        }
        else{
            echo "Nemate pristup";
            header("location:index.php");
        }
    }
    else{
        echo 'NIJE OK';
    }
?>