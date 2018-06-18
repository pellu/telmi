<?php
include('config.php');
?>
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
        <img src="<?=$racine;?>img/logo-telmi-mascotte.png" class="img-responsive center-block" style="width: 70%;">
      </div>
    </div>
    <div class="col-sm-8" style="background-color:#1d899b;height: 100%;min-height: 100vh;">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-6 parent" style="height: 100%;  min-height: 100vh;">
        <div class="child" style="height: 30%;vertical-align: middle;color:white;">
          <div class="register-box">
            <div class="register-box-body">
              <form action="<?=$racine;?>connexion/" method="#" name="connexion">
                <div class="form-group has-feedback">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                  <label>Mot de passe</label>
                  <input type="password" class="form-control" placeholder="Mot de passe">
                </div>
                <a href="<?=$racine;?>home/" class="btn btn-primary btn-block" style="float:left;width: 48%;text-align: center;background-color:#192b49;border:0px;font-size: 16px;border-radius: 8px;margin:0 auto;
                display:block;">Connexion</a>
                <a href="<?=$racine;?>inscription/" class="btn btn-primary btn-block" style="float:right;width: 48%;text-align: center;background-color:#192b49;border:0px;font-size: 16px;border-radius: 8px;margin:0 auto;
                display:block;">Inscription</a>
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