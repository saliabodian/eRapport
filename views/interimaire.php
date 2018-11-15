<div id="content">
    <div id="content-header">
        <hr>
        <h1>Gestion des intérimaires</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Recherche multicritères</h5>
                    </div>
                    <form action="" method="get" class="form-horizontal">
                        <div class="controls controls-row">
                            <label class="span2 m-wrap">Rechercher :</label>
                            <input type="text" class="span6 m-wrap" name="search"/>
                            <button type="submit" class="btn btn-success span3 m-wrap" >Rechercher</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Sélection d'un interimaire</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="get" class="form-horizontal">
                            <div class="controls-row">
                                <label class="control-label span3 m-wrap">Liste des intérimaires</label>
                                <div class="controls span3 m-wrap">
                                    <?php $selectInterimaire->displayHTML(); ?>
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
                        <h5><?php if ($interimaireObject->getId() > 0) : ?>Modification d'un <?php else : ?>Ajout d'un <?php endif ?>utilisteur</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form action="" method="post" class="form-horizontal" id="demoform">
                            <input type="hidden" name="interimaire_id" value="<?= $interimaireObject->getId() ?>">
                            <input type="hidden" name="matricule" value="<?= $interimaireObject->getMatricule() ?>">
                            <?php if ($interimaireObject->getId() > 0) : ?>
                                <div class="control-group">
                                    <label for="matricule" class="control-label" >Matricule :</label>
                                    <div class="controls">
                                        <input disabled type="text" class="span2" placeholder="" name="" value="<?= $interimaireObject->getMatricule() ?>"/>
                                    </div>
                                </div>
                            <?php endif ?>
                            <div class="control-group">
                                <label for="nom" class="control-label">Nom <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nom" name="lastname" value="<?= $interimaireObject->getLastname() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="prenom" class="control-label">Prénom <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Prénom" name="firstname" value="<?= $interimaireObject->getFirstname() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="is_actif" class="control-label">Est Actif ?</label>
                                <div class="controls">
                                    <input type="checkbox" name="actif" <?php if($interimaireObject->isActif()==1) : ?> checked <?php endif; ?> value="<?= $interimaireObject->isActif()?> "/>
                                </div>
                            </div>
                            <?php if ($interimaireObject->getId() > 0) : ?>
                                <div class="control-group">
                                    <label for="agence_id" class="control-label" >Agence :</label>
                                    <div class="controls">
                                        <input disabled type="text" class="span3" placeholder="" name="agence_id" value="<?= $theAgenceName ?>"/>
                                        <input type="hidden" name="agence_id" value="<?= $interimaireObject->getAgenceId()->getId(); ?>">
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="control-group">
                                    <label for="agence_id" class="control-label">Agence <span>*</span>:</label>
                                    <div class="controls mySelect">
                                        <?php $selectAgence->displayHTML(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="control-group">
                                <label for="metier_id" class="control-label">Métier :</label>
                                <div class="controls mySelect">
                                    <?php $selectMetier->displayHTML(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="qualification" class="control-label">Qualification :</label>
                                <div class="controls mySelect">
                                    <?php $selectQualif->displayHTML(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="departement" class="control-label">Département :</label>
                                <div class="controls mySelect">
                                    <?php $selectDpt->displayHTML(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="chef_dequipe" class="control-label">Chef d'équipe :</label>
                                <div class="controls mySelect">
                                    <?php $selectUser->displayHTML(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="chantier" class="control-label">Chantier :</label>
                                <div class="controls mySelect">
                                    <?php $selectChantier->displayHTML(); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="date_prem_cont" class="control-label">Date première mise à disposition :</label>
                                <div class="controls">
                                    <input name="date_prem_cont" autocomplete="off" class="datepicker" value="<?= $interimaireObject->getDatePremCont()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_deb" class="control-label">Date début de mission:</label>
                                <div class="controls">
                                    <input name="date_deb" autocomplete="off" class="datepicker" value="<?= $interimaireObject->getDateDeb()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_fin" class="control-label">Date fin de mission:</label>
                                <div class="controls">
                                    <input name="date_fin" class="datepicker" value="<?= $interimaireObject->getDateFin()?>" disabled/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span2 btn-block"></div>
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Enregistrer</button>
                                </div>
                                <div class="span4">
                                    <a href="?delete=<?= $interimaireObject->getId() ?>" class="btn btn-warning  btn-block<?php if ($interimaireObject->getId() <= 0) : ?> disabled<?php endif; ?>" role="button" aria-disabled="true">Supprimer</a>
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