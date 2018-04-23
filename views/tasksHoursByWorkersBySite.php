<div id="content">
    <div id="content-header">
        <hr>
        <h1>Nombre d'heures effectuées par Tâches / Travailleurs / Chantier</h1>
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
                                    <select class="chantier_id" name="chantier_id" onchange="getChantierId(this.value)">
                                        <option value="<?= isset($_POST['chantier_id'])? $_POST['chantier_id'] : '' ?>">choose</option>
                                        <?php foreach($listChantier as $chantier) :?>
                                            <option value="<?= $chantier['id']?>"> <?= $chantier['code'].' '.$chantier['nom']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="matricule" class="control-label">
                                    Nom Complet / Matricule :
                                </label>
                                <div class="controls mySelect">
                                    <select class=" mySelect fullname select2-container" name="fullname" onchange="getFullname(this.value)">
                                        <option value="">choose</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    Tâche :
                                </label>
                                <div class="controls mySelect">
                                    <select class=" mySelect tache_ouvrier select2-container" name="tache_ouvrier">
                                        <option value="">choose</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_deb" class="control-label">
                                    Date début <span>*</span> :
                                </label>
                                <div class="controls">
                                    <input name="date_deb" class="datepicker" value=""/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_fin" class="control-label">
                                    Date fin <span>*</span> :
                                </label>
                                <div class="controls">
                                    <input name="date_fin" class="datepicker" value=""/>
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
                    <div class="widget-box">
                        <?php if(!empty($tasksHoursByWorkersBySite)) : ?>
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Heures effectuées par Chantier / Ouvrier / Tâches Entre <?= date('d-m-Y', strtotime($dateDeb)) ?> et <?= date('d-m-Y', strtotime($dateFin))  ?></h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Date</th>
                                        <th>Chantier</th>
                                        <th>Ouvriers / Intérimaires</th>
                                        <th>Tâches</th>
                                        <th>Batiment</th>
                                        <th>Etage</th>
                                        <th>Axes</th>
                                        <th>Remarques</th>
                                        <th>heures effectuées</th>
                                    </tr>
                                    <tbody>
                                    <?php foreach($tasksHoursByWorkersBySite as $tasksHoursDone) :?>
                                        <tr>
                                            <td><?= date('d-m-Y', strtotime($tasksHoursDone['date'])) ?></td>
                                            <td><?= $tasksHoursDone['nom'] ?></td>
                                            <td><?= isset($tasksHoursDone['ouvrier_id'])? $tasksHoursDone['ouvrier_id'] : (isset($tasksHoursDone['interimaire_id'])? $tasksHoursDone['interimaire_id'] : '')?> - <?= $tasksHoursDone['fullname']?> </td>
                                            <td><?= $tasksHoursDone['code_tache'].' - '.$tasksHoursDone['nom_tache']?></td>
                                            <td><?= $tasksHoursDone['batiment'] ?></td>
                                            <td><?= $tasksHoursDone['axe'] ?></td>
                                            <td><?= $tasksHoursDone['etage'] ?></td>
                                            <td><?= $tasksHoursDone['remarque'] ?></td>
                                            <td><?= $tasksHoursDone['task_hours'] ?></td>
                                        </tr>
                                    <?php endforeach ; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif ; ?>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <div class="widget-box">
                        <?php if(!empty($tasksHoursByWorkersBySiteRecap)) : ?>
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Condensé heures effectuées par Chantier / Ouvrier / Tâches Entre <?= date('d-m-Y', strtotime($dateDeb)) ?> et <?= date('d-m-Y', strtotime($dateFin))  ?></h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Chantier</th>
                                        <th>Tâches</th>
                                        <th>heures effectuées</th>
                                    </tr>
                                    <tbody>
                                    <?php foreach($tasksHoursByWorkersBySiteRecap as $tasksHoursDone) :?>
                                        <tr>
                                            <td><?= $tasksHoursDone['nom'] ?></td>
                                            <td><?= $tasksHoursDone['code_tache'].' - '.$tasksHoursDone['nom_tache']?></td>
                                            <td><?= $tasksHoursDone['task_hours'] ?></td>
                                        </tr>
                                    <?php endforeach ; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif ; ?>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>