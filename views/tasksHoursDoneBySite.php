<div id="content">
    <div id="content-header">
        <hr>
        <h1>Nombre d'heures effectuées sur une tâche par chantier</h1>
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
                                <label class="control-label">
                                    Catégorie de tâches <span>*</span> :
                                </label>
                                <div class="controls mySelect">
                                    <select class="typeTask" name="type_task" onchange="getId(this.value)">
                                        <option value="">choose</option>
                                        <?php foreach($listTypeTache as $typeTache) :?>
                                            <option value="<?= $typeTache['id']?>"> <?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    Tâche <span>*</span> :
                                </label>
                                <div class="controls mySelect">
                                    <select class=" mySelect task select2-container" name="tasks">
                                        <option value="">choose</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_deb" class="control-label">
                                    Date début <span>*</span> :
                                </label>
                                <div class="controls">
                                    <input name="date_deb" autocomplete="off" class="datepicker" value=""/>
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
                    <?php if(!empty($tasksHoursDonebySiteHeader)){ ?>
                        <div class="widget-box">
                            <?php foreach ($tasksHoursDonebySiteHeader as $tableHeader ) : ?>
                                <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                    <h5>Tableau récapitulatif nombres d'heures effectuées par tâches par chantier Entre <?= date('d-m-Y', strtotime($dateDeb)) ?> et <?= date('d-m-Y', strtotime($dateFin))  ?></h5>
                                </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th><?=$tableHeader['code'].' '.$tableHeader['nom']?> / <?= date('d-m-Y', strtotime($dateDeb)) ?> - <?= date('d-m-Y', strtotime($dateFin))  ?> / <?=$tableHeader['code_tache'].' '.$tableHeader['nom_tache']. ' / Total = '.$tableHeader['task_hours'].' Hrs '?></th>
                                    </tr>
                                </table>
                            </div>
                                <?php if(!empty($tasksHoursDonebySite)) : ?>
                                    <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                        <h5>Détail des heures effectuées par tâches par chantier</h5>
                                    </div>
                                    <div class="widget-content nopadding">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>Ouvriers / Intérimaires</th>
                                                <th>heures effectuées</th>
                                            </tr>
                                            <tbody>
                                            <?php foreach($tasksHoursDonebySite as $tasksHoursDone) :?>
                                                <?php if(($tasksHoursDone['id_tache'] === $tableHeader['id_tache']) && ($tasksHoursDone['id'] === $tableHeader['id']) ) : ?>
                                                    <tr>
                                                        <td><?= isset($tasksHoursDone['ouvrier_id'])? $tasksHoursDone['ouvrier_id'] : (isset($tasksHoursDone['interimaire_id'])? $tasksHoursDone['interimaire_id'] : '')?> - <?= $tasksHoursDone['fullname'] ?></td>
                                                        <td><?= $tasksHoursDone['task_hours'] ?></td>
                                                    </tr>
                                                <?php endif ; ?>
                                            <?php endforeach ; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif ; ?>
                                <hr>
                            <?php endforeach ;?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if(!empty($tasksHoursDonebySiteHeader)) : ?>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Export en CSV</h5>
                        </div>
                        <?php include 'alert.php'; ?>
                        <div class="widget-content nopadding">
                            <form action="tasksHoursDoneBySiteXls.php" method="get" class="form-horizontal">
                                <input type="hidden" name="chantier_id" value="<?= isset($_POST['chantier_id']) ? $_POST['chantier_id'] : ''?>">
                                <input type="hidden" name="date_deb" value="<?= isset($dateDeb) ? $dateDeb : ''?>">
                                <input type="hidden" name="date_fin" value="<?= isset($dateFin) ? $dateFin : ''?>">
                                <input type="hidden" name="tasks" value="<?= isset($tasks) ? $tasks : ''?>">
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