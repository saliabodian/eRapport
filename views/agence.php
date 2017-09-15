<div id="content">
    <div id="content-header">
        <hr>
        <h1>Gestion des agences</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Sélection d'une agence</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="get" class="form-horizontal">
                            <div class="controls-row">
                                <label class="control-label span3 m-wrap">Liste des agences</label>
                                <div class="controls span3 m-wrap">
                                    <?php $selectAgence->displayHTML(); ?>
                                </div>
                                <div class="controls span3 m-wrap">
                                    <input type="submit" class="btn btn-success btn-block" value="Sélectionner" />
                                </div>
                                <div class="controls span3 m-wrap">
                                    <a href="?" class="btn btn-info btn-block">Ajouter</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5><?php if ($agenceObject->getId() > 0) : ?>Modification d'une <?php else : ?>Ajout d'une <?php endif ?>agence</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form id="agenceForm" action="" method="post" class="form-horizontal">
                            <input type="hidden" name="agence_id" value="<?= $agenceObject->getId() ?>">
                            <div class="control-group">
                                <label class="control-label" for="agence">Agence <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Agence" name="agence"  value="<?= $agenceObject->getNom() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="telephone" class="control-label">Téléphone :</label>
                                <div class="controls">
                                    <input type="number" class="span2" maxlength="5" placeholder="00352" name="indicatif"  value="<?= $agenceObject->getIndicatif()?>"/>
                                    <input type="number" class="span3" maxlength="10" placeholder="4859591" name="telephone"  value="<?= $agenceObject->getTelephone()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="adresse" class="control-label">Adresse :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Adresse" name="adresse"  value="<?= $agenceObject->getAdresse() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="code_postal" class="control-label">Code postal :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Code postal" name="code_postal"  value="<?= $agenceObject->getCodePostal()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="ville" class="control-label">Ville :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Ville" name="ville"  value="<?= $agenceObject->getVille()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="pays" class="control-label">Pays :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Pays" name="pays"  value="<?= $agenceObject->getPays()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="is_actif" class="control-label">Est Actif ?</label>
                                <div class="controls">
                                    <input type="checkbox" name="actif" <?php if($agenceObject->isActif()==1) : ?> checked <?php endif; ?> value="<?= $agenceObject->isActif()?> "/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span2 btn-block"></div>
                                <div class="span4">
                                        <button type="submit" class="btn btn-success btn-block" >Enregistrer</button>
                                </div>
                                <div class="span4">
                                        <a href="?delete=<?= $agenceObject->getId() ?>" class="btn btn-warning  btn-block<?php if ($agenceObject->getId() <= 0) : ?> disabled<?php endif; ?>" role="button" aria-disabled="true">Supprimer</a>
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