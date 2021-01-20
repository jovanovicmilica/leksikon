<?php
    require_once "model/konekcija.php";

    $prikaz=0;
    $uloga="bilo ko";
    if(isset($_SESSION['korisnik'])){
        $korisnik=$_SESSION['korisnik'];
        $uloga=$korisnik['nazivUloge'];
        if($uloga=="korisnik"){
            $prikaz=1;
        }
        else if($uloga=="admin"){
            $prikaz=2;
        }
    }
?>
<header>
    <div id="logo">
        <a href="index.php?page=pocetna">Online leksikon</a>
    </div>
    <nav>
    <ul>
        <?php
        if($prikaz==0){
            $dohvatiMeni="SELECT * FROM navigacija WHERE vidljiv=0 or vidljiv=3 ORDER BY prioritet,idNav";
        }
        elseif($prikaz==1){
            $dohvatiMeni="SELECT * FROM navigacija WHERE vidljiv=1 OR vidljiv=0 ORDER BY prioritet,idNav";
        }
        elseif($prikaz==2){
            $dohvatiMeni="SELECT * FROM navigacija WHERE vidljiv=1 OR vidljiv=0 OR vidljiv=2 ORDER BY prioritet,idNav";
        }


        $rezultatMeni=$konekcija->query($dohvatiMeni)->fetchAll();

            foreach($rezultatMeni as $rm):
        ?>
            <li>
                <a href="<?php echo $_SERVER['PHP_SELF']."?page=$rm[link]" ?>"><?=$rm['naziv']?></a>
            </li>
        <?php
            endforeach;
        ?>
    </ul>
    </nav>
</header>
<body>
    