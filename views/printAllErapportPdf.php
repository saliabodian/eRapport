<div>
    <div>
        <hr>
        <h2>
            <img src="img/logo.png" alt="Logo"  height="42" width="80"> &nbsp;&nbsp; Rapport journalier du ... Au ...
        </h2>
    </div>
<?php foreach ($listPrintableRapport as $printableRapport): ?>
        <div>
            <hr>
            <div>
                <div>
                    <div>
                        <?php if(!empty($rapportNoyau)){ ?>
                            <div>
                                <div>
                                    <h3>Rapport journalier du noyau <?= '('.date('d-m-Y',strtotime($rapportJournalierDate)).' / '. $_GET["chantier_code"].')'?> </h3>
                                </div>
                                <div>
                                    <form method="post" action="rapportDetail.php">
                                        <table style="page-break-inside: avoid; border: 1px; border-collapse: collapse;">
                                            <thead>
                                            <tr style="background-color: #68ff72;" >
                                                <th style="text-align: left;  border:solid 1px #000000;">&nbsp;Nom Complet&nbsp;</th>
                                                <th style="text-align: center;  border:solid 1px #000000;">&nbsp;Heures&nbsp;</th>
                                                <?php if(!empty($noyauHeader)) :?>
                                                    <?php foreach($noyauHeader as $noyauHeaderdetail) : ?>
                                                        <th style="text-align: center;  border:solid 1px #000000;">&nbsp;<?= $noyauHeaderdetail['code']?>&nbsp;</th>
                                                    <?php endforeach ; ?>
                                                <?php endif; ?>
                                                <th style="text-align: center;  border:solid 1px #000000;">&nbsp;Abs&nbsp;</th>
                                                <th style="text-align: center;  border:solid 1px #000000;">&nbsp;T. Pen.&nbsp;</th>
                                                <th style="text-align: center;  border:solid 1px #000000;">&nbsp;T. (Km)&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($rapportNoyau as $rapport ) : ?>
                                                <tr>
                                                    <td style="text-align: left;  border:solid 1px #000000;">&nbsp;
                                                        <?php if ($rapport['htot'] != ($rapport['ht1'] + $rapport['ht2'] +$rapport['ht3'] +$rapport['ht4'] +$rapport['ht5'] + $rapport['ht6'])) : ?>
                                                            <img src="img/warning-yellow-black.png" alt="erreur volume horaire">
                                                        <?php endif ?>
                                                        <?php if (!empty($rapport['habs']) || !empty($rapport['abs'])) : ?>
                                                            <img src="img/dialog-stop-2.png" alt="absence saisie">
                                                        <?php endif ?>
                                                        <?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?> - <?=$rapport['fullname']?><?= ($rapport['dpl_pers']=== '1')? ' (T)' : '' ?>&nbsp;&nbsp;&nbsp;</td>
                                                    <td style="text-align: center;  border:solid 1px #000000;"><?= $rapport['htot'] ?></td>
                                                    <?php if(!empty($noyauHeader)) :?>
                                                        <?php foreach($noyauHeader as $noyauHeaderdetail) : ?>
                                                            <?php if($rapport['task_id_1'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_1']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_2'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_2']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_3'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_3']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_4'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_4']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_5'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_5']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_6'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($noyauWorkerTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_6']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php else : ?>
                                                                <td style="text-align: center;  border:solid 1px #000000;"></td>
                                                            <?php endif ; ?>
                                                        <?php endforeach ; ?>
                                                    <?php endif ; ?>
                                                    <td style="text-align: center;  border:solid 1px #000000;" ><?= $rapport['habs'] ?></td>
                                                    <td style="text-align: center;  border:solid 1px #000000;" ><?= $rapport['hins'] ?></td>
                                                    <td style="text-align: center;  border:solid 1px #000000;" ><?= $rapport['km'] ?></td>
                                                </tr>
                                            <?php  endforeach;  ?>
                                            <tr>
                                                <td style="text-align: left;  border:solid 1px #000000; color: red; "><b>&nbsp;Totaux</b></td>
                                                <td style="text-align: center;  border:solid 1px #000000; color: red;"><b><?= $noyauHourGlobal; ?></b></td>
                                                <?php if(!empty($noyauHeader)) :?>
                                                    <?php foreach($noyauHeader as $noyauHeaderdetail) : ?>
                                                        <td style="text-align: center;  border:solid 1px #000000; color: red;"><b><?= $noyauHeaderdetail['vht'] ?></b></td>
                                                    <?php endforeach ; ?>
                                                <?php endif ; ?>
                                                <td style="text-align: center;  border:solid 1px #000000; color: red;"><b><?= $noyauHourAbsencesGlobal; ?></b></td>
                                                <td style="text-align: center;  border:solid 1px #000000; color: red;"><b><?= $noyauHourPenibleGlobal; ?></b></td>
                                                <td style="text-align: center;  border:solid 1px #000000; color: red;"><b><?= $noyauKmGlobal; ?></b></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div>
                                            <?php if(!empty($noyauHeader)) : ?>
                                                <?php foreach($noyauHeader as $noyauHeaderdetail) : ?>
                                                    <input type="text" value="<?= $noyauHeaderdetail['code'].': '.$noyauHeaderdetail['nom']?>" style="width: 200px;" disabled/>
                                                <?php endforeach; ?>
                                            <?php endif ; ?>
                                        </div>
                                        <?php if(!empty($noyauHeader)) : ?>
                                            <hr>
                                        <?php endif ; ?>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <div>
                        <?php if(!empty($rapportHorsNoyau)){ ?>
                            <div>
                                <div>
                                    <h3 style="page-break-before: always;">Rapport journalier des hors noyau <?= '('.date('d-m-Y',strtotime($rapportJournalierDate)).' / '. $_GET["chantier_code"].')'?></h3>
                                </div>
                                <div>
                                    <form method="post" action="rapportDetail.php">
                                        <table style="page-break-inside: avoid; border: 1px; border-collapse: collapse;">
                                            <thead>
                                            <tr style="background-color: #68ff72;">
                                                <th style="text-align: left;  border:solid 1px #000000;">Nom Complet</th>
                                                <th style="text-align: center;  border:solid 1px #000000;">&nbsp;Heures&nbsp;</th>
                                                <?php if(!empty($horsNoyauHeader)) :?>
                                                    <?php foreach($horsNoyauHeader as $noyauHeaderdetail) : ?>
                                                        <th style="text-align: center;  border:solid 1px #000000;">&nbsp;<?= $noyauHeaderdetail['code']?>&nbsp;</th>
                                                    <?php endforeach ; ?>
                                                <?php endif; ?>
                                                <th style="text-align: center;  border:solid 1px #000000;">&nbsp;Abs&nbsp;</th>
                                                <th style="text-align: center;  border:solid 1px #000000;">&nbsp;T. Pen&nbsp;</th>
                                                <th style="text-align: center;  border:solid 1px #000000;">&nbsp;T. (Km)&nbsp;</th>
                                                <th style="text-align: center;  border:solid 1px #000000;">&nbsp;MAJ. Par&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($rapportHorsNoyau as $rapport ) : ?>
                                                <tr>
                                                    <td style="text-align: left;  border:solid 1px #000000;">&nbsp;
                                                        <?php if ($rapport['htot'] != ($rapport['ht1'] + $rapport['ht2'] +$rapport['ht3'] +$rapport['ht4'] +$rapport['ht5'] + $rapport['ht6'])) : ?>
                                                            <img src="img/warning-yellow-black.png" alt="erreur volume horaire">
                                                        <?php endif ?>
                                                        <?php if (!empty($rapport['habs']) || !empty($rapport['abs'])) : ?>
                                                            <img src="img/dialog-stop-2.png" alt="absence saisie">
                                                        <?php endif ?>
                                                        <?= isset($rapport['ouvrier_id'])? $rapport['ouvrier_id'] : (isset($rapport['interimaire_id'])? $rapport['interimaire_id'] : '')?> - <?=$rapport['fullname']?><?= ($rapport['dpl_pers']=== '1')? ' (T)' : '' ?>&nbsp;&nbsp;&nbsp;</td>
                                                    <td style="text-align: center;  border:solid 1px #000000;" ><?= $rapport['htot'] ?></td>
                                                    <?php if (!empty($horsNoyauHeader)) : ?>
                                                        <?php foreach($horsNoyauHeader as $noyauHeaderdetail) : ?>
                                                            <?php if($rapport['task_id_1'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_1']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_2'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_2']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_3'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_3']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_4'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_4']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_5'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_5']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php elseif ($rapport['task_id_6'] === $noyauHeaderdetail['tache_id']) : ?>
                                                                <?php foreach($horsNoyauTask[$rapport['id']] as $task) : ?>
                                                                    <?php if($task['tache_id']=== $rapport['task_id_6']) : ?>
                                                                        <td style="text-align: center;  border:solid 1px #000000;"><?= $task['vhr'] ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ; ?>
                                                            <?php else : ?>
                                                                <td></td>
                                                            <?php endif ; ?>
                                                        <?php endforeach ; ?>
                                                    <?php endif ;?>
                                                    <td style="text-align: center;  border:solid 1px #000000;" ><?= $rapport['habs'] ?></td>
                                                    <td style="text-align: center;  border:solid 1px #000000;" ><?= $rapport['hins'] ?></td>
                                                    <td style="text-align: center;  border:solid 1px #000000;" ><?= $rapport['km'] ?></td>
                                                    <td style="text-align: center;  border:solid 1px #000000;" ><?= isset($rapport['chef_dequipe_updated']) ? $rapport['chef_dequipe_updated'] : '' ?></td>
                                                </tr>
                                            <?php  endforeach;  ?>
                                            <tr>
                                                <td style="text-align: left;  border:solid 1px #000000; color: red; "><b>&nbsp;Totaux</b></td>
                                                <td style="text-align: center;  border:solid 1px #000000; color: red; "><b><?= $horsNoyauHourGlobal; ?></b></td>
                                                <?php if(!empty($horsNoyauHeader)) :?>
                                                    <?php foreach($horsNoyauHeader as $noyauHeaderdetail) : ?>
                                                        <td style="text-align: center;  border:solid 1px #000000; color: red; "><b><?= $noyauHeaderdetail['vht'] ?></b></td>
                                                    <?php endforeach ; ?>
                                                <?php endif ; ?>
                                                <td style="text-align: center;  border:solid 1px #000000; color: red; "><b><?= $horsNoyauHourAbsencesGlobal; ?></b></td>
                                                <td style="text-align: center;  border:solid 1px #000000; color: red; "><b><?= $horsNoyauHourPenibleGlobal; ?></b></td>
                                                <td style="text-align: center;  border:solid 1px #000000; color: red; "><b><?= $horsNoyauKmGlobal; ?></b></td>
                                                <td style="text-align: center;  border:solid 1px #000000; color: #ff0000; "></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div>
                                            <?php if(!empty($horsNoyauHeader)) : ?>
                                                <?php foreach($horsNoyauHeader as $noyauHeaderdetail) : ?>
                                                    <input type="text" class="span4" value="<?= $noyauHeaderdetail['code'].': '.$noyauHeaderdetail['nom']?>" style="width: 200px;" disabled/>
                                                <?php endforeach; ?>
                                            <?php endif ; ?>
                                            <?php if(!empty($horsNoyauHeader)) : ?>
                                                <hr>
                                            <?php endif ; ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ; ?>