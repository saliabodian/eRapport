<div id="content">
    <div id="content-header">
        <hr>
        <h1>Modification d'affectation</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form action="" method="post" class="form-horizontal">
                            <input type="hidden" name="int_has_cht_id" value="<?= $interimaireSelected['int_has_cht_id'] ?>">
                            <input type="hidden" name="debut" value="<?= $interimaireSelected['date_debut'] ?>">
                            <input type="hidden" name="fin" value="<?= $interimaireSelected['date_fin'] ?>">
                            <input type="hidden" name="interimaire_id" value="<?= $interimaireSelected['interimaire_id'] ?>">
                            <input type="hidden" name="chantier_id" value="<?= $interimaireSelected['chantier_id'] ?>">
                            <div class="control-group">
                                <label class="control-label" for="interimaire"> Intérimaire <span></span>:</label>
                                <div class="controls">
                                    <input  disabled type="text" class="span11"  name="interimaire"  value="<?= $interimaireSelected['matricule'].' '.$interimaireSelected['lastname'].' '.$interimaireSelected['firstname'] ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label span3 m-wrap">Ancien chantier</label>
                                <div class="controls">
                                    <input  disabled type="text" class="span11"  name="old_chantier"  value="<?= $interimaireSelected['nom'] ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label span3 m-wrap">Nouveau chantier</label>
                                <div class="controls">
                                    <SELECT type="text" class="span11"  name="new_chantier">
                                        <?php foreach($listChantierActifs as $id=>$chantier): ?>
                                        <option value="<?= $id?>"<?php if ($id == $interimaireSelected['chantier_id']) : ?> selected="selected"<?php endif; ?>><?= $chantier?></option>
                                        <?php endforeach; ?>
                                    </SELECT>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="telephone" class="control-label">Jour :</label>
                                <div class="controls">
                                    <input type="text" class="span11 datepicker"  name="doy"  value="<?= $interimaireSelected['doy'] ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="adresse" class="control-label">woy :</label>
                                <div class="controls">
                                    <input  disabled type="text" class="span11"  name="woy"  value="<?= $interimaireSelected['woy'] ?>"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span2 btn-block"></div>
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Enregistrer</button>
                                </div>
                                <div class="span4">
                                    <a href="?delete=<?= $interimaireSelected['int_has_cht_id'] ?>" class="btn btn-warning  btn-block<?php if ($interimaireSelected['int_has_cht_id'] <= 0) : ?> disabled<?php endif; ?>" role="button" aria-disabled="true">Supprimer</a>
                                </div>
                                <div class=" span2 btn-block"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>