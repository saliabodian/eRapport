<div id="content">
    <div id="content-header">
        <hr>
        <h1>Les anomalies RH  </h1>
    </div>
    <div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                    <h5>Traitement des anomalies pré-mensuelles</h5>
                </div>
                <div>
                    <div class="widget-content nopadding">
                        <form action="" method="post" class="form-horizontal">
                            <div class="form-actions">
                                <input type="hidden" name="month_anomaly_treatment" value="true">
                                <input type="text" class="btn span3" disabled>
                                <input type="submit" class="btn btn-success span6" value="Traiter les anomlies">
                                <input type="text" class="btn span3" disabled>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <?php include 'alert.php'; ?>
                    <?php if(!empty($hourAnomaly)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Anomalies RH : Différence entre volume horaire badgé et heures prestées</h5>
                            </div>
                            <div class="widget-content">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Nom Complet</th>
                                        <th>Heures badgées</th>
                                        <th>Tot. Rép. Heures</th>
                                        <th>Chantier</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <?php foreach ($hourAnomaly as $anomaly) : ?>
                                        <form method="post" action="rapportDetail.php">
                                            <input type="hidden" name="rapport_detail_id" value="<?= $anomaly['id'] ?>"/>
                                            <input type="hidden" name="rapport_type" value="<?= $anomaly['rapport_type'] ?>"/>
                                            <input type="hidden" name="rapport_id" value="<?= $anomaly['rapport_id']?>"/>
                                            <input type="hidden" name="chef_dequipe_id" value="<?= $anomaly['equipe']?>"/>
                                            <input type="hidden" name="chef_dequipe_matricule" value="<?= $anomaly['chef_dequipe_matricule']?>"/>
                                            <input type="hidden" name="date_generation" value="<?= $anomaly['date']?>"/>
                                            <input type="hidden" name="chantier_id" value="<?= $anomaly['chantier']?>"/>
                                            <input type="hidden" name="chantier_code" value="<?= $anomaly['code']?>"/>
                                            <input type="hidden" name="anomaly" value="true"/>
                                            <input type="hidden" name="selected_matricule[]" value="<?= isset($anomaly['ouvrier_id'])? $anomaly['ouvrier_id'] : (isset($anomaly['interimaire_id'])? $anomaly['interimaire_id'] : '')?>"/>
                                            <tbody>
                                            <tr>
                                                <td><?= isset($anomaly['ouvrier_id'])? $anomaly['ouvrier_id'] : (isset($anomaly['interimaire_id'])? $anomaly['interimaire_id'] : '')?> - <?=$anomaly['fullname']?></td>
                                                <td><?= $anomaly['htot']?></td>
                                                <td><?= $anomaly['ht1']+$anomaly['ht2']+$anomaly['ht3']+$anomaly['ht4']+$anomaly['ht5']+$anomaly['ht6']?></td>
                                                <td><?= $anomaly['code'].' - '.$anomaly['nom'] ?></td>
                                                <td><?= date('d-m-Y',strtotime($anomaly['date']))?></td>
                                                <td><span><input class="btn btn-inverse" type="submit" value="Lire"> <a href="anomalieRh.php?hour_traitement=<?= $anomaly['id'] ?>" class="btn btn-light"><i class="icon-trash"></i> Traiter</a></td>
                                            </tr>
                                            </tbody>
                                        </form>
                                    <?php endforeach ?>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <?php include 'alert.php'; ?>
                    <?php if(!empty($absenceList)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Anomalies RH : Ouvriers ou Intérimaires avec absence</h5>
                            </div>
                            <div class="widget-content">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Nom Complet</th>
                                        <th>Anomalie(s)</th>
                                        <th>Chantier</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <?php foreach ($absenceList as $anomaly) : ?>
                                        <form method="post" action="rapportDetail.php">
                                            <input type="hidden" name="rapport_detail_id" value="<?= $anomaly['id'] ?>"/>
                                            <input type="hidden" name="rapport_type" value="<?= $anomaly['rapport_type'] ?>"/>
                                            <input type="hidden" name="rapport_id" value="<?= $anomaly['rapport_id']?>"/>
                                            <input type="hidden" name="chef_dequipe_id" value="<?= $anomaly['equipe']?>"/>
                                            <input type="hidden" name="chef_dequipe_matricule" value="<?= $anomaly['chef_dequipe_matricule']?>"/>
                                            <input type="hidden" name="date_generation" value="<?= $anomaly['date']?>"/>
                                            <input type="hidden" name="chantier_id" value="<?= $anomaly['chantier']?>"/>
                                            <input type="hidden" name="chantier_code" value="<?= $anomaly['code']?>"/>
                                            <input type="hidden" name="anomaly" value="true"/>
                                            <input type="hidden" name="selected_matricule[]" value="<?= isset($anomaly['ouvrier_id'])? $anomaly['ouvrier_id'] : (isset($anomaly['interimaire_id'])? $anomaly['interimaire_id'] : '')?>"/>
                                            <tbody>
                                            <tr>
                                                <td><?= isset($anomaly['ouvrier_id'])? $anomaly['ouvrier_id'] : (isset($anomaly['interimaire_id'])? $anomaly['interimaire_id'] : '')?> - <?=$anomaly['fullname']?></td>
                                                <td><?= $anomaly['abs'].' - '.$anomaly['habs'].'H' ?></td>
                                                <td><?= $anomaly['code'].' - '.$anomaly['nom']?></td>
                                                <td><?= date('d-m-Y',strtotime($anomaly['date'])) ?></td>
                                                <td><input class="btn btn-inverse " type="submit" value="Lire"> <a href="anomalieRh.php?absence_traitement=<?= $anomaly['id'] ?>" class="btn btn-light"><i class="icon-trash"></i> Traiter</a></td>
                                            </tr>
                                            </tbody>
                                        </form>
                                    <?php endforeach ?>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>