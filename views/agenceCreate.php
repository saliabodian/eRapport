<?php

include 'header.php';
include 'sidebar.php';

?>

<div id="content">
<div id="content-header">
  <h1>Création d'une agence</h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Agence</h5>
        </div>
        <div class="widget-content nopadding">

          <form action="" method="post" class="form-horizontal">
            <?php if (sizeof($errorList) > 0) : ?>
              <?php var_dump($errorList); ?>
              <?php foreach ($errorList as $currentError) : ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <?= $currentError ?></div>
              <?php endforeach; ?>
            <?php endif; ?>
            <div class="control-group">
              <label class="control-label" >Agence <span>*</span>:</label>
              <div class="controls">
                <input type="text" class="span11" placeholder="Agence" name="agence" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Téléphone :</label>
              <div class="controls">
                <input type="text" class="span11" placeholder="003524859591" name="telephone"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Adresse :</label>
              <div class="controls">
                <input type="text" class="span11" placeholder="Adresse" name="adresse"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Code postal :</label>
              <div class="controls">
                <input type="text"  class="span11" placeholder="Code postal" name="code_postal" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Ville :</label>
              <div class="controls">
                <input type="text"  class="span11" placeholder="Ville" name="ville" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Pays :</label>
              <div class="controls">
                <input type="text"  class="span11" placeholder="Pays" name="pays" />
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