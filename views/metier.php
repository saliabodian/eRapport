<div id="content">
    <div id="content-header">
        <hr>
        <h1>Gestion des métiers</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Sélection d'un métier</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="get" class="form-horizontal">
                            <div class="controls-row">
                                <label class="control-label span3 m-wrap">Liste des métiers</label>
                                <div class="controls span3 m-wrap">
                                    <?php $selectMetier->displayHTML(); ?>
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
                        <h5><?php if ($metierObject->getId() > 0) : ?>Modification d'un <?php else : ?>Ajout d'un <?php endif ?>métier</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form action="" method="post" class="form-horizontal">
                            <input type="hidden" name="metier_id" value="<?= $metierObject->getId() ?>">
                            <div class="control-group">
                                <label class="control-label" for="code">Code <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Code" name="code_metier"  value="<?= $metierObject->getCodeMetier() ?>"
                                        />
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="nom" class="control-label">Nom :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nom" name="nom_metier"  value="<?= $metierObject->getNomMetier()?>"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span2 btn-block"></div>
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Enregistrer</button>
                                </div>
                                <div class="span4">
                                    <a href="?delete=<?= $metierObject->getId() ?>" class="btn btn-warning  btn-block<?php if ($metierObject->getId() <= 0) : ?> disabled<?php endif; ?>" role="button" aria-disabled="true">Supprimer</a>
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