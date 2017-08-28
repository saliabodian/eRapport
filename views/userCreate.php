<?php
include 'header.php';
include 'sidebar.php';
?>

<div id="content">
<div id="content-header">
  <h1>Création d'un utilisateur</h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Informations utilisateur</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="#" method="post" class="form-horizontal">
            <div class="control-group">
              <label class="control-label" >Prénom <span>*</span>:</label>
              <div class="controls">
                <input type="text" class="span11" placeholder="Prénom" name="firstname" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Nom <span>*</span>:</label>
              <div class="controls">
                <input type="text" class="span11" placeholder="Nom" name="lastname"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Login <span>*</span>:</label>
              <div class="controls">
                <input type="text" class="span11" placeholder="Login" name="login"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Mot de passe <span>*</span></label>
              <div class="controls">
                <input type="password"  class="span11" placeholder="Mot de passe" name="password" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Confirmer mot de passe <span>*</span></label>
              <div class="controls">
                <input type="password"  class="span11" placeholder="Confirmer votre mot de passe" name="password2" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Role :</label>
              <div class="controls">
                <select name="role">
                  <option>First option</option>
                  <option>Second option</option>
                  <option>Third option</option>
                  <option>Fourth option</option>
                  <option>Fifth option</option>
                  <option>Sixth option</option>
                  <option>Seventh option</option>
                  <option>Eighth option</option>
                </select>
              </div>
            </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div></div>
<?php
include 'footer.php';
?>