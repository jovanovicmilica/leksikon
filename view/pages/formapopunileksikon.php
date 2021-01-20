<?php
    $pitanjaUpit="SELECT * FROM pitanja ORDER BY prioritet DESC,idPitanja";
    $pitanja=$konekcija->query($pitanjaUpit)->fetchAll();
?>

<form>
    <div id="pitanja">
<?php
    foreach($pitanja as $p):
?>
    <div class="pitanje <?php
        $korisnik=$_SESSION['korisnik'];
        $pol=$korisnik['idPol'];
    ?>">
    <span class="tekstPitanja"><?=$p['tekst']?></span>
    <?php
        if($p['tekst']=="Da li imaš simpatiju?"):?>
        <input type="radio" name="cbSimpatija" id="<?=$p['idPitanja']?>" value="da">Da
        <input type="radio" name="cbSimpatija" id="<?=$p['idPitanja']?>" value="ne">Ne
    <?php 
    elseif($p['tekst']=="Datum rođenja"):?>
        <input type="date" name="datumR" id="<?=$p['idPitanja']?>">
    <?php
    else:
    ?>
    <input type="text" name="<?=$p['idPitanja']?>" id="<?=$p['idPitanja']?>" class="sveska">
    <?php
        endif;
    ?>
    </div>

<?php
    endforeach;
?>
</div>

<button id="popuni" type="button">Popuni</button>
<input type="hidden" name="idLeksikona" value="<?=$_GET["idLeks"];?>" id="idLeksikona">
<p id="porukaPopuniLeks"></p>
</form>

