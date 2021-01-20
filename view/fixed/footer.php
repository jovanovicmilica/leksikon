
<footer>
    <a href="index.php?page=pocetna">Online leksikon</a>
    <div id="mreze">
        <ul>
    <?php
        $nizMreza=["fab fa-instagram"=>"https://www.instagram.com/","fab fa-facebook"=>"https://www.facebook.com/","fab fa-youtube"=>"https://www.youtube.com/"];
        foreach($nizMreza as $fa=>$link):
    ?>
        <li><a href="<?=$link?>"><i class="<?=$fa?>"></i></a></li>
    <?php
        endforeach;
    ?>
        </ul>
    </div>
        <a href="dokumentacija.pdf">Dokumentacija</a>
        <a href="sitemap.xml">Sitemap</a>
</footer>


<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
</body>