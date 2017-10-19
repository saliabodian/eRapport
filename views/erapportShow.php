<div id="content">
    <div id="content-header">
        <hr>
        <h1>Rapport journalier du <?= $rapportJournalierDate ?> - Noyau : <?= $chefDequipeMatricule ?>  </h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <?php include 'alert.php'; ?>
                    <?php if(!empty($rapportNoyau)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Rapport journalier du noyau</h5>
                            </div>
                            <div class="widget-content">
                            <form method="post" action="rapportDetail.php">
                                <input type="hidden" name="rapport_type" value="NOYAU"/>
                                <input type="hidden" name="rapport_id" value="<?= $_GET['rapport_id']?>"/>
                                <input type="hidden" name="chef_dequipe_id" value="<?= $_GET['chef_dequipe_id']?>"/>
                                <input type="hidden" name="chef_dequipe_matricule" value="<?= $_GET['chef_dequipe_matricule']?>"/>
                                <input type="hidden" name="date_generation" value="<?= $_GET['date_generation']?>"/>
                                <input type="hidden" name="chantier_code" value="<?= $_GET['chantier_code']?>"/>
                                <input type="hidden" name="chantier_id" value="<?= $_GET['chantier_id']?>"/>
                                <table class="table table-bordered table-striped with-check">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="check_all" id="check_all" value=""/></th>
                                            <th>Nom Complet</th>
                                            <th>Heures</th>
                                                <?php if(!empty($noyauHeader)) :?>
                                                    <?php foreach($noyauHeader as $noyauHeaderdetail) : ?>
                                                        <th><?= $noyauHeaderdetail['code']?></th>
                                                    <?php endforeach ; ?>
                                                <?php endif; ?>
                                            <th>Abs</th>
                                            <th>T. Pénibles</th>
                                            <th>T. (Km)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rapportNoyau as $rapport ) : ?>
                                            <tr>
                                                <td><input type="checkbox" name="selected_matricule[]" class="checkbox checkbox_noyau" value="<?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?>" /></td>
                                                <td><?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?> - <?=$rapport['fullname']?><?= ($rapport['dpl_pers']=== '1')? ' (T)' : '' ?></td>
                                                <td><?= $rapport['htot'] ?></td>
                                                <?php if(!empty($noyauHeader)) :?>
                                                    <?php foreach($noyauHeader as $noyauHeaderdetail) : ?>
                                                            <?php if($rapport['task_id_1'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_1']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_2'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_2']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_3'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_3']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_4'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_4']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_5'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_5']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_6'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_6']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php else : ?>
                                                                <td></td>
                                                            <?php endif ; ?>
                                                    <?php endforeach ; ?>
                                                <?php endif ; ?>
                                                <td ><?= $rapport['habs'] ?></td>
                                                <td ><?= $rapport['hins'] ?></td>
                                                <td ><?= $rapport['km'] ?></td>
                                            </tr>
                                        <?php  endforeach;  ?>
                                        <tr>
                                            <td colspan="2">Totaux</td>
                                            <td><?= $noyauHourGlobal; ?></td>
                                            <?php if(!empty($noyauHeader)) :?>
                                                <?php foreach($noyauHeader as $noyauHeaderdetail) : ?>
                                                    <td><?= $noyauHeaderdetail['vht'] ?></td>
                                                <?php endforeach ; ?>
                                            <?php endif ; ?>
                                            <td><?= $noyauHourAbsencesGlobal; ?></td>
                                            <td><?= $noyauHourPenibleGlobal; ?></td>
                                            <td><?= $noyauKmGlobal; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                            </form>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <?php if(!empty($rapportNoyauAbsent)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Rapport journalier des absents du noyau</h5>
                            </div>
                            <div class="widget-content">
                                <form method="post" action="rapportDetail.php">
                                    <input type="hidden" name="rapport_type" value="ABSENT"/>
                                    <input type="hidden" name="rapport_id" value="<?= $_GET['rapport_id']?>"/>
                                    <input type="hidden" name="chef_dequipe_id" value="<?= $_GET['chef_dequipe_id']?>"/>
                                    <input type="hidden" name="chef_dequipe_matricule" value="<?= $_GET['chef_dequipe_matricule']?>"/>
                                    <input type="hidden" name="date_generation" value="<?= $_GET['date_generation']?>"/>
                                    <input type="hidden" name="chantier_code" value="<?= $_GET['chantier_code']?>"/>
                                    <input type="hidden" name="chantier_id" value="<?= $_GET['chantier_id']?>"/>
                                    <table class="table table-bordered table-striped with-check">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" name="check_all_abs" id="check_all_abs" value=""/></th>
                                                <th>Nom Complet</th>
                                                <th>Heures</th>
                                                    <?php if(!empty($noyauAbsentHeader)) :?>
                                                        <?php foreach($noyauAbsentHeader as $noyauHeaderdetail) : ?>
                                                            <th><?= $noyauHeaderdetail['code']?></th>
                                                        <?php endforeach ; ?>
                                                    <?php endif; ?>
                                                <th>Abs</th>
                                                <th>T. Pénibles</th>
                                                <th>T. (Km)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($rapportNoyauAbsent as $rapport ) : ?>
                                                <tr>
                                                    <td><input type="checkbox" name="selected_matricule[]" class="checkbox checkbox_abs" value="<?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?>" /></td>
                                                    <td><?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?> - <?=$rapport['fullname']?></td>
                                                    <td ><?= $rapport['htot'] ?></td>
                                                    <?php if (!empty($noyauAbsentHeader)) : ?>
                                                        <?php foreach($noyauAbsentHeader as $noyauHeaderdetail) : ?>
                                                            <?php if($rapport['task_id_1'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauAbsentTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_1']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_2'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauAbsentTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_2']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_3'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauAbsentTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_3']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_4'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauAbsentTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_4']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_5'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauAbsentTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_5']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_6'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauAbsentTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_6']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php else : ?>
                                                                <td></td>
                                                            <?php endif ; ?>
                                                        <?php endforeach ; ?>
                                                    <?php endif ;?>
                                                    <td ><?= $rapport['habs'] ?></td>
                                                    <td ><?= $rapport['hins'] ?></td>
                                                    <td ><?= $rapport['km'] ?></td>
                                                </tr>
                                            <?php  endforeach;  ?>
                                            <tr>
                                                <td colspan="2">Totaux</td>
                                                <td><?= $absentHourGlobal; ?></td>
                                                <?php if(!empty($noyauAbsentHeader)) :?>
                                                    <?php foreach($noyauAbsentHeader as $noyauHeaderdetail) : ?>
                                                        <td><?= $noyauHeaderdetail['vht'] ?></td>
                                                    <?php endforeach ; ?>
                                                <?php endif ; ?>
                                                <td><?= $absentHourAbsencesGlobal; ?></td>
                                                <td><?= $absentHourPenibleGlobal; ?></td>
                                                <td><?= $absentKmGlobal; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <?php if(!empty($rapportHorsNoyau)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Rapport journalier des hors noyau</h5>
                            </div>
                            <div class="widget-content">
                            <form method="post" action="rapportDetail.php">
                                <input type="hidden" name="rapport_id" value="<?= $_GET['rapport_id']?>"/>
                                <input type="hidden" name="rapport_type" value="HORSNOYAU"/>
                                <input type="hidden" name="chef_dequipe_id" value="<?= $_GET['chef_dequipe_id']?>"/>
                                <input type="hidden" name="chef_dequipe_matricule" value="<?= $_GET['chef_dequipe_matricule']?>"/>
                                <input type="hidden" name="date_generation" value="<?= $_GET['date_generation']?>"/>
                                <input type="hidden" name="chantier_code" value="<?= $_GET['chantier_code']?>"/>
                                <input type="hidden" name="chantier_id" value="<?= $_GET['chantier_id']?>"/>
                                <table class="table table-bordered table-striped with-check">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="check_hn" id="check_hn" value=""/></th>
                                            <th>Nom Complet</th>
                                            <th>Heures</th>
                                                <?php if(!empty($horsNoyauHeader)) :?>
                                                    <?php foreach($horsNoyauHeader as $noyauHeaderdetail) : ?>
                                                        <th><?= $noyauHeaderdetail['code']?></th>
                                                    <?php endforeach ; ?>
                                                <?php endif; ?>
                                            <th>Abs</th>
                                            <th>T. Pénibles</th>
                                            <th>T. (Km)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rapportHorsNoyau as $rapport ) : ?>
                                            <tr>
                                                <td><input type="checkbox" name="selected_matricule[]" class="checkbox checkbox_hn" value="<?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?>" /></td>
                                                <td ><?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?> - <?=$rapport['fullname']?></td>
                                                <td ><?= $rapport['htot'] ?></td>
                                                <?php if (!empty($horsNoyauHeader)) : ?>
                                                    <?php foreach($horsNoyauHeader as $noyauHeaderdetail) : ?>
                                                        <?php if($rapport['task_id_1'] === $noyauHeaderdetail['tache_id']) : ?>
                                                            <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                <?php if($task['tache_id']=== $rapport['task_id_1']) : ?>
                                                                    <td><?= $task['vhr'] ?></td>
                                                                <?php endif; ?>
                                                            <?php endforeach ; ?>
                                                        <?php elseif ($rapport['task_id_2'] === $noyauHeaderdetail['tache_id']) : ?>
                                                            <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                <?php if($task['tache_id']=== $rapport['task_id_2']) : ?>
                                                                    <td><?= $task['vhr'] ?></td>
                                                                <?php endif; ?>
                                                            <?php endforeach ; ?>
                                                        <?php elseif ($rapport['task_id_3'] === $noyauHeaderdetail['tache_id']) : ?>
                                                            <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                <?php if($task['tache_id']=== $rapport['task_id_3']) : ?>
                                                                    <td><?= $task['vhr'] ?></td>
                                                                <?php endif; ?>
                                                            <?php endforeach ; ?>
                                                        <?php elseif ($rapport['task_id_4'] === $noyauHeaderdetail['tache_id']) : ?>
                                                            <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                <?php if($task['tache_id']=== $rapport['task_id_4']) : ?>
                                                                    <td><?= $task['vhr'] ?></td>
                                                                <?php endif; ?>
                                                            <?php endforeach ; ?>
                                                        <?php elseif ($rapport['task_id_5'] === $noyauHeaderdetail['tache_id']) : ?>
                                                            <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                <?php if($task['tache_id']=== $rapport['task_id_5']) : ?>
                                                                    <td><?= $task['vhr'] ?></td>
                                                                <?php endif; ?>
                                                            <?php endforeach ; ?>
                                                        <?php elseif ($rapport['task_id_6'] === $noyauHeaderdetail['tache_id']) : ?>
                                                            <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                <?php if($task['tache_id']=== $rapport['task_id_6']) : ?>
                                                                    <td><?= $task['vhr'] ?></td>
                                                                <?php endif; ?>
                                                            <?php endforeach ; ?>
                                                        <?php else : ?>
                                                            <td></td>
                                                        <?php endif ; ?>
                                                    <?php endforeach ; ?>
                                                <?php endif ;?>
                                                <td ><?= $rapport['habs'] ?></td>
                                                <td ><?= $rapport['hins'] ?></td>
                                                <td ><?= $rapport['km'] ?></td>
                                            </tr>
                                        <?php  endforeach;  ?>
                                        <tr>
                                            <td colspan="2">Totaux</td>
                                            <td><?= $horsNoyauHourGlobal; ?></td>
                                            <?php if(!empty($horsNoyauHeader)) :?>
                                                <?php foreach($horsNoyauHeader as $noyauHeaderdetail) : ?>
                                                    <td><?= $noyauHeaderdetail['vht'] ?></td>
                                                <?php endforeach ; ?>
                                            <?php endif ; ?>
                                            <td><?= $horsNoyauHourAbsencesGlobal; ?></td>
                                            <td><?= $horsNoyauHourPenibleGlobal; ?></td>
                                            <td><?= $horsNoyauKmGlobal; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                            </form>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="row-fluid">
                <div class="span12">
                    <a class="span4 btn btn-warning">Valider le rapport</a>
                    <a class="span4 btn btn-info">Regénérer le rapport</a>
                    <a class="span4 btn btn-danger">Supprimer le rapport</a>
                </div>
            </fieldset>
        </div>
    </div>
</div>