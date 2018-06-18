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
    <div class="col-sm-4 parent" style="background-color:white;height: 100%;min-height: 100vh;">
      <div class="child" style="height: 30%;vertical-align: middle;text-align: center;">
        <img src="<?=$racine;?>img/avatar.png" class="img-responsive center-block" style="width: 60%;">
        <h1 style="font-size: 20px;font-weight: bold;margin-top: 15%;">Bienvenue</h1>
        <h2 style="font-family:'SourceSansPro-SemiBold';">John Doe</h2>
      </div>
    </div>
    <div class="col-sm-8" style="background-color:#1d899b;height: 100%;min-height: 100vh;">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-6 parent" style="height: 100%;  min-height: 100vh;">
        <div class="child" style="height: 30%;vertical-align: middle;color:white;">
          <div class="register-box">
            <div class="register-box-body">
              <form action="<?=$_SERVER['HTTP_REFERER'];?>" method="#" name="inscription">
                <div class="form-group has-feedback">
                  <label>Nom</label>
                  <input type="text" name="nom" class="form-control" placeholder="Nom">
                </div>
                <div class="form-group has-feedback">
                  <label>Prénom</label>
                  <input type="text" name="prenom" class="form-control" placeholder="Prénom">
                </div>
                <div class="form-group has-feedback">
                  <label>Tranche d'âge</label>
                  <select class="form-control selectpicker">
                    <option selected>3/6</option>
                    <option>7/10</option>
                    <option>11/15</option>
                  </select>
                </div>
                <div class="form-group has-feedback">
                  <label>ID praticien</label>
                  <input type="text" name="idpraticien" class="form-control" placeholder="ID praticien">
                </div>
                <div class="form-group has-feedback">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                  <label>Mot de passe</label>
                  <input type="password" class="form-control" placeholder="Mot de passe">
                </div>
                <a href="<?=$racine;?>home/" class="btn btn-primary btn-block" style="width: 50%;text-align: center;background-color:#192b49;border:0px;font-size: 16px;border-radius: 8px;margin:0 auto;display:block;">Créer le compte</a>
              </div>
            </div>
          </form>
        </div>
      </div>
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
