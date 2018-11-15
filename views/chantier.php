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
                                <label for="code" class="control-label">Numéro de chantier <span>*</span> :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Numéro de chantier" name="code"  value="<?= $chantierObject->getCode()?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="nom">Chantier <span>*</span> :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nom" name="nom"  value="<?= $chantierObject->getNom() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="adresse" class="control-label">Adresse :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Adresse" name="adresse"  value="<?= $chantierObject->getAdresse() ?>"/>
                                </div>
                            </div>
                            <!--div class="control-group field_wrapper">
                                <label for="batiment" class="control-label">Bâtiment :</label>
                                <div class="controls">
                                    <input id="spaceBottom" type="text" class="span4" placeholder="Batiment" name="bat[]"/>
                                    <a href="javascript:void(0);" class="add_button" title="Add field"><img src="img/plus-mini.png"/></a>
                                </div>
                            </div-->
                            <div class="control-group">
                                <label for="is_actif" class="control-label">Est Actif ?</label>
                                <div class="controls">
                                    <input type="checkbox" name="actif" <?php if($chantierObject->isActif()==1) : ?> checked <?php endif; ?> value="<?= $chantierObject->isActif()?> "/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="is_asc_mtn" class="control-label">Est une A.M. ?</label>
                                <div class="controls">
                                    <input type="checkbox" name="asc_mtn" <?php if($chantierObject->isAsc_mtn()==1) : ?> checked <?php endif; ?> value="<?= $chantierObject->isAsc_mtn()?> "/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Enregistrer</button>
                                </div>
                                <div class="span4">
                                    <a href="?delete=<?= $chantierObject->getId() ?>" class="btn btn-warning  btn-block<?php if ($chantierObject->getId() <= 0) : ?> disabled<?php endif; ?>" role="button" aria-disabled="true">Supprimer</a>
                                </div>
                                <div class="span4">
                                    <a href="batiment.php?chantier_id=<?= $chantierObject->getId() ?>" class="btn btn-block btn-primary <?php if ($chantierObject->getId() <= 0) : ?> disabled<?php endif; ?>" role="button" aria-disabled="true"> Ajout de bâtiment</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php if(!empty($batimentList)) :?>
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-home"></i></span>
                        <h5>Liste des bâtiments</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Bâtiment</th>
                                <th>Statut</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($batimentList as $batiment) :?>
                                <tr>
                                    <td class="taskDesc"><i class="icon-info-sign"></i> <?= $batiment['nom']?></td>
                                    <td class="taskOptions"><a href="batiment.php?id=<?= $batiment['id'] ?>" class="tip-top" data-original-title="Update"><i class="icon-eye-open"></i></a> </td>
                                </tr>
                                <?php endforeach ; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif ; ?>
    </div>
</div>