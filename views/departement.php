<div id="content">
    <div id="content-header">
        <hr>
        <h1>Gestion des départements</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Sélection d'un département</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="get" class="form-horizontal">
                            <div class="controls-row">
                                <label class="control-label span3 m-wrap">Liste des départements</label>
                                <div class="controls span3 m-wrap">
                                    <?php $selectDpt->displayHTML(); ?>
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
                        <h5><?php if ($dptObject->getId() > 0) : ?>Modification d'un <?php else : ?>Ajout d'un <?php endif ?>département</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form action="" method="post" class="form-horizontal">
                            <input type="hidden" name="dpt_id" value="<?= $dptObject->getId() ?>">
                            <div class="control-group">
                                <label class="control-label" for="code_dpt">Code département <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Code département" name="code_dpt"  value="<?= $dptObject->getCodeDpt() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="nom_dpt">Nom Département <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nom département" name="nom_dpt"  value="<?= $dptObject->getNomDpt() ?>"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span2 btn-block"></div>
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Enregistrer</button>
                                </div>
                                <div class="span4">
                                    <a href="?delete=<?= $dptObject->getId() ?>" class="btn btn-warning  btn-block<?php if ($dptObject->getId() <= 0) : ?> disabled<?php endif; ?>" role="button" aria-disabled="true">Supprimer</a>
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