<div id="content">
    <div id="content-header">
        <hr>
        <h1>Gestion des chantiers</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Sélection d'un chantier</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="get" class="form-horizontal">
                            <div class="controls-row">
                                <label class="control-label span3 m-wrap">Liste des chantiers</label>
                                <div class="controls span3 m-wrap">
                                    <?php $selectChantier->displayHTML(); ?>
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
                        <h5><?php if ($chantierObject->getId() > 0) : ?>Modification d'un <?php else : ?>Ajout d'un <?php endif ?>chantier</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form action="" method="post" class="form-horizontal">
                            <input type="hidden" name="chantier_id" value="<?= $chantierObject->getId() ?>">
                            <div class="control-group">
                                <label class="control-label" for="nom">Chantier <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nom" name="nom"  value="<?= $chantierObject->getNom() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="code" class="control-label">Code :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Code" name="code"  value="<?= $chantierObject->getCode()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="adresse" class="control-label">Adresse :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Adresse" name="adresse"  value="<?= $chantierObject->getAdresse() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="adresse_fac" class="control-label">Adresse Fac :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Adresse Fac" name="adresse_fac"  value="<?= $chantierObject->getAdresseFac()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_exex" class="control-label">Date d'exécution :</label>
                                <div class="controls">
                                    <input type="text"  placeholder="Date d'exécution" name="date_exec" id="datepicker" value="<?= $chantierObject->getDate_exec()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="is_actif" class="control-label">Est Actif ?</label>
                                <div class="controls">
                                    <input type="checkbox" name="actif" <?php if($chantierObject->isActif()==1) : ?> checked <?php endif; ?> value="<?= $chantierObject->isActif()?> "/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span2 btn-block"></div>
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Enregistrer</button>
                                </div>
                                <div class="span4">
                                    <a href="?delete=<?= $chantierObject->getId() ?>" class="btn btn-warning  btn-block<?php if ($chantierObject->getId() <= 0) : ?> disabled<?php endif; ?>" role="button" aria-disabled="true">Supprimer</a>
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