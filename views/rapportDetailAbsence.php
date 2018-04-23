<div id="content">
    <div id="content-header">
        <h1>Mise à jour des tâches</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Formulaire de mise à jour</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="widget-content nopadding">
                            <?php include 'alert.php' ; ?>
                            <form method="post" class="form-horizontal">
                                <input type="hidden" name="rapport_id" value="<?= $_POST['rapport_id']?>">
                                <input type="hidden" name="rapport_type" value="<?= $_POST['rapport_type']?>">
                                <input type="hidden" name="chef_dequipe_id" value="<?= $_POST['chef_dequipe_id']?>">
                                <input type="hidden" name="chef_dequipe_matricule" value="<?= $_POST['chef_dequipe_matricule']?>">
                                <input type="hidden" name="date_generation" value="<?= $_POST['date_generation']?>">
                                <input type="hidden" name="chantier_code" value="<?= $_POST['chantier_code']?>">
                                <input type="hidden" name="chantier_id" value="<?= $_POST['chantier_id']?>">
                                <input type="hidden" value="true" name="majForm"/>
                                <input type="hidden" name="anomaly" value="<?= $_POST['anomaly']?>"/>
                                <?php if(sizeof($workerToUpdate) === 1) : ?>
                                    <?php foreach ($workerToUpdate as $worker) : ?>
                                        <input type="hidden" value="<?= $worker["chef_dequipe_updated"] ?>" name="chef_dequipe_updated"/>
                                    <?php endforeach ; ?>
                                <?php endif ; ?>
                                <?php foreach($workerToUpdate as $worker) : ?>
                                    <input type="hidden" name="matriculeList[]" class="span4" value="<?= isset($worker['ouvrier_id'])? $worker['ouvrier_id'] : (isset($worker['interimaire_id'])? $worker['interimaire_id'] : '')?>" />
                                <?php endforeach; ?>
                                <?php foreach($workerToUpdate as $worker) : ?>
                                    <input type="hidden" name="rapport_detail_id[]" class="span4" value="<?= $worker['rapport_detail_id'] ?>" />
                                <?php endforeach; ?>
                                <div class="control-group">
                                    <label class="control-label">Matricule(s) :</label>
                                    <div class="controls">
                                        <?php foreach($workerToUpdate as $worker) : ?>
                                            <input type="text" class="span4" value="<?= isset($worker['ouvrier_id'])? $worker['ouvrier_id'] : (isset($worker['interimaire_id'])? $worker['interimaire_id'] : '')?> - <?=$worker['fullname']?>" disabled/>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Heures totales :</label>
                                    <div class="controls">
                                        <?php if(in_array('Ouvrier', $workerType) && in_array('Interimaire',$workerType ) && sizeof($workerToUpdate) > 1): ?>
                                            <?php foreach($workerToUpdate as $worker) : ?>
                                                <input type="hidden" class="span2" name="htot" value="" />
                                            <?php endforeach ; ?>
                                            <input type="number" class="span2" name="" value="" disabled/>
                                        <?php endif; ?>
                                        <?php if(!(in_array('Ouvrier', $workerType)) && in_array('Interimaire',$workerType ) && sizeof($workerToUpdate) > 1 ):?>
                                            <?php foreach($workerToUpdate as $worker) : ?>
                                                <input type="hidden" class="span2" name="htot" value="<?= ($worker['htot'] != 0 )? $worker['htot']: 8 ?>"/>
                                            <?php endforeach ; ?>
                                            <input type="number" class="span2" name="htot" value="<?= ($worker['htot'] != 0 )? $worker['htot']: 8 ?>"/>
                                        <?php endif; ?>
                                        <?php if(!(in_array('Ouvrier', $workerType)) && in_array('Interimaire',$workerType ) && sizeof($workerToUpdate) === 1 ):?>
                                            <?php foreach($workerToUpdate as $worker) : ?>
                                                <input type="number" class="span2" name="htot" value="<?= ($worker['htot'] != 0 )? $worker['htot']: 8 ?>"/>
                                            <?php endforeach ; ?>
                                        <?php endif; ?>
                                        <?php if((in_array('Ouvrier', $workerType)) && !(in_array('Interimaire',$workerType )) && sizeof($workerToUpdate) === 1 ):?>
                                            <?php foreach($workerToUpdate as $worker) : ?>
                                                <input type="hidden" class="span2" name="htot" value="<?= $worker['htot']  ?>"/>
                                                <input type="number" class="span2" name="htot" value="<?= $worker['htot'] ?>" disabled/>
                                            <?php endforeach ; ?>
                                        <?php endif; ?>
                                        <?php if((in_array('Ouvrier', $workerType)) && !(in_array('Interimaire',$workerType )) && sizeof($workerToUpdate) > 1 ):?>
                                            <?php foreach($workerToUpdate as $worker) : ?>
                                                <input type="hidden" class="span2" name="htot" value="<?= $worker['htot']  ?>"/>
                                            <?php endforeach ; ?>
                                            <input type="number" class="span2" name="" value="" disabled/>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Absence :</label>
                                    <div class="controls">
                                        <?php if(sizeof($workerToUpdate) === 1) : ?>
                                            <?php foreach ($workerToUpdate as $worker) : ?>
                                                <select class="select2-container span4" name="abs">
                                                    <option value="<?= $worker['abs'] ?>" <?php if(($worker['abs'] === 'Maladie (M)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Accident (A)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Congé (C)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Absence  Excusée (EX)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Formation (FOR)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Intempéries (INT)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Congé Extraordinaire (CE)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Absence non Excusée (ABS)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Congé Syndical (CS)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Visite Médicale STI (STI)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Travaux Autre Chantier (TAC)')) : ?>
                                                        selected = "selected" <?php endif; ?> ><?= $worker['abs'] ?></option>
                                                        <option></option>
                                                        <option value="Maladie (M)">Maladie (M)</option>
                                                        <option value="Accident (A)">Accident (A)</option>
                                                        <option value="Congé (C)">Congé (C)</option>
                                                        <option value="Absence Excusée (EX)">Absence Excusée (EX)</option>
                                                        <option value="Formation (FOR)">Formation (FOR)</option>
                                                        <option value="Intempéries (INT)">Intempéries (INT)</option>
                                                        <option value="Congé Extraordinaire (CE)">Congé Extraordinaire (CE)</option>
                                                        <option value="Absence non Excusée (ABS)">Absence non Excusée (ABS)</option>
                                                        <option value="Congé Syndical (CS)">Congé Syndical (CS)</option>
                                                        <option value="Visite Médicale STI (STI)">Visite Médicale STI (STI)</option>
                                                        <option value="Travaux Autre Chantier (TAC)">Travaux Autre Chantier (TAC)</option>
                                                    </select>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <select class="select2-container" name="abs">
                                                <option></option>
                                                <option value="Maladie (M)">Maladie (M)</option>
                                                <option value="Accident (A)">Accident (A)</option>
                                                <option value="Congé (C)">Congé (C)</option>
                                                <option value="Absence Excusée (EX)">Absence Excusée (EX)</option>
                                                <option value="Formation (FOR)">Formation (FOR)</option>
                                                <option value="Intempéries (INT)">Intempéries (INT)</option>
                                                <option value="Congé Extraordinaire (CE)">Congé Extraordinaire (CE)</option>
                                                <option value="Absence non Excusée (ABS)">Absence non Excusée (ABS)</option>
                                                <option value="Congé Syndical (CS)">Congé Syndical (CS)</option>
                                                <option value="Visite Médicale STI (STI)">Visite Médicale STI (STI)</option>
                                                <option value="Travaux Autre Chantier (TAC)">Travaux Autre Chantier (TAC)</option>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Heures absence :</label>
                                    <div class="controls">
                                        <?php if(sizeof($workerToUpdate) === 1) : ?>
                                            <?php foreach ($workerToUpdate as $worker) : ?>
                                                <input type="text" class="span2" name="habs" value="<?= $worker['habs'] ?>"/>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <input type="text" class="span2" name="habs" value=""/>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <!-- Ajout des tâches de manières dynamiques avec jQuery-->
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>