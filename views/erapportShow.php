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
                                <input type="hidden" name="validated" value="<?= $_GET['validated']?>"/>
                                <input type="hidden" name="submitted" value="<?= $_GET['submitted']?>"/>
                                <table class="table table-bordered with-check">
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
                                                <td>
                                                    <?php if ($rapport['htot'] != ($rapport['ht1'] + $rapport['ht2'] +$rapport['ht3'] +$rapport['ht4'] +$rapport['ht5'] + $rapport['ht6'])) : ?>
                                                        <img src="img/warning-yellow-black.png" alt="erreur volume horaire">
                                                    <?php endif ?>
                                                    <?php if (!empty($rapport['habs']) || !empty($rapport['abs'])) : ?>
                                                        <img src="img/dialog-stop-2.png" alt="absence saisie">
                                                    <?php endif ?>
                                                    <?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?> - <?=$rapport['fullname']?><?= ($rapport['dpl_pers']=== '1')? ' (T)' : '' ?>
                                                </td>
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
                                <?php if($_SESSION['post_id']==='1') :?>
                                    <?php if($_GET['submitted'] === '1') :?>
                                        <input disabled class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                    <?php else : ?>
                                        <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                    <?php endif ; ?>
                                <?php elseif($_SESSION['post_id']==='5' || $_SESSION['post_id']==='3') : ?>
                                    <?php if($_GET['validated'] === '1') :?>
                                        <input disabled class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                    <?php else : ?>
                                        <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                    <?php endif ; ?>
                                <?php else : ?>
                                    <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                <?php endif ; ?>
                                <hr>
                                <div class="controls">
                                    <?php if(!empty($noyauHeader)) : ?>
                                        <?php foreach($noyauHeader as $noyauHeaderdetail) : ?>
                                            <input type="text" class="span4" value="<?= $noyauHeaderdetail['code'].': '.$noyauHeaderdetail['nom']?>" disabled/>
                                        <?php endforeach; ?>
                                    <?php endif ; ?>
                                </div>
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
                                    <table class="table table-bordered with-check">
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
                                            <td>
                                                <?php if ($rapport['htot'] != ($rapport['ht1'] + $rapport['ht2'] +$rapport['ht3'] +$rapport['ht4'] +$rapport['ht5'] + $rapport['ht6'])) : ?>
                                                    <img src="img/warning-yellow-black.png" alt="erreur volume horaire">
                                                <?php endif ?>
                                                <?php if (!empty($rapport['habs']) || !empty($rapport['abs'])) : ?>
                                                    <img src="img/dialog-stop-2.png" alt="absence saisie">
                                                <?php endif ?><?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?> - <?=$rapport['fullname']?>
                                            </td>
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
                                    <?php if($_SESSION['post_id']==='1') :?>
                                        <?php if($_GET['submitted'] === '1') :?>
                                            <input disabled class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                        <?php else : ?>
                                            <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                        <?php endif ; ?>
                                    <?php elseif($_SESSION['post_id']==='5' || $_SESSION['post_id']==='3') : ?>
                                        <?php if($_GET['validated'] === '1') :?>
                                            <input disabled class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                        <?php else : ?>
                                            <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                        <?php endif ; ?>
                                    <?php else : ?>
                                        <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                    <?php endif ; ?>
                                    <hr>
                                    <div class="controls">
                                        <?php if(!empty($noyauAbsentHeader)) : ?>
                                            <?php foreach($noyauAbsentHeader as $noyauHeaderdetail) : ?>
                                                <input type="text" class="span4" value="<?= $noyauHeaderdetail['code'].': '.$noyauHeaderdetail['nom']?>" disabled/>
                                            <?php endforeach; ?>
                                        <?php endif ; ?>
                                    </div>
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
                    <?php if(!empty($rapportAbsentHorsNoyau)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Rapport journalier des absents hors noyau</h5>
                            </div>
                            <div class="widget-content">
                                <form method="post" action="rapportDetail.php">
                                    <input type="hidden" name="rapport_type" value="ABSENTHORSNOYAU"/>
                                    <input type="hidden" name="rapport_id" value="<?= $_GET['rapport_id']?>"/>
                                    <input type="hidden" name="chef_dequipe_id" value="<?= $_GET['chef_dequipe_id']?>"/>
                                    <input type="hidden" name="chef_dequipe_matricule" value="<?= $_GET['chef_dequipe_matricule']?>"/>
                                    <input type="hidden" name="date_generation" value="<?= $_GET['date_generation']?>"/>
                                    <input type="hidden" name="chantier_code" value="<?= $_GET['chantier_code']?>"/>
                                    <input type="hidden" name="chantier_id" value="<?= $_GET['chantier_id']?>"/>
                                    <table class="table table-bordered with-check">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" name="check_all_abs_hn" id="check_all_abs_hn" value=""/></th>
                                                <th>Nom Complet</th>
                                                <th>Heures</th>
                                                    <?php if(!empty($absentHorsNoyauHeader)) :?>
                                                        <?php foreach($absentHorsNoyauHeader as $noyauHeaderdetail) : ?>
                                                            <th><?= $noyauHeaderdetail['code']?></th>
                                                        <?php endforeach ; ?>
                                                    <?php endif; ?>
                                                <th>Abs</th>
                                                <th>T. Pénibles</th>
                                                <th>T. (Km)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($rapportAbsentHorsNoyau as $rapport ) : ?>
                                                <tr>
                                                    <td><input type="checkbox" name="selected_matricule[]" class="checkbox checkbox_abs_hn" value="<?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?>" /></td>
                                                    <td>
                                                        <?php if ($rapport['htot'] != ($rapport['ht1'] + $rapport['ht2'] +$rapport['ht3'] +$rapport['ht4'] +$rapport['ht5'] + $rapport['ht6'])) : ?>
                                                            <img src="img/warning-yellow-black.png" alt="erreur volume horaire">
                                                        <?php endif ?>
                                                        <?php if (!empty($rapport['habs']) || !empty($rapport['abs'])) : ?>
                                                            <img src="img/dialog-stop-2.png" alt="absence saisie">
                                                        <?php endif ?>
                                                        <?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?> - <?=$rapport['fullname']?>
                                                    </td>
                                                    <td ><?= $rapport['htot'] ?></td>
                                                    <?php if (!empty($absentHorsNoyauHeader)) : ?>
                                                        <?php foreach($absentHorsNoyauHeader as $noyauHeaderdetail) : ?>
                                                            <?php if($rapport['task_id_1'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($absentHorsNoyauTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_1']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_2'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($absentHorsNoyauTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_2']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_3'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($absentHorsNoyauTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_3']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_4'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($absentHorsNoyauTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_4']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_5'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($absentHorsNoyauTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_5']) : ?>
                                                                        <td><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_6'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($absentHorsNoyauTask[$rapport['id']] as $task) : ?>
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
                                                <td><?= $absentHorsNoyauHourGlobal; ?></td>
                                                <?php if(!empty($absentHorsNoyauHeader)) :?>
                                                    <?php foreach($absentHorsNoyauHeader as $noyauHeaderdetail) : ?>
                                                        <td><?= $noyauHeaderdetail['vht'] ?></td>
                                                    <?php endforeach ; ?>
                                                <?php endif ; ?>
                                                <td><?= $absentHorsNoyauHourAbsencesGlobal; ?></td>
                                                <td><?= $absentHorsNoyauHourPenibleGlobal; ?></td>
                                                <td><?= $absentHorsNoyauKmGlobal; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <?php if($_SESSION['post_id']==='1') :?>
                                        <?php if($_GET['submitted'] === '1') :?>
                                            <input disabled class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                        <?php else : ?>
                                            <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                        <?php endif ; ?>
                                    <?php elseif($_SESSION['post_id']==='5' || $_SESSION['post_id']==='3') : ?>
                                        <?php if($_GET['validated'] === '1') :?>
                                            <input disabled class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                        <?php else : ?>
                                            <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                        <?php endif ; ?>
                                    <?php else : ?>
                                        <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                    <?php endif ; ?>
                                    <hr>
                                    <div class="controls">
                                        <?php if(!empty($absentHorsNoyauHeader)) : ?>
                                            <?php foreach($absentHorsNoyauHeader as $noyauHeaderdetail) : ?>
                                                <input type="text" class="span4" value="<?= $noyauHeaderdetail['code'].': '.$noyauHeaderdetail['nom']?>" disabled/>
                                            <?php endforeach; ?>
                                        <?php endif ; ?>
                                    </div>
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
                                <table class="table table-bordered with-check">
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
                                            <th>MAJ. Par</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rapportHorsNoyau as $rapport ) : ?>
                                            <tr>
                                            <?php if($_SESSION['post_id'] === '1') : ?>
                                                <?php if($rapport['chef_dequipe_updated'] === $_SESSION['username']): ?>
                                                    <td><input type="checkbox" name="selected_matricule[]" class="checkbox checkbox_hn" value="<?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?>"/></td>
                                                <?php elseif(empty($rapport['chef_dequipe_updated'])) : ?>
                                                    <td><input type="checkbox" name="selected_matricule[]" class="checkbox checkbox_hn" value="<?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?>" /></td>
                                                <?php else : ?>
                                                    <td><input type="checkbox" name="selected_matricule[]" class="checkbox checkbox_hn" value="<?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?>" disabled/></td>
                                                <?php endif ; ?>
                                            <?php else : ?>
                                                <td><input type="checkbox" name="selected_matricule[]" class="checkbox checkbox_hn" value="<?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?>"/></td>
                                            <?php endif ; ?>
                                                <td >
                                                    <?php if ($rapport['htot'] != ($rapport['ht1'] + $rapport['ht2'] +$rapport['ht3'] +$rapport['ht4'] +$rapport['ht5'] + $rapport['ht6'])) : ?>
                                                        <img src="img/warning-yellow-black.png" alt="erreur volume horaire">
                                                    <?php endif ?>
                                                    <?php if (!empty($rapport['habs']) || !empty($rapport['abs'])) : ?>
                                                        <img src="img/dialog-stop-2.png" alt="absence saisie">
                                                    <?php endif ?>
                                                    <?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?> - <?=$rapport['fullname']?>
                                                </td>
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
                                                <td ><?= isset($rapport['chef_dequipe_updated']) ? $rapport['chef_dequipe_updated'] : '' ?></td>
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
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <?php if($_SESSION['post_id']==='1') :?>
                                    <?php if($_GET['submitted'] === '1') :?>
                                        <input disabled class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                    <?php else : ?>
                                        <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                    <?php endif ; ?>
                                <?php elseif($_SESSION['post_id']==='5' || $_SESSION['post_id']==='3') : ?>
                                    <?php if($_GET['validated'] === '1') :?>
                                        <input disabled class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                    <?php else : ?>
                                        <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                    <?php endif ; ?>
                                <?php else : ?>
                                    <input class="span4 btn btn-success" type="submit" value="Renseigner les tâches">
                                <?php endif ; ?>
                                <hr>
                                <?php if(!empty($horsNoyauHeader)) : ?>
                                    <?php foreach($horsNoyauHeader as $noyauHeaderdetail) : ?>
                                        <input type="text" class="span4" value="<?= $noyauHeaderdetail['code'].': '.$noyauHeaderdetail['nom']?>" disabled/>
                                    <?php endforeach ; ?>
                                <?php endif ; ?>
                            </form>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <hr>
        <form method="get" action="erapport.php">
            <div class="row-fluid span12 selfInline" >
                <div class="control-group ">
                    Je confirme que les informations saisies sont correctes .
                    <input type="checkbox" name="isValid">
                </div>
            </div>
            <div class="row-fluid" >
                    <div class="span12">
                        <input type="hidden" name="rapport_id" value="<?= $_GET['rapport_id'] ?>">
                        <input type="hidden" name="rapport_type" value="<?= $_GET['rapport_type'] ?>">
                        <input type="hidden" name="chef_dequipe_id" value="<?= $_GET['chef_dequipe_id'] ?>">
                        <input type="hidden" name="chef_dequipe_matricule" value="<?= $_GET['chef_dequipe_matricule'] ?>">
                        <input type="hidden" name="date_generation" value="<?= $_GET['date_generation'] ?>">
                        <input type="hidden" name="chantier_id" value="<?= $_GET['chantier_id'] ?>">
                        <input type="hidden" name="chantier_code" value="<?= $_GET['chantier_code'] ?>">
                        <div class=" span4 btn-block"></div>
                        <?php if($_SESSION['post_id']==='1') :?>
                            <?php if($_GET['submitted'] === '1') :?>
                                <button disabled style="margin: auto" type="submit" class="span4 btn btn-warning" name="val" value="true">Valider</button>
                            <?php else : ?>
                                <button style="margin: auto" type="submit" class="span4 btn btn-warning" name="val" value="true">Valider</button>
                            <?php endif ; ?>
                        <?php elseif($_SESSION['post_id']==='5' || $_SESSION['post_id']==='3') : ?>
                            <?php if($_GET['validated'] === '1') :?>
                                <button disabled style="margin: auto" type="submit" class="span4 btn btn-warning" name="val" value="true">Valider</button>
                            <?php else : ?>
                                <button style="margin: auto" type="submit" class="span4 btn btn-warning" name="val" value="true">Valider</button>
                            <?php endif ; ?>
                        <?php else : ?>
                            <button style="margin: auto" type="submit" class="span4 btn btn-warning" name="val" value="true">Valider</button>
                        <?php endif ; ?>
                        <div class=" span4 btn-block"></div>
                    </div>
                    <div class="span12">
                        <div class=" span1 btn-block"></div>
                        <?php if($_SESSION['post_id']=== '1' || $_SESSION['post_id']==='3' || $_SESSION['post_id']==='5'): ?>
                            <a style="margin-top: 5px ; margin-right: 3px ; margin-left: 3px" href="erapport.php?rapport_id=<?= $_GET['rapport_id']?>&rapport_type=<?=$_GET['rapport_type']?>&chef_dequipe_id=<?=$_GET['chef_dequipe_id']?>&chef_dequipe_matricule=<?= $_GET['chef_dequipe_matricule']?>&date_generation=<?= $_GET['date_generation'] ?>&chantier_id=<?= $_GET['chantier_id']?>&chantier_code=<?= $_GET['chantier_code']?>&inval=true" class="span2 btn btn-primary" disabled>Invalider le rapport</a>
                        <?php else : ?>
                            <a style="margin-top: 5px ; margin-right: 3px ; margin-left: 3px" href="erapport.php?rapport_id=<?= $_GET['rapport_id']?>&rapport_type=<?=$_GET['rapport_type']?>&chef_dequipe_id=<?=$_GET['chef_dequipe_id']?>&chef_dequipe_matricule=<?= $_GET['chef_dequipe_matricule']?>&date_generation=<?= $_GET['date_generation'] ?>&chantier_id=<?= $_GET['chantier_id']?>&chantier_code=<?= $_GET['chantier_code']?>&inval=true" class="span2 btn btn-primary">Invalider le rapport</a>
                        <?php endif ; ?>
                        <?php if($_SESSION['post_id']==='1') :?>
                            <?php if($_GET['submitted'] === '1') :?>
                                <a disabled style="margin-top: 5px ; margin-right: 3px ; margin-left: 3px" href="?rapport_id=<?= $_GET['rapport_id']?>&rapport_type=<?=$_GET['rapport_type']?>&chef_dequipe_id=<?=$_GET['chef_dequipe_id']?>&chef_dequipe_matricule=<?= $_GET['chef_dequipe_matricule']?>&date_generation=<?= $_GET['date_generation'] ?>&chantier_id=<?= $_GET['chantier_id']?>&chantier_code=<?= $_GET['chantier_code']?>&reg=true" class="span2 btn btn-info">Regénérer le rapport</a>
                            <?php else : ?>
                                <a style="margin-top: 5px ; margin-right: 3px ; margin-left: 3px" href="?rapport_id=<?= $_GET['rapport_id']?>&rapport_type=<?=$_GET['rapport_type']?>&chef_dequipe_id=<?=$_GET['chef_dequipe_id']?>&chef_dequipe_matricule=<?= $_GET['chef_dequipe_matricule']?>&date_generation=<?= $_GET['date_generation'] ?>&chantier_id=<?= $_GET['chantier_id']?>&chantier_code=<?= $_GET['chantier_code']?>&reg=true" class="span2 btn btn-info">Regénérer le rapport</a>
                            <?php endif ; ?>
                        <?php elseif ($_SESSION['post_id']==='5' || $_SESSION['post_id']==='3') :?>
                            <?php if($_GET['validated'] === '1') :?>
                                <a disabled style="margin-top: 5px ; margin-right: 3px ; margin-left: 3px" href="?rapport_id=<?= $_GET['rapport_id']?>&rapport_type=<?=$_GET['rapport_type']?>&chef_dequipe_id=<?=$_GET['chef_dequipe_id']?>&chef_dequipe_matricule=<?= $_GET['chef_dequipe_matricule']?>&date_generation=<?= $_GET['date_generation'] ?>&chantier_id=<?= $_GET['chantier_id']?>&chantier_code=<?= $_GET['chantier_code']?>&reg=true" class="span2 btn btn-info">Regénérer le rapport</a>
                            <?php else : ?>
                                <a style="margin-top: 5px ; margin-right: 3px ; margin-left: 3px" href="?rapport_id=<?= $_GET['rapport_id']?>&rapport_type=<?=$_GET['rapport_type']?>&chef_dequipe_id=<?=$_GET['chef_dequipe_id']?>&chef_dequipe_matricule=<?= $_GET['chef_dequipe_matricule']?>&date_generation=<?= $_GET['date_generation'] ?>&chantier_id=<?= $_GET['chantier_id']?>&chantier_code=<?= $_GET['chantier_code']?>&reg=true" class="span2 btn btn-info">Regénérer le rapport</a>
                            <?php endif ; ?>
                        <?php else : ?>
                            <a style="margin-top: 5px ; margin-right: 3px ; margin-left: 3px" href="?rapport_id=<?= $_GET['rapport_id']?>&rapport_type=<?=$_GET['rapport_type']?>&chef_dequipe_id=<?=$_GET['chef_dequipe_id']?>&chef_dequipe_matricule=<?= $_GET['chef_dequipe_matricule']?>&date_generation=<?= $_GET['date_generation'] ?>&chantier_id=<?= $_GET['chantier_id']?>&chantier_code=<?= $_GET['chantier_code']?>&reg=true" class="span2 btn btn-info">Regénérer le rapport</a>
                        <?php endif ; ?>
                        <?php if($_GET['validated'] === '1' && $_GET['submitted'] === '1'): ?>
                            <a style="margin-top: 5px ; margin-right: 3px ; margin-left: 3px" href="eRapportShowPrint.php?rapport_id=<?= $_GET['rapport_id']?>&rapport_type=<?=$_GET['rapport_type']?>&chef_dequipe_id=<?=$_GET['chef_dequipe_id']?>&chef_dequipe_matricule=<?= $_GET['chef_dequipe_matricule']?>&date_generation=<?= $_GET['date_generation'] ?>&chantier_id=<?= $_GET['chantier_id']?>&chantier_code=<?= $_GET['chantier_code']?>&validated=<?= $_GET['validated']?>&submitted=<?= $_GET['submitted']?>" class="span2 btn btn-block" >Imprimer</a>
                        <?php else : ?>
                            <a style="margin-top: 5px ; margin-right: 3px ; margin-left: 3px" href="eRapportShowPrint.php?rapport_id=<?= $_GET['rapport_id']?>&rapport_type=<?=$_GET['rapport_type']?>&chef_dequipe_id=<?=$_GET['chef_dequipe_id']?>&chef_dequipe_matricule=<?= $_GET['chef_dequipe_matricule']?>&date_generation=<?= $_GET['date_generation'] ?>&chantier_id=<?= $_GET['chantier_id']?>&chantier_code=<?= $_GET['chantier_code']?>&validated=<?= $_GET['validated']?>&submitted=<?= $_GET['submitted']?>" class="span2 btn btn-block" disabled>Imprimer</a>
                        <?php endif ; ?>
                        <?php if($_SESSION['post_id']=== '1' || $_SESSION['post_id']==='3' || $_SESSION['post_id']==='5'): ?>
                            <a style="margin-top: 5px ; margin-right: 3px ; margin-left: 3px" href="erapport.php?rapport_id=<?= $_GET['rapport_id']?>&rapport_type=<?=$_GET['rapport_type']?>&chef_dequipe_id=<?=$_GET['chef_dequipe_id']?>&chef_dequipe_matricule=<?= $_GET['chef_dequipe_matricule']?>&date_generation=<?= $_GET['date_generation'] ?>&chantier_id=<?= $_GET['chantier_id']?>&chantier_code=<?= $_GET['chantier_code']?>&sup=true" class="span2 btn btn-danger" disabled>Supprimer le rapport</a>
                        <?php else : ?>
                            <a style="margin-top: 5px ;margin-right: 3px ; margin-left: 3px" href="erapport.php?rapport_id=<?= $_GET['rapport_id']?>&rapport_type=<?=$_GET['rapport_type']?>&chef_dequipe_id=<?=$_GET['chef_dequipe_id']?>&chef_dequipe_matricule=<?= $_GET['chef_dequipe_matricule']?>&date_generation=<?= $_GET['date_generation'] ?>&chantier_id=<?= $_GET['chantier_id']?>&chantier_code=<?= $_GET['chantier_code']?>&sup=true" class="span2 btn btn-danger">Supprimer le rapport</a>
                        <?php endif ; ?>
                        <a style="margin-top: 5px ; margin-right: 3px ; margin-left: 3px" href="erapport.php?" class="span2 btn btn-inverse">Retour</a>
                        <div class=" span1 btn-block"></div>
                    </div>
            </div>
        </form>
    </div>
</div>