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
                            <div class="control-group">
                                <label for="matricule" class="control-label" >Matricule :</label>
                                <div class="controls">
                                    <input disabled type="text" class="span11" placeholder="" name="matricule" value="<?= $interimaireObject->getMatricule() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="matricule_cns" class="control-label" >Matricule CNS :</label>
                                <div class="controls">
                                    <input disabled type="text" class="span11" placeholder="" name="matricule_cns" value="<?= $interimaireObject->getMatriculeCns() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="prenom" class="control-label">Prénom <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nom" name="firstname" value="<?= $interimaireObject->getFirstname() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="nom" class="control-label">Nom <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nom" name="lastname" value="<?= $interimaireObject->getLastname() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="is_actif" class="control-label">Est Actif ?</label>
                                <div class="controls">
                                    <input type="checkbox" name="actif" <?php if($interimaireObject->isActif()==1) : ?> checked <?php endif; ?> value="<?= $interimaireObject->isActif()?> "/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="taux" class="control-label">Taux:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="taux" name="email" value="<?= $interimaireObject->getTaux() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="taux_horaire" class="control-label">Taux horaire :</label>
                                <div class="controls">
                                    <input type="text"  class="span11" placeholder="Taux horaire" name="taux_horaire" value="<?= $interimaireObject->getTauxHoraire() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="evaluateur" class="control-label">Evaluateur :</label>
                                <div class="controls">
                                    <input type="text"  class="span11" placeholder="Evaluateur" name="evaluateur" value="<?= $interimaireObject->getEvaluateur()  ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="evaluation" class="control-label">Evaluation :</label>
                                <div class="controls">
                                    <input type="text"  class="span11" placeholder="Evaluation" name="evaluation" value="<?= $interimaireObject->getEvaluation() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="evaluation_chantier_id" class="control-label">Chantier d'évaluation :</label>
                                <div class="controls mySelect">
                                    <?php $selectChantier->displayHTML(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="charte_securite" class="control-label">Charte de sécurité ?</label>
                                <div class="controls">
                                    <input type="checkbox" name="charte_securite" <?php if($interimaireObject->isCharteSecurite()==1) : ?> checked <?php endif; ?> value="<?= $interimaireObject->isCharteSecurite()?> "/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_evaluation" class="control-label">Date d'évaluation :</label>
                                <div class="controls">
                                    <input type="text"  name="date_evaluation" class="datepicker" value="<?= $interimaireObject->getDateEvaluation()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_vm" class="control-label">Date VM :</label>
                                <div class="controls">
                                    <input type="text"  name="date_vm" class="datepicker" value="<?= $interimaireObject->getDateVm()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_prem_cont" class="control-label">Date premier contrat :</label>
                                <div class="controls">
                                    <input type="text"   name="date_prem_cont" class="datepicker" value="<?= $interimaireObject->getDatePremCont()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_cont_rec" class="control-label">Date contrat reconduit :</label>
                                <div class="controls">
                                    <input type="text"   name="date_cont_rec" class="datepicker" value="<?= $interimaireObject->getDateContRec()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_deb" class="control-label">Date début :</label>
                                <div class="controls">
                                    <input type="text"   name="date_deb" class="datepicker" value="<?= $interimaireObject->getDateDeb()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_fin" class="control-label">Date fin :</label>
                                <div class="controls">
                                    <input type="text"  name="date_fin" class="datepicker" value="<?= $interimaireObject->getDateFin()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="worker_status" class="control-label">Type de travailleur :</label>
                                <div class="controls">
                                    <input type="text"  class="span11" placeholder="Type de travailleur" name="worker_status" value="<?= $interimaireObject->getWorkerStatus() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="rem_med" class="control-label">Remarques médicales :</label>
                                <div class="controls">
                                    <input type="text"  class="span11" placeholder="Remarques médicales" name="rem_med" value="<?= $interimaireObject->getRemMed() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="remarques" class="control-label">Remarques :</label>
                                <div class="controls">
                                    <input type="text"  class="span11" placeholder="Remarques" name="remarques" value="<?= $interimaireObject->getRemarques() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="old_metier_denomination" class="control-label">Ancien poste :</label>
                                <div class="controls">
                                    <input type="text"  class="span11" placeholder="Ancien poste" name="old_metier_denomination" value="<?= $interimaireObject->getOldMetierDenomination() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="metier_id" class="control-label">Poste actuel :</label>
                                <div class="controls mySelect">
                                    <?php $selectMetier->displayHTML(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="agence_id" class="control-label">Agence d'intérim :</label>
                                <div class="controls mySelect">
                                    <?php $selectAgence->displayHTML(); ?>
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