<?php include('config.php');?>
<style>
.parent{display: table;}
.child{display: table-cell;vertical-align: middle;}
body{overflow-x: hidden;overflow-y: hidden;}
</style>
</head>
<header>
</header>
<section>
  <div class="row">
    <div class="col-sm-4 parent" style="height: 100%;min-height: 100vh;">
      <div class="child" style="height: 30%;vertical-align: middle;text-align: center;">
        <img src="<?=$racine;?>img/telmi-mascotte.png" class="img-responsive center-block" style="width: 35%;">
        <div class="">
          <a href="#"><img src="<?=$racine;?>img/Export/resultat.png"></a>
          <a href="#"><img src="<?=$racine;?>img/Export/profil.png"></a>
        </div>
      </div>
    </div>
    <div class="col-sm-8" style="height: 100%;min-height: 100vh;">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-6 parent" style="height: 100%; min-height: 100vh;">
        <div class="child" style="height: 30%;vertical-align: middle;color:#222222;font-family: SourceSansPro-SemiBold;font-size: 25px;text-align: center;">
          <p>Bonjour,<br>je m'appelle Telmi</p>
          <p>Je serais ton compagnon<br>durant toute l'aventure.</p>
          <a href="<?=$racine;?>niveaux/"><img src="<?=$racine;?>img/Export/play.png" style="width: 80%;"></a>
          <p style="font-size: 35px;">C'est parti !</p>
        </div>
        <div class="col-sm-4">
        </div>
      </div>
    </div>
  </section>
  <footer>
  </footer>
</body>
</html>