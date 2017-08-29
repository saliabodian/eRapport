<div id="content">
    <div id="content-header">
        <hr>
        <h1>Gestion des Types de tâches</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Sélection d'un type de tâche</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="get" class="form-horizontal">
                            <div class="controls-row">
                                <label class="control-label span3 m-wrap">Liste des types de tâches</label>
                                <div class="controls span3 m-wrap">
                                    <?php $selectTypeTache->displayHTML(); ?>
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
                        <h5><?php if ($typeTacheObject->getId() > 0) : ?>Modification d'un <?php else : ?>Ajout d'un <?php endif ?>type de tâche</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form action="" method="post" class="form-horizontal">
                            <input type="hidden" name="type_tache_id" value="<?= $typeTacheObject->getId() ?>">
                            <div class="control-group">
                                <label class="control-label" for="code">Code <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Code" name="code_type_tache"  value="<?= $typeTacheObject->getCodeTypeTache() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="nom" class="control-label">Nom <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nom" name="nom_type_tache"  value="<?= $typeTacheObject->getNomTypeTache()?>"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span2 btn-block"></div>
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Enregistrer</button>
                                </div>
                                <div class="span4">
                                    <a href="?delete=<?= $typeTacheObject->getId() ?>" class="btn btn-warning  btn-block<?php if ($typeTacheObject->getId() <= 0) : ?> disabled<?php endif; ?>" role="button" aria-disabled="true">Supprimer</a>
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