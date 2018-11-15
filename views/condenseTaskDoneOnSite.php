<div id="content">
    <div id="content-header">
        <hr>
        <h1>Résumé d'heures effectuées par tâche par chantier</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Formulaire de recherche</h5>
                    </div>
                    <?php include 'alert.php'; ?>
                    <div class="widget-content nopadding">
                        <form action="" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label for="chantier" class="control-label">
                                    Chantier <span>*</span> :
                                </label>
                                <div class="controls mySelect">
                                    <?php $selectChantier->displayHTML(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_deb" class="control-label">
                                    Date début <span>*</span> :
                                </label>
                                <div class="controls">
                                    <input autocomplete="off" name="date_deb" class="datepicker" value=""/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_fin" class="control-label">
                                    Date fin <span>*</span> :
                                </label>
                                <div class="controls">
                                    <input name="date_fin" autocomplete="off" class="datepicker" value=""/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span4 btn-block"></div>
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Rechercher</button>
                                </div>

                                <div class=" span4 btn-block"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <?php if(!empty($condenseTaskDoneOnSite)){ ?>
                        <div class="widget-box">
                                <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                    <h5>Résumé du nombre d'heures effectuées par tâches et par chantier Entre <?= date('d-m-Y', strtotime($dateDeb)) ?> et <?= date('d-m-Y', strtotime($dateFin))  ?></h5>
                                </div>
                                    <div class="widget-content nopadding">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>Code chantier</th>
                                                <th>Nom chantier</th>
                                                <th>Code tâche</th>
                                                <th>Nom tâche</th>
                                                <th>Heures</th>
                                            </tr>
                                            <tbody>
                                            <?php foreach($condenseTaskDoneOnSite as $taskDoneOnSite) :?>
                                                <tr>
                                                    <td><?= $taskDoneOnSite['code_chantier'] ?></td>
                                                    <td><?= $taskDoneOnSite['nom_chantier'] ?></td>
                                                    <td><?= $taskDoneOnSite['code_tache'] ?></td>
                                                    <td><?= $taskDoneOnSite['nom_tache'] ?></td>
                                                    <td><?= $taskDoneOnSite['heures'] ?></td>
                                                </tr>
                                            <?php endforeach ; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <hr>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if(!empty($condenseTaskDoneOnSite)) : ?>
            <div class="row-fluid">
                <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                                <h5>Export en CSV</h5>
                            </div>
                            <?php include 'alert.php'; ?>
                            <div class="widget-content nopadding">
                                <form action="condenseTaskDoneOnSiteXls.php" method="get" class="form-horizontal">
                                    <input type="hidden" name="chantier_id" value="<?= isset($_POST['chantier_id']) ? $_POST['chantier_id'] : ''?>">
                                    <input type="hidden" name="date_deb" value="<?= isset($dateDeb) ? $dateDeb : ''?>">
                                    <input type="hidden" name="date_fin" value="<?= isset($dateFin) ? $dateFin : ''?>">
                                    <div class="form-actions">
                                        <div class=" span4 btn-block"></div>
                                        <div class="span4">
                                            <button type="submit" class="btn btn-inverse btn-block" >Export en CSV</button>
                                        </div>
                                        <div class=" span4 btn-block"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        <?php endif ; ?>
    </div>
</div>