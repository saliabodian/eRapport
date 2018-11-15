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
                                <input type="hidden" name="anomaly" value="<?= isset($_POST['anomaly'])?$_POST['anomaly'] : '' ?>"/>
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
                                    <label class="control-label" style="font-size: medium; font-weight: bold">Matricule(s) :</label>
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
                                                        <?php elseif  (($worker['abs'] === 'Fin de mission (FM)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Transfert vers autre chantier (TVC)')) : ?>
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
                                                        <option value="Fin de mission (FM)">Fin de mission (FM)</option>
                                                        <option value="Transfert vers autre chantier (TVC)">Transfert vers autre chantier (TVC)</option>
                                                    </select>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <select class="select2-container span4" name="abs">
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
                                                <option value="Transfert vers autre chantier (TVC)">Transfert vers autre chantier (TVC)</option>
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
                                <div class="control-group">
                                    <label class="control-label" style="font-size: medium; font-weight: bold">Catégorie de tâche :</label>
                                    <div class="controls tasks">
                                        <?php if(sizeof($workerToUpdate)=== 1) : ?>
                                            <select class="span4 typeTask mySelect select2-container" name="type_task" onchange="getId(this.value)">
                                                <option>Catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <?php foreach($workerToUpdate as $worker) :?>
                                                        <option value="<?= $typeTache['id']?>" <?php if($worker['type_task_id_1']=== $typeTache['id']) : ?> selected="selected" <?php endif; ?>><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                <?php endforeach;?>
                                            </select>
                                        <?php else : ?>
                                            <select class="span4 typeTask mySelect select2-container" name="type_task" onchange="getId(this.value)">
                                                <option>Catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <option value="<?= $typeTache['id']?>"><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                <?php endforeach;?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Tâche :</label>
                                    <div class="controls" >
                                        <?php if(sizeof($workerToUpdate)=== 1) : ?>
                                            <select class="span4 mySelect task select2-container" name="tasks">
                                                <option>Tâche</option>
                                                <?php foreach($listTache as $tache) : ?>
                                                    <?php foreach($workerToUpdate as $worker) : ?>
                                                        <option value="<?= $tache['id']?>" <?php if($worker['task_id_1']=== $tache['id']) : ?> selected="selected" <?php endif; ?>><?= $tache['code'].' '.$tache['nom']?></option>
                                                    <?php endforeach ;?>
                                                <?php endforeach ;?>
                                            </select>
                                        <?php else : ?>
                                            <select class="span4 mySelect task select2-container" name="tasks">
                                                <option>Tâche</option>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if(sizeof($workerToUpdate)=== 1) : ?>
                                    <?php foreach($workerToUpdate as $worker): ?>
                                        <?php if(!empty($batimentList)) : ?>
                                            <div class="control-group">
                                            <label class="control-label">Bâtiment :</label>
                                            <div class="controls">
                                                <select class="span4 mySelect select2-container" id="bat" name="bat">
                                                    <option>Bâtiment</option>
                                                    <?php foreach($batimentList as $batiment) : ?>
                                                        <?php foreach($workerToUpdate as $worker) : ?>
                                                            <option value="<?= $batiment['id']?>" <?php if($worker['bat_1']=== $batiment['id']) : ?> selected="selected" <?php endif; ?>><?= $batiment['nom']?></option>
                                                        <?php endforeach ;?>
                                                    <?php endforeach ;?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php else : ?>
                                        <div class="control-group">
                                            <label class="control-label">Batiment :</label>
                                            <div class="controls">
                                                <input type="text" class="span4" id="bat" name="bat" <?php if(!empty($worker['bat_1'])) : ?> value="<?= $worker['bat_1'] ?>" <?php else :?> placeholder="Batiment" <?php endif ; ?> >
                                            </div>
                                        </div>
                                        <?php endif ; ?>
                                        <div class="control-group">
                                            <label class="control-label">Axe :</label>
                                            <div class="controls">
                                                <input type="text" class="span4" id="axe" name="axe"  <?php if(!empty($worker['axe_1'])) :?> value="<?= $worker['axe_1'] ?>" <?php else :?> placeholder="Axe" <?php endif ; ?>>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Etage :</label>
                                            <div class="controls">
                                                <select class="select2-container span2" name="et">
                                                    <option value="<?= $worker['et_1'] ?>" <?php if(($worker['et_1'] === 'Niveau 10')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau 9')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau 8')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau 7')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau 6')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau 5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau 4')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau 3')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau 2')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau 1')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'RDC')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -0.5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -1')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -1.5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -2')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -2.5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -3')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -3.5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -4')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -4.5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -5.5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -6')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -6.5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -7')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -7.5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -8')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -8.5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -9')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -9.5')) : ?>
                                                    <?php elseif  (($worker['et_1'] === 'Niveau -10')) : ?>
                                                        selected = "selected" <?php endif; ?> ><?= $worker['et_1'] ?></option>
                                                    <option></option>
                                                    <option value="Niveau 10">Niveau 10</option>
                                                    <option value="Niveau 9">Niveau 9</option>
                                                    <option value="Niveau 8">Niveau 8</option>
                                                    <option value="Niveau 7">Niveau 7</option>
                                                    <option value="Niveau 6">Niveau 6</option>
                                                    <option value="Niveau 5">Niveau 5</option>
                                                    <option value="Niveau 4">Niveau 4</option>
                                                    <option value="Niveau 3">Niveau 3</option>
                                                    <option value="Niveau 2">Niveau 2</option>
                                                    <option value="Niveau 1">Niveau 1</option>
                                                    <option value="Niveau RDC">Niveau RDC</option>
                                                    <option value="Niveau -0.5">Niveau -0.5</option>
                                                    <option value="Niveau -1">Niveau -1</option>
                                                    <option value="Niveau -1.5">Niveau -1.5</option>
                                                    <option value="Niveau -2">Niveau -2</option>
                                                    <option value="Niveau -2.5">Niveau -2.5</option>
                                                    <option value="Niveau -3">Niveau -3</option>
                                                    <option value="Niveau -3.5">Niveau -3.5</option>
                                                    <option value="Niveau -4">Niveau -4</option>
                                                    <option value="Niveau -4.5">Niveau -4.5</option>
                                                    <option value="Niveau -5">Niveau -5</option>
                                                    <option value="Niveau -5.5">Niveau -5.5</option>
                                                    <option value="Niveau -6">Niveau -6</option>
                                                    <option value="Niveau -6.5">Niveau -6.5</option>
                                                    <option value="Niveau -7">Niveau -7</option>
                                                    <option value="Niveau -7.5">Niveau -7.5</option>
                                                    <option value="Niveau -8">Niveau -8</option>
                                                    <option value="Niveau -8.5">Niveau -8.5</option>
                                                    <option value="Niveau -9">Niveau -9</option>
                                                    <option value="Niveau -9.5">Niveau -9.5</option>
                                                    <option value="Niveau -10">Niveau -10</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Heure(s) :</label>
                                            <div class="controls">
                                                <input type="text" class="span2" id="ht" name="ht" value="<?=$worker['ht1']?>" placeholder="">
                                            </div>
                                        </div>
                                    <?php endforeach ; ?>
                                <?php else : ?>
                                    <?php if(!empty($batimentList)) :?>
                                        <div class="control-group">
                                            <label class="control-label">Bâtiment :</label>
                                            <div class="controls">
                                                <select class="span4 mySelect select2-container" id="bat" name="bat">
                                                    <option>Bâtiment</option>
                                                    <?php foreach($batimentList as $batiment) : ?>
                                                            <option value="<?= $batiment['id']?>" ><?= $batiment['nom']?></option>
                                                    <?php endforeach ;?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                    <div class="control-group">
                                        <label class="control-label">Batiment :</label>
                                        <div class="controls">
                                            <input type="text" class="span4" id="bat" name="bat"  placeholder="Batiment" >
                                        </div>
                                    </div>
                                    <?php endif ; ?>
                                    <div class="control-group">
                                        <label class="control-label">Axe :</label>
                                        <div class="controls">
                                            <input type="text" class="span4" id="axe" name="axe" placeholder="Axe" >
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Etage :</label>
                                        <div class="controls">
                                            <select class="select2-container span2" name="et">
                                                <option></option>
                                                <option value="Niveau 10">Niveau 10</option>
                                                <option value="Niveau 9">Niveau 9</option>
                                                <option value="Niveau 8">Niveau 8</option>
                                                <option value="Niveau 7">Niveau 7</option>
                                                <option value="Niveau 6">Niveau 6</option>
                                                <option value="Niveau 5">Niveau 5</option>
                                                <option value="Niveau 4">Niveau 4</option>
                                                <option value="Niveau 3">Niveau 3</option>
                                                <option value="Niveau 2">Niveau 2</option>
                                                <option value="Niveau 1">Niveau 1</option>
                                                <option value="Niveau RDC">Niveau RDC</option>
                                                <option value="Niveau -0.5">Niveau -0.5</option>
                                                <option value="Niveau -1">Niveau -1</option>
                                                <option value="Niveau -1.5">Niveau -1.5</option>
                                                <option value="Niveau -2">Niveau -2</option>
                                                <option value="Niveau -2.5">Niveau -2.5</option>
                                                <option value="Niveau -3">Niveau -3</option>
                                                <option value="Niveau -3.5">Niveau -3.5</option>
                                                <option value="Niveau -4">Niveau -4</option>
                                                <option value="Niveau -4.5">Niveau -4.5</option>
                                                <option value="Niveau -5">Niveau -5</option>
                                                <option value="Niveau -5.5">Niveau -5.5</option>
                                                <option value="Niveau -6">Niveau -6</option>
                                                <option value="Niveau -6.5">Niveau -6.5</option>
                                                <option value="Niveau -7">Niveau -7</option>
                                                <option value="Niveau -7.5">Niveau -7.5</option>
                                                <option value="Niveau -8">Niveau -8</option>
                                                <option value="Niveau -8.5">Niveau -8.5</option>
                                                <option value="Niveau -9">Niveau -9</option>
                                                <option value="Niveau -9.5">Niveau -9.5</option>
                                                <option value="Niveau -10">Niveau -10</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Heure(s) :</label>
                                        <div class="controls">
                                            <input type="text" class="span2" id="ht" name="ht" value="" placeholder="">
                                        </div>
                                    </div>
                                <?php endif ; ?>
                                                <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                <div class="control-group">
                                    <label class="control-label" style="font-size: medium; font-weight: bold">Catégorie de tâche :</label>
                                    <div class="controls tasks">
                                        <?php if(sizeof($workerToUpdate)=== 1) : ?>
                                            <select class="span4 typeTask2 mySelect select2-container" name="type_task2" onchange="getId2(this.value)">
                                                <option>Catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <?php foreach($workerToUpdate as $worker) :?>
                                                        <option value="<?= $typeTache['id']?>" <?php if($worker['type_task_id_2']=== $typeTache['id']) : ?> selected="selected" <?php endif; ?>><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                <?php endforeach;?>
                                            </select>
                                        <?php else : ?>
                                            <select class="span4 typeTask2 mySelect select2-container" name="type_task2" onchange="getId2(this.value)">
                                                <option>Catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <option value="<?= $typeTache['id']?>"><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                <?php endforeach;?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Tâche :</label>
                                    <div class="controls">
                                        <?php if(sizeof($workerToUpdate)=== 1 ) : ?>
                                            <select class=" span4 mySelect task2 select2-container" name="tasks2">
                                                <option>Tâche</option>
                                                <?php foreach($listTache as $tache) : ?>
                                                    <?php foreach($workerToUpdate as $worker) : ?>
                                                        <option value="<?= $worker['task_id_2'] ?>" <?php  if($worker['task_id_2'] === $tache['id']) : ?> selected="selected" <?php endif ; ?>><?= $tache['code'].' '.$tache['nom'] ?></option>
                                                    <?php endforeach ; ?>
                                                <?php endforeach ; ?>
                                            </select>
                                        <?php else : ?>
                                            <select class="span4 mySelect task2 select2-container" name="tasks2">
                                                <option>Tâche</option>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <?php if(sizeof($workerToUpdate)===1) :?>
                                            <?php foreach($workerToUpdate as $worker) : ?>
                                                <?php if(!empty($batimentList)) : ?>
                                                    <div class="control-group">
                                                        <label class="control-label">Bâtiment :</label>
                                                        <div class="controls">
                                                            <select class="span4 mySelect select2-container" id="bat2" name="bat2">
                                                                <option>Bâtiment</option>
                                                                <?php foreach($batimentList as $batiment) : ?>
                                                                    <?php foreach($workerToUpdate as $worker) : ?>
                                                                        <option value="<?= $batiment['id']?>" <?php if($worker['bat_2']=== $batiment['id']) : ?> selected="selected" <?php endif; ?>><?= $batiment['nom']?></option>
                                                                    <?php endforeach ;?>
                                                                <?php endforeach ;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="control-group">
                                                        <label class="control-label">Batiment :</label>
                                                        <div class="controls">
                                                            <input type="text" class="span4" id="bat2" name="bat2" <?php if(!empty($worker['bat_2'])) : ?> value="<?= $worker['bat_2'] ?>" <?php else :?> placeholder="Batiment" <?php endif ; ?>>
                                                        </div>
                                                    </div>
                                                <?php endif ; ?>
                                                <div class="control-group">
                                                    <label class="control-label">Axe :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" id="axe2" name="axe2" <?php if(!empty($worker['axe_2'])) : ?> value="<?= $worker['axe_2'] ?>" <?php else :?> placeholder="Axe" <?php endif ; ?>>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Etage :</label>
                                                    <div class="controls">
                                                        <select class="select2-container span2" name="et2">
                                                            <option value="<?= $worker['et_2'] ?>" <?php if(($worker['et_2'] === 'Niveau 10')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau 9')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau 8')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau 7')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau 6')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau 5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau 4')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau 3')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau 2')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau 1')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'RDC')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -0.5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -1')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -1.5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -2')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -2.5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -3')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -3.5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -4')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -4.5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -5.5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -6')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -6.5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -7')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -7.5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -8')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -8.5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -9')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -9.5')) : ?>
                                                            <?php elseif  (($worker['et_2'] === 'Niveau -10')) : ?>
                                                                selected = "selected" <?php endif; ?> ><?= $worker['et_2'] ?></option>
                                                            <option></option>
                                                            <option value="Niveau 10">Niveau 10</option>
                                                            <option value="Niveau 9">Niveau 9</option>
                                                            <option value="Niveau 8">Niveau 8</option>
                                                            <option value="Niveau 7">Niveau 7</option>
                                                            <option value="Niveau 6">Niveau 6</option>
                                                            <option value="Niveau 5">Niveau 5</option>
                                                            <option value="Niveau 4">Niveau 4</option>
                                                            <option value="Niveau 3">Niveau 3</option>
                                                            <option value="Niveau 2">Niveau 2</option>
                                                            <option value="Niveau 1">Niveau 1</option>
                                                            <option value="Niveau RDC">Niveau RDC</option>
                                                            <option value="Niveau -0.5">Niveau -0.5</option>
                                                            <option value="Niveau -1">Niveau -1</option>
                                                            <option value="Niveau -1.5">Niveau -1.5</option>
                                                            <option value="Niveau -2">Niveau -2</option>
                                                            <option value="Niveau -2.5">Niveau -2.5</option>
                                                            <option value="Niveau -3">Niveau -3</option>
                                                            <option value="Niveau -3.5">Niveau -3.5</option>
                                                            <option value="Niveau -4">Niveau -4</option>
                                                            <option value="Niveau -4.5">Niveau -4.5</option>
                                                            <option value="Niveau -5">Niveau -5</option>
                                                            <option value="Niveau -5.5">Niveau -5.5</option>
                                                            <option value="Niveau -6">Niveau -6</option>
                                                            <option value="Niveau -6.5">Niveau -6.5</option>
                                                            <option value="Niveau -7">Niveau -7</option>
                                                            <option value="Niveau -7.5">Niveau -7.5</option>
                                                            <option value="Niveau -8">Niveau -8</option>
                                                            <option value="Niveau -8.5">Niveau -8.5</option>
                                                            <option value="Niveau -9">Niveau -9</option>
                                                            <option value="Niveau -9.5">Niveau -9.5</option>
                                                            <option value="Niveau -10">Niveau -10</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Heure(s) :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span2" id="ht2" name="ht2" value="<?= $worker['ht2'] ?>" placeholder="">
                                                    </div>
                                                </div>
                                            <?php endforeach ; ?>
                                        <?php else : ?>
                                            <?php if(!empty($batimentList)) : ?>
                                                <div class="control-group">
                                                    <label class="control-label">Bâtiment :</label>
                                                    <div class="controls">
                                                        <select class="span4 mySelect select2-container" id="bat2" name="bat2">
                                                            <option>Bâtiment</option>
                                                            <?php foreach($batimentList as $batiment) : ?>
                                                                <option value="<?= $batiment['id']?>" ><?= $batiment['nom']?></option>
                                                            <?php endforeach ;?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="control-group">
                                                    <label class="control-label">Batiment :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" id="bat2" name="bat2" placeholder="Batiment" >
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="control-group">
                                                <label class="control-label">Axe :</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" id="axe2" name="axe2" placeholder="Axe" >
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Etage :</label>
                                                <div class="controls">
                                                    <select class="select2-container span2" name="et2">
                                                        <option></option>
                                                        <option value="Niveau 10">Niveau 10</option>
                                                        <option value="Niveau 9">Niveau 9</option>
                                                        <option value="Niveau 8">Niveau 8</option>
                                                        <option value="Niveau 7">Niveau 7</option>
                                                        <option value="Niveau 6">Niveau 6</option>
                                                        <option value="Niveau 5">Niveau 5</option>
                                                        <option value="Niveau 4">Niveau 4</option>
                                                        <option value="Niveau 3">Niveau 3</option>
                                                        <option value="Niveau 2">Niveau 2</option>
                                                        <option value="Niveau 1">Niveau 1</option>
                                                        <option value="Niveau RDC">Niveau RDC</option>
                                                        <option value="Niveau -0.5">Niveau -0.5</option>
                                                        <option value="Niveau -1">Niveau -1</option>
                                                        <option value="Niveau -1.5">Niveau -1.5</option>
                                                        <option value="Niveau -2">Niveau -2</option>
                                                        <option value="Niveau -2.5">Niveau -2.5</option>
                                                        <option value="Niveau -3">Niveau -3</option>
                                                        <option value="Niveau -3.5">Niveau -3.5</option>
                                                        <option value="Niveau -4">Niveau -4</option>
                                                        <option value="Niveau -4.5">Niveau -4.5</option>
                                                        <option value="Niveau -5">Niveau -5</option>
                                                        <option value="Niveau -5.5">Niveau -5.5</option>
                                                        <option value="Niveau -6">Niveau -6</option>
                                                        <option value="Niveau -6.5">Niveau -6.5</option>
                                                        <option value="Niveau -7">Niveau -7</option>
                                                        <option value="Niveau -7.5">Niveau -7.5</option>
                                                        <option value="Niveau -8">Niveau -8</option>
                                                        <option value="Niveau -8.5">Niveau -8.5</option>
                                                        <option value="Niveau -9">Niveau -9</option>
                                                        <option value="Niveau -9.5">Niveau -9.5</option>
                                                        <option value="Niveau -10">Niveau -10</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Heure(s) :</label>
                                                <div class="controls">
                                                    <input type="text" class="span2" id="ht2" name="ht2" value="" placeholder="">
                                                </div>
                                            </div>
                                        <?php endif ; ?>
                                        <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                        <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <!--button id="addButton" type="button">Plus de tâches</button-->
                                    <div class="span2 btn-block"></div>
                                    <a id="addButton" class="sAdd btn btn-success span3" title="" href="#"><i class="icon-plus"></i> Plus de tâches</a>
                                    <!--button  type="button">Moins de tâches</button-->
                                    <div class=" span2 btn-block"></div>
                                    <a id="minusButton" class="sAdd btn btn-danger danger span3" title="" href="#"><i class="icon-minus"></i> Moins de tâches</a>
                                    <div class=" span2 btn-block"></div>
                                </div>
                                <fieldset class="moreActions">
                                    <div class="control-group">
                                        <label class="control-label" style="font-size: medium; font-weight: bold">Catégorie de tâche:</label>
                                        <div class="controls tasks">
                                            <?php if(sizeof($workerToUpdate)===1) :?>
                                            <select class="span4 typeTask3 mySelect" name="type_task3" onchange="getId3(this.value)">
                                                <option>Catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <?php foreach($workerToUpdate as $worker) : ?>
                                                        <option value="<?= $typeTache['id']?>" <?php if($worker['type_task_id_3']===$typeTache['id']) : ?> selected="selected" <?php endif ;?>><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                    <?php endforeach ; ?>
                                                <?php endforeach;?>
                                            </select>
                                            <?php else : ?>
                                                <select class="span4 typeTask3 mySelect" name="type_task3" onchange="getId3(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <option value="<?= $typeTache['id']?>"><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                    <div class="control-group">
                                        <label class="control-label">Tâche :</label>
                                        <div class="controls">
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                            <select class="span4 mySelect task3" name="tasks3">
                                                <option>Tâche</option>
                                                <?php foreach($listTache as $tache) :?>
                                                    <?php foreach($workerToUpdate as $worker) :?>
                                                        <option value="<?= $tache['id']?>" <?php if($tache['id']=== $worker['task_id_3']) : ?> selected="selected" <?php endif; ?>><?= $tache['code'].' '.$tache['nom']?></option>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php else : ?>
                                                <select class="span4 mySelect task3" name="tasks3">
                                                    <option>Tâche</option>
                                                </select>
                                            <?php endif ; ?>
                                            </div>
                                        </div>
                                <?php if(sizeof($workerToUpdate)===1) : ?>
                                    <?php foreach($workerToUpdate as $worker) : ?>
                                    <?php if (!empty($batimentList)) : ?>
                                        <div class="control-group">
                                            <label class="control-label">Bâtiment :</label>
                                            <div class="controls">
                                                <select class="span4 mySelect select2-container" id="bat3" name="bat3">
                                                    <option>Bâtiment</option>
                                                    <?php foreach($batimentList as $batiment) : ?>
                                                        <?php foreach($workerToUpdate as $worker) : ?>
                                                            <option value="<?= $batiment['id']?>" <?php if($worker['bat_3']=== $batiment['id']) : ?> selected="selected" <?php endif; ?>><?= $batiment['nom']?></option>
                                                        <?php endforeach ;?>
                                                    <?php endforeach ;?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="control-group">
                                            <label class="control-label">Batiment :</label>
                                            <div class="controls">
                                                <input type="text" class="span4" id="bat3" name="bat3" <?php if(!empty($worker['bat_3'])) : ?> value="<?= $worker['bat_3'] ?>" <?php else :?> placeholder="Batiment" <?php endif ; ?>>
                                            </div>
                                        </div>
                                    <?php endif ; ?>
                                    <div class="control-group">
                                        <label class="control-label">Axe :</label>
                                        <div class="controls">
                                                <input type="text" class="span4" id="axe3" name="axe3" <?php if(!empty($worker['axe_3'])) : ?> value="<?= $worker['axe_3'] ?>" <?php else :?> placeholder="Axe" <?php endif ; ?>>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Etage :</label>
                                        <div class="controls">
                                            <select class="select2-container span2" name="et3">
                                                <option value="<?= $worker['et_3'] ?>" <?php if(($worker['et_3'] === 'Niveau 10')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau 9')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau 8')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau 7')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau 6')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau 5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau 4')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau 3')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau 2')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau 1')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'RDC')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -0.5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -1')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -1.5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -2')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -2.5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -3')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -3.5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -4')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -4.5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -5.5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -6')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -6.5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -7')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -7.5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -8')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -8.5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -9')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -9.5')) : ?>
                                                <?php elseif  (($worker['et_3'] === 'Niveau -10')) : ?>
                                                    selected = "selected" <?php endif; ?> ><?= $worker['et_3'] ?></option>
                                                <option></option>
                                                <option value="Niveau 10">Niveau 10</option>
                                                <option value="Niveau 9">Niveau 9</option>
                                                <option value="Niveau 8">Niveau 8</option>
                                                <option value="Niveau 7">Niveau 7</option>
                                                <option value="Niveau 6">Niveau 6</option>
                                                <option value="Niveau 5">Niveau 5</option>
                                                <option value="Niveau 4">Niveau 4</option>
                                                <option value="Niveau 3">Niveau 3</option>
                                                <option value="Niveau 2">Niveau 2</option>
                                                <option value="Niveau 1">Niveau 1</option>
                                                <option value="Niveau RDC">Niveau RDC</option>
                                                <option value="Niveau -0.5">Niveau -0.5</option>
                                                <option value="Niveau -1">Niveau -1</option>
                                                <option value="Niveau -1.5">Niveau -1.5</option>
                                                <option value="Niveau -2">Niveau -2</option>
                                                <option value="Niveau -2.5">Niveau -2.5</option>
                                                <option value="Niveau -3">Niveau -3</option>
                                                <option value="Niveau -3.5">Niveau -3.5</option>
                                                <option value="Niveau -4">Niveau -4</option>
                                                <option value="Niveau -4.5">Niveau -4.5</option>
                                                <option value="Niveau -5">Niveau -5</option>
                                                <option value="Niveau -5.5">Niveau -5.5</option>
                                                <option value="Niveau -6">Niveau -6</option>
                                                <option value="Niveau -6.5">Niveau -6.5</option>
                                                <option value="Niveau -7">Niveau -7</option>
                                                <option value="Niveau -7.5">Niveau -7.5</option>
                                                <option value="Niveau -8">Niveau -8</option>
                                                <option value="Niveau -8.5">Niveau -8.5</option>
                                                <option value="Niveau -9">Niveau -9</option>
                                                <option value="Niveau -9.5">Niveau -9.5</option>
                                                <option value="Niveau -10">Niveau -10</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Heure(s) :</label>
                                        <div class="controls">
                                                <input type="text" class="span2" id="ht3" name="ht3" value="<?= $worker['ht3'] ?>" placeholder="">
                                            </div>
                                    </div>
                                   <?php endforeach ;?>
                                <?php else : ?>
                                    <?php if(!empty($batimentList)) : ?>
                                        <div class="control-group">
                                            <label class="control-label">Bâtiment :</label>
                                            <div class="controls">
                                                <select class="span4 mySelect select2-container" id="bat3" name="bat3">
                                                    <option>Bâtiment</option>
                                                    <?php foreach($batimentList as $batiment) : ?>
                                                        <option value="<?= $batiment['id']?>" ><?= $batiment['nom']?></option>
                                                    <?php endforeach ;?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                    <div class="control-group">
                                        <label class="control-label">Batiment :</label>
                                        <div class="controls">
                                                <input type="text" class="span4" id="bat3" name="bat3"placeholder="Batiment" >
                                            </div>
                                        </div>
                                    <?php endif ; ?>
                                    <div class="control-group">
                                        <label class="control-label">Axe :</label>
                                        <div class="controls">
                                                <input type="text" class="span4" id="axe3" name="axe3" placeholder="Axe" >
                                            </div>
                                        </div>

                                    <div class="control-group">
                                        <label class="control-label">Etage :</label>
                                        <div class="controls">
                                            <select class="select2-container span2" name="et3">
                                                <option></option>
                                                <option value="Niveau 10">Niveau 10</option>
                                                <option value="Niveau 9">Niveau 9</option>
                                                <option value="Niveau 8">Niveau 8</option>
                                                <option value="Niveau 7">Niveau 7</option>
                                                <option value="Niveau 6">Niveau 6</option>
                                                <option value="Niveau 5">Niveau 5</option>
                                                <option value="Niveau 4">Niveau 4</option>
                                                <option value="Niveau 3">Niveau 3</option>
                                                <option value="Niveau 2">Niveau 2</option>
                                                <option value="Niveau 1">Niveau 1</option>
                                                <option value="Niveau RDC">Niveau RDC</option>
                                                <option value="Niveau -0.5">Niveau -0.5</option>
                                                <option value="Niveau -1">Niveau -1</option>
                                                <option value="Niveau -1.5">Niveau -1.5</option>
                                                <option value="Niveau -2">Niveau -2</option>
                                                <option value="Niveau -2.5">Niveau -2.5</option>
                                                <option value="Niveau -3">Niveau -3</option>
                                                <option value="Niveau -3.5">Niveau -3.5</option>
                                                <option value="Niveau -4">Niveau -4</option>
                                                <option value="Niveau -4.5">Niveau -4.5</option>
                                                <option value="Niveau -5">Niveau -5</option>
                                                <option value="Niveau -5.5">Niveau -5.5</option>
                                                <option value="Niveau -6">Niveau -6</option>
                                                <option value="Niveau -6.5">Niveau -6.5</option>
                                                <option value="Niveau -7">Niveau -7</option>
                                                <option value="Niveau -7.5">Niveau -7.5</option>
                                                <option value="Niveau -8">Niveau -8</option>
                                                <option value="Niveau -8.5">Niveau -8.5</option>
                                                <option value="Niveau -9">Niveau -9</option>
                                                <option value="Niveau -9.5">Niveau -9.5</option>
                                                <option value="Niveau -10">Niveau -10</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Heure(s) :</label>
                                        <div class="controls">
                                                <input type="text" class="span2" id="ht3" name="ht3" value="" placeholder="">
                                            </div>
                                        </div>
                                <?php endif ; ?>
                                    <div class="control-group">
                                        <label class="control-label" style="font-size: medium; font-weight: bold">Catégorie de tâche :</label>
                                        <div class="controls tasks">
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <select class="span4 typeTask4 mySelect" name="type_task4" onchange="getId4(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <?php foreach($workerToUpdate as $worker) : ?>
                                                            <option value="<?= $typeTache['id']?>" <?php if($typeTache['id']=== $worker['type_task_id_4']): ?> selected="selected" <?php endif;?>><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                        <?php endforeach;?>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php else : ?>
                                                <select class="span4 typeTask4 mySelect" name="type_task4" onchange="getId4(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <option value="<?= $typeTache['id']?>"><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                    <div class="control-group">
                                        <label class="control-label">Tâche :</label>
                                        <div class="controls">
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <select class="span4 mySelect task4" name="tasks4">
                                                    <option>Tâche</option>
                                                    <?php foreach($listTache as $tache) :?>
                                                        <?php foreach($workerToUpdate as $worker) : ?>
                                                            <option value="<?= $tache['id']?>" <?php if($tache['id']===$worker['task_id_4']) :?> selected="selected" <?php endif ; ?>><?= $tache['code'].' '.$tache['nom']?></option>
                                                        <?php endforeach ; ?>
                                                    <?php endforeach ; ?>
                                                </select>
                                            <?php else : ?>
                                                <select class="span4 mySelect task4" name="tasks4">
                                                    <option>Tâche</option>
                                                </select>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php if(sizeof($workerToUpdate)===1) : ?>
                                        <?php foreach($workerToUpdate as $worker) : ?>
                                            <?php if(!empty($batimentList)) : ?>
                                                <div class="control-group">
                                                    <label class="control-label">Bâtiment :</label>
                                                    <div class="controls">
                                                        <select class="span4 mySelect select2-container" id="bat4" name="bat4">
                                                            <option>Bâtiment</option>
                                                            <?php foreach($batimentList as $batiment) : ?>
                                                                <?php foreach($workerToUpdate as $worker) : ?>
                                                                    <option value="<?= $batiment['id']?>" <?php if($worker['bat_4']=== $batiment['id']) : ?> selected="selected" <?php endif; ?>><?= $batiment['nom']?></option>
                                                                <?php endforeach ;?>
                                                            <?php endforeach ;?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="control-group">
                                                    <label class="control-label">Batiment :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" id="bat4" name="bat4" <?php if(!empty($worker['bat_4'])) : ?> value="<?= $worker['bat_4'] ?>" <?php else :?> placeholder="Batiment" <?php endif ; ?>>
                                                    </div>
                                                </div>
                                            <?php endif ; ?>
                                            <div class="control-group">
                                                <label class="control-label">Axe :</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" id="axe4" name="axe4" <?php if(!empty($worker['axe_4'])) : ?> value="<?= $worker['axe_4'] ?>" <?php else :?> placeholder="Axe" <?php endif ; ?>>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                        <label class="control-label">Etage :</label>
                                                        <div class="controls">
                                                            <select class="select2-container span2" name="et4">
                                                                <option value="<?= $worker['et_4'] ?>" <?php if(($worker['et_4'] === 'Niveau 10')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau 9')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau 8')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau 7')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau 6')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau 5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau 4')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau 3')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau 2')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau 1')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'RDC')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -0.5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -1')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -1.5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -2')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -2.5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -3')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -3.5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -4')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -4.5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -5.5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -6')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -6.5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -7')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -7.5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -8')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -8.5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -9')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -9.5')) : ?>
                                                                <?php elseif  (($worker['et_4'] === 'Niveau -10')) : ?>
                                                                    selected = "selected" <?php endif; ?> ><?= $worker['et_4'] ?></option>
                                                                <option></option>
                                                                <option value="Niveau 10">Niveau 10</option>
                                                                <option value="Niveau 9">Niveau 9</option>
                                                                <option value="Niveau 8">Niveau 8</option>
                                                                <option value="Niveau 7">Niveau 7</option>
                                                                <option value="Niveau 6">Niveau 6</option>
                                                                <option value="Niveau 5">Niveau 5</option>
                                                                <option value="Niveau 4">Niveau 4</option>
                                                                <option value="Niveau 3">Niveau 3</option>
                                                                <option value="Niveau 2">Niveau 2</option>
                                                                <option value="Niveau 1">Niveau 1</option>
                                                                <option value="Niveau RDC">Niveau RDC</option>
                                                                <option value="Niveau -0.5">Niveau -0.5</option>
                                                                <option value="Niveau -1">Niveau -1</option>
                                                                <option value="Niveau -1.5">Niveau -1.5</option>
                                                                <option value="Niveau -2">Niveau -2</option>
                                                                <option value="Niveau -2.5">Niveau -2.5</option>
                                                                <option value="Niveau -3">Niveau -3</option>
                                                                <option value="Niveau -3.5">Niveau -3.5</option>
                                                                <option value="Niveau -4">Niveau -4</option>
                                                                <option value="Niveau -4.5">Niveau -4.5</option>
                                                                <option value="Niveau -5">Niveau -5</option>
                                                                <option value="Niveau -5.5">Niveau -5.5</option>
                                                                <option value="Niveau -6">Niveau -6</option>
                                                                <option value="Niveau -6.5">Niveau -6.5</option>
                                                                <option value="Niveau -7">Niveau -7</option>
                                                                <option value="Niveau -7.5">Niveau -7.5</option>
                                                                <option value="Niveau -8">Niveau -8</option>
                                                                <option value="Niveau -8.5">Niveau -8.5</option>
                                                                <option value="Niveau -9">Niveau -9</option>
                                                                <option value="Niveau -9.5">Niveau -9.5</option>
                                                                <option value="Niveau -10">Niveau -10</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                            <div class="control-group">
                                                <label class="control-label">Heure(s) :</label>
                                                <div class="controls">
                                                    <input type="text" class="span2" id="ht4" name="ht4" value="<?= $worker['ht4'] ?>" placeholder="">
                                                </div>
                                            </div>
                                                    <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                    <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                        <?php endforeach ; ?>
                                    <?php else : ?>
                                        <?php if(!empty($batimentList)) : ?>
                                            <div class="control-group">
                                                <label class="control-label">Bâtiment :</label>
                                                <div class="controls">
                                                    <select class="span4 mySelect select2-container" id="bat4" name="bat4">
                                                        <option>Bâtiment</option>
                                                        <?php foreach($batimentList as $batiment) : ?>
                                                            <option value="<?= $batiment['id']?>" ><?= $batiment['nom']?></option>
                                                        <?php endforeach ;?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div class="control-group">
                                                <label class="control-label">Batiment :</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" id="bat4" name="bat4"  placeholder="Batiment" >
                                                </div>
                                            </div>
                                        <?php endif ; ?>
                                        <div class="control-group">
                                                <label class="control-label">Axe :</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" id="axe4" name="axe4"  placeholder="Axe" >
                                                </div>
                                            </div>
                                        <div class="control-group">
                                                    <label class="control-label">Etage :</label>
                                                    <div class="controls">
                                                        <select class="select2-container span2" name="et4">
                                                            <option></option>
                                                            <option value="Niveau 10">Niveau 10</option>
                                                            <option value="Niveau 9">Niveau 9</option>
                                                            <option value="Niveau 8">Niveau 8</option>
                                                            <option value="Niveau 7">Niveau 7</option>
                                                            <option value="Niveau 6">Niveau 6</option>
                                                            <option value="Niveau 5">Niveau 5</option>
                                                            <option value="Niveau 4">Niveau 4</option>
                                                            <option value="Niveau 3">Niveau 3</option>
                                                            <option value="Niveau 2">Niveau 2</option>
                                                            <option value="Niveau 1">Niveau 1</option>
                                                            <option value="Niveau RDC">Niveau RDC</option>
                                                            <option value="Niveau -0.5">Niveau -0.5</option>
                                                            <option value="Niveau -1">Niveau -1</option>
                                                            <option value="Niveau -1.5">Niveau -1.5</option>
                                                            <option value="Niveau -2">Niveau -2</option>
                                                            <option value="Niveau -2.5">Niveau -2.5</option>
                                                            <option value="Niveau -3">Niveau -3</option>
                                                            <option value="Niveau -3.5">Niveau -3.5</option>
                                                            <option value="Niveau -4">Niveau -4</option>
                                                            <option value="Niveau -4.5">Niveau -4.5</option>
                                                            <option value="Niveau -5">Niveau -5</option>
                                                            <option value="Niveau -5.5">Niveau -5.5</option>
                                                            <option value="Niveau -6">Niveau -6</option>
                                                            <option value="Niveau -6.5">Niveau -6.5</option>
                                                            <option value="Niveau -7">Niveau -7</option>
                                                            <option value="Niveau -7.5">Niveau -7.5</option>
                                                            <option value="Niveau -8">Niveau -8</option>
                                                            <option value="Niveau -8.5">Niveau -8.5</option>
                                                            <option value="Niveau -9">Niveau -9</option>
                                                            <option value="Niveau -9.5">Niveau -9.5</option>
                                                            <option value="Niveau -10">Niveau -10</option>
                                                        </select>
                                                    </div>
                                                </div>
                                        <div class="control-group">
                                                <label class="control-label">Heure(s) :</label>
                                                <div class="controls">
                                                    <input type="text" class="span2" id="ht4" name="ht4" value="" placeholder="">
                                                </div>
                                            </div>
                                                <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                    <?php endif; ?>
                                    <div class="control-group">
                                        <label class="control-label" style="font-size: medium; font-weight: bold">Catégorie de tâche :</label>
                                        <div class="controls tasks">
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                            <select class="span4 typeTask5 mySelect" name="type_task5" onchange="getId5(this.value)">
                                                <option>Catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <?php foreach($workerToUpdate as $worker) : ?>
                                                        <option value="<?= $typeTache['id']?>" <?php if($typeTache['id']=== $worker['type_task_id_5']): ?> selected="selected" <?php endif;?>><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                <?php endforeach;?>
                                            </select>
                                            <?php else : ?>
                                                <select class="span4 typeTask5 mySelect" name="type_task5" onchange="getId5(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <option value="<?= $typeTache['id']?>"><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Tâche :</label>
                                            <div class="controls">
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <select class="span4 mySelect task5" name="tasks5">
                                                    <option>Tâche</option>
                                                    <?php foreach($listTache as $tache) :?>
                                                        <?php foreach($workerToUpdate as $worker) : ?>
                                                            <option value="<?= $tache['id']?>" <?php if($tache['id']===$worker['task_id_5']) :?> selected="selected" <?php endif ; ?>><?= $tache['code'].' '.$tache['nom']?></option>
                                                        <?php endforeach ; ?>
                                                    <?php endforeach ; ?>
                                                </select>
                                            <?php else : ?>
                                                <select class="span4 mySelect task5" name="tasks5">
                                                    <option>Tâche</option>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <?php foreach($workerToUpdate as $worker) : ?>
                                                    <?php if(!empty($batimentList)) : ?>
                                                        <div class="control-group">
                                                            <label class="control-label">Bâtiment :</label>
                                                            <div class="controls">
                                                                <select class="span4 mySelect select2-container" id="bat5" name="bat5">
                                                                    <option>Bâtiment</option>
                                                                    <?php foreach($batimentList as $batiment) : ?>
                                                                        <?php foreach($workerToUpdate as $worker) : ?>
                                                                            <option value="<?= $batiment['id']?>" <?php if($worker['bat_5']=== $batiment['id']) : ?> selected="selected" <?php endif; ?>><?= $batiment['nom']?></option>
                                                                        <?php endforeach ;?>
                                                                    <?php endforeach ;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="control-group">
                                                            <label class="control-label">Batiment :</label>
                                                            <div class="controls">
                                                                <input type="text" class="span4" id="bat5" name="bat5" <?php if(!empty($worker['bat_5'])) : ?> value="<?= $worker['bat_5'] ?>" <?php else :?> placeholder="Batiment" <?php endif ; ?>>
                                                            </div>
                                                        </div>
                                                    <?php endif ; ?>
                                                <div class="control-group">
                                                    <label class="control-label">Axe :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" id="axe5" name="axe5" <?php if(!empty($worker['axe_5'])) : ?> value="<?= $worker['axe_5'] ?>" <?php else :?> placeholder="Axe" <?php endif ; ?>>
                                                    </div>
                                                </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Etage :</label>
                                                        <div class="controls">
                                                            <select class="select2-container span2" name="et5">
                                                                <option value="<?= $worker['et_5'] ?>" <?php if(($worker['et_5'] === 'Niveau 10')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau 9')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau 8')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau 7')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau 6')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau 5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau 4')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau 3')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau 2')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau 1')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'RDC')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -0.5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -1')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -1.5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -2')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -2.5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -3')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -3.5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -4')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -4.5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -5.5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -6')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -6.5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -7')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -7.5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -8')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -8.5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -9')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -9.5')) : ?>
                                                                <?php elseif  (($worker['et_5'] === 'Niveau -10')) : ?>
                                                                    selected = "selected" <?php endif; ?> ><?= $worker['et_5'] ?></option>
                                                                <option></option>
                                                                <option value="Niveau 10">Niveau 10</option>
                                                                <option value="Niveau 9">Niveau 9</option>
                                                                <option value="Niveau 8">Niveau 8</option>
                                                                <option value="Niveau 7">Niveau 7</option>
                                                                <option value="Niveau 6">Niveau 6</option>
                                                                <option value="Niveau 5">Niveau 5</option>
                                                                <option value="Niveau 4">Niveau 4</option>
                                                                <option value="Niveau 3">Niveau 3</option>
                                                                <option value="Niveau 2">Niveau 2</option>
                                                                <option value="Niveau 1">Niveau 1</option>
                                                                <option value="Niveau RDC">Niveau RDC</option>
                                                                <option value="Niveau -0.5">Niveau -0.5</option>
                                                                <option value="Niveau -1">Niveau -1</option>
                                                                <option value="Niveau -1.5">Niveau -1.5</option>
                                                                <option value="Niveau -2">Niveau -2</option>
                                                                <option value="Niveau -2.5">Niveau -2.5</option>
                                                                <option value="Niveau -3">Niveau -3</option>
                                                                <option value="Niveau -3.5">Niveau -3.5</option>
                                                                <option value="Niveau -4">Niveau -4</option>
                                                                <option value="Niveau -4.5">Niveau -4.5</option>
                                                                <option value="Niveau -5">Niveau -5</option>
                                                                <option value="Niveau -5.5">Niveau -5.5</option>
                                                                <option value="Niveau -6">Niveau -6</option>
                                                                <option value="Niveau -6.5">Niveau -6.5</option>
                                                                <option value="Niveau -7">Niveau -7</option>
                                                                <option value="Niveau -7.5">Niveau -7.5</option>
                                                                <option value="Niveau -8">Niveau -8</option>
                                                                <option value="Niveau -8.5">Niveau -8.5</option>
                                                                <option value="Niveau -9">Niveau -9</option>
                                                                <option value="Niveau -9.5">Niveau -9.5</option>
                                                                <option value="Niveau -10">Niveau -10</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <div class="control-group">
                                                    <label class="control-label">Heure(s) :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span2" id="ht5" name="ht5" value="<?= $worker['ht5'] ?>" placeholder="">
                                                    </div>
                                                </div>
                                                    <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                    <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                                <?php endforeach ; ?>
                                            <?php else : ?>
                                                <?php if(!empty($batimentList)) : ?>
                                                    <div class="control-group">
                                                        <label class="control-label">Bâtiment :</label>
                                                        <div class="controls">
                                                            <select class="span4 mySelect select2-container" id="bat5" name="bat5">
                                                                <option>Bâtiment</option>
                                                                <?php foreach($batimentList as $batiment) : ?>
                                                                    <option value="<?= $batiment['id']?>" ><?= $batiment['nom']?></option>
                                                                <?php endforeach ;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="control-group">
                                                        <label class="control-label">Batiment :</label>
                                                        <div class="controls">
                                                            <input type="text" class="span4" id="bat5" name="bat5"  placeholder="Batiment" >
                                                        </div>
                                                    </div>
                                                <?php endif ; ?>
                                                <div class="control-group">
                                                    <label class="control-label">Axe :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" id="axe5" name="axe5"  placeholder="Axe" >
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Etage :</label>
                                                    <div class="controls">
                                                        <select class="select2-container span2" name="et5">
                                                            <option></option>
                                                            <option value="Niveau 10">Niveau 10</option>
                                                            <option value="Niveau 9">Niveau 9</option>
                                                            <option value="Niveau 8">Niveau 8</option>
                                                            <option value="Niveau 7">Niveau 7</option>
                                                            <option value="Niveau 6">Niveau 6</option>
                                                            <option value="Niveau 5">Niveau 5</option>
                                                            <option value="Niveau 4">Niveau 4</option>
                                                            <option value="Niveau 3">Niveau 3</option>
                                                            <option value="Niveau 2">Niveau 2</option>
                                                            <option value="Niveau 1">Niveau 1</option>
                                                            <option value="Niveau RDC">Niveau RDC</option>
                                                            <option value="Niveau -0.5">Niveau -0.5</option>
                                                            <option value="Niveau -1">Niveau -1</option>
                                                            <option value="Niveau -1.5">Niveau -1.5</option>
                                                            <option value="Niveau -2">Niveau -2</option>
                                                            <option value="Niveau -2.5">Niveau -2.5</option>
                                                            <option value="Niveau -3">Niveau -3</option>
                                                            <option value="Niveau -3.5">Niveau -3.5</option>
                                                            <option value="Niveau -4">Niveau -4</option>
                                                            <option value="Niveau -4.5">Niveau -4.5</option>
                                                            <option value="Niveau -5">Niveau -5</option>
                                                            <option value="Niveau -5.5">Niveau -5.5</option>
                                                            <option value="Niveau -6">Niveau -6</option>
                                                            <option value="Niveau -6.5">Niveau -6.5</option>
                                                            <option value="Niveau -7">Niveau -7</option>
                                                            <option value="Niveau -7.5">Niveau -7.5</option>
                                                            <option value="Niveau -8">Niveau -8</option>
                                                            <option value="Niveau -8.5">Niveau -8.5</option>
                                                            <option value="Niveau -9">Niveau -9</option>
                                                            <option value="Niveau -9.5">Niveau -9.5</option>
                                                            <option value="Niveau -10">Niveau -10</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Heure(s) :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span2" id="ht5" name="ht5" value="" placeholder="">
                                                    </div>
                                                </div>
                                                <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                            <?php endif; ?>
                                    <div class="control-group">
                                        <label class="control-label" style="font-size: medium; font-weight: bold">Catégorie de tâche :</label>
                                        <div class="controls tasks">
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <select class="span4 typeTask6 mySelect" name="type_task6" onchange="getId6(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <?php foreach($workerToUpdate as $worker) :?>
                                                            <option value="<?= $typeTache['id']?>" <?php if($typeTache['id'] === $worker['type_task_id_6']) : ?> selected="selected" <?php endif;?>><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                        <?php endforeach;?>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php else : ?>
                                                <select class="span4 typeTask6 mySelect" name="type_task6" onchange="getId6(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <option value="<?= $typeTache['id']?>"><?= $typeTache['code_type_tache'].' '.$typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php endif ; ?>
                                            </div>
                                        </div>
                                    <div class="control-group">
                                        <label class="control-label">Tâche :</label>
                                        <div class="controls">
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <select class="span4 mySelect task6" name="tasks6">
                                                    <option>Tâche</option>
                                                <?php foreach($listTache as $tache) :?>
                                                    <?php foreach($workerToUpdate as $worker) :?>
                                                        <option value="<?=$tache['id'] ?>"  <?php if($tache['id']=== $worker['task_id_6']) : ?> selected="selected" <?php endif ; ?>><?= $tache['code'].' '.$tache['nom'] ?></option>
                                                    <?php endforeach;?>
                                                <?php endforeach;?>
                                                </select>
                                            <?php else : ?>
                                                <select class="span4 mySelect task6" name="tasks6">
                                                    <option>Tâche</option>
                                                </select>
                                            <?php endif ; ?>
                                            </div>
                                        </div>
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <?php foreach($workerToUpdate as $worker) :?>
                                                    <?php if(!empty($batimentList)) : ?>
                                                        <div class="control-group">
                                                            <label class="control-label">Bâtiment :</label>
                                                            <div class="controls">
                                                                <select class="span4 mySelect select2-container" id="bat6" name="bat6">
                                                                    <option>Bâtiment</option>
                                                                    <?php foreach($batimentList as $batiment) : ?>
                                                                        <?php foreach($workerToUpdate as $worker) : ?>
                                                                            <option value="<?= $batiment['id']?>" <?php if($worker['bat_6']=== $batiment['id']) : ?> selected="selected" <?php endif; ?>><?= $batiment['nom']?></option>
                                                                        <?php endforeach ;?>
                                                                    <?php endforeach ;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php else :?>
                                                    <div class="control-group">
                                                        <label class="control-label">Batiment :</label>
                                                        <div class="controls">
                                                            <input type="text" class="span4" id="bat6" name="bat6" <?php if(!empty($worker['bat_6'])) : ?> value="<?= $worker['bat_6'] ?>" <?php else :?> placeholder="Batiment" <?php endif ; ?>>
                                                        </div>
                                                    </div>
                                                    <?php endif ; ?>
                                                    <div class="control-group">
                                                        <label class="control-label">Axe :</label>
                                                        <div class="controls">
                                                            <input type="text" class="span4" id="axe6" name="axe6" <?php if(!empty($worker['axe_6'])) : ?> value="<?= $worker['axe_6'] ?>" <?php else :?> placeholder="Axe" <?php endif ; ?>>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                            <label class="control-label">Etage :</label>
                                                            <div class="controls">
                                                                <select class="select2-container span2" name="et6">
                                                                    <option value="<?= $worker['et_6'] ?>" <?php if(($worker['et_6'] === 'Niveau 10')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau 9')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau 8')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau 7')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau 6')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau 5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau 4')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau 3')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau 2')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau 1')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'RDC')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -0.5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -1')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -1.5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -2')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -2.5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -3')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -3.5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -4')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -4.5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -5.5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -6')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -6.5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -7')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -7.5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -8')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -8.5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -9')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -9.5')) : ?>
                                                                    <?php elseif  (($worker['et_6'] === 'Niveau -10')) : ?>
                                                                        selected = "selected" <?php endif; ?> ><?= $worker['et_6'] ?></option>
                                                                    <option></option>
                                                                    <option value="Niveau 10">Niveau 10</option>
                                                                    <option value="Niveau 9">Niveau 9</option>
                                                                    <option value="Niveau 8">Niveau 8</option>
                                                                    <option value="Niveau 7">Niveau 7</option>
                                                                    <option value="Niveau 6">Niveau 6</option>
                                                                    <option value="Niveau 5">Niveau 5</option>
                                                                    <option value="Niveau 4">Niveau 4</option>
                                                                    <option value="Niveau 3">Niveau 3</option>
                                                                    <option value="Niveau 2">Niveau 2</option>
                                                                    <option value="Niveau 1">Niveau 1</option>
                                                                    <option value="Niveau RDC">Niveau RDC</option>
                                                                    <option value="Niveau -0.5">Niveau -0.5</option>
                                                                    <option value="Niveau -1">Niveau -1</option>
                                                                    <option value="Niveau -1.5">Niveau -1.5</option>
                                                                    <option value="Niveau -2">Niveau -2</option>
                                                                    <option value="Niveau -2.5">Niveau -2.5</option>
                                                                    <option value="Niveau -3">Niveau -3</option>
                                                                    <option value="Niveau -3.5">Niveau -3.5</option>
                                                                    <option value="Niveau -4">Niveau -4</option>
                                                                    <option value="Niveau -4.5">Niveau -4.5</option>
                                                                    <option value="Niveau -5">Niveau -5</option>
                                                                    <option value="Niveau -5.5">Niveau -5.5</option>
                                                                    <option value="Niveau -6">Niveau -6</option>
                                                                    <option value="Niveau -6.5">Niveau -6.5</option>
                                                                    <option value="Niveau -7">Niveau -7</option>
                                                                    <option value="Niveau -7.5">Niveau -7.5</option>
                                                                    <option value="Niveau -8">Niveau -8</option>
                                                                    <option value="Niveau -8.5">Niveau -8.5</option>
                                                                    <option value="Niveau -9">Niveau -9</option>
                                                                    <option value="Niveau -9.5">Niveau -9.5</option>
                                                                    <option value="Niveau -10">Niveau -10</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Heure(s) :</label>
                                                        <div class="controls">
                                                            <input type="text" class="span2" id="ht6" name="ht6" value="<?= $worker['ht6'] ?>" placeholder="Hre">
                                                        </div>
                                                    </div>
                                                    <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                    <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                                <?php endforeach;?>
                                            <?php else : ?>
                                                <?php if(!empty($batimentList)) : ?>
                                                    <div class="control-group">
                                                        <label class="control-label">Bâtiment :</label>
                                                        <div class="controls">
                                                            <select class="span4 mySelect select2-container" id="bat6" name="bat6">
                                                                <option>Bâtiment</option>
                                                                <?php foreach($batimentList as $batiment) : ?>
                                                                    <option value="<?= $batiment['id']?>" ><?= $batiment['nom']?></option>
                                                                <?php endforeach ;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                <div class="control-group">
                                                    <label class="control-label">Batiment :</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" id="bat6" name="bat6"  placeholder="Batiment" >
                                                    </div>
                                                </div>
                                                <?php endif ; ?>
                                            <div class="control-group">
                                                <label class="control-label">Axe :</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" id="axe6" name="axe6" placeholder="Axe" >
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                    <label class="control-label">Etage :</label>
                                                    <div class="controls">
                                                        <select class="select2-container span2" name="et6">
                                                            <option></option>
                                                            <option value="Niveau 10">Niveau 10</option>
                                                            <option value="Niveau 9">Niveau 9</option>
                                                            <option value="Niveau 8">Niveau 8</option>
                                                            <option value="Niveau 7">Niveau 7</option>
                                                            <option value="Niveau 6">Niveau 6</option>
                                                            <option value="Niveau 5">Niveau 5</option>
                                                            <option value="Niveau 4">Niveau 4</option>
                                                            <option value="Niveau 3">Niveau 3</option>
                                                            <option value="Niveau 2">Niveau 2</option>
                                                            <option value="Niveau 1">Niveau 1</option>
                                                            <option value="Niveau RDC">Niveau RDC</option>
                                                            <option value="Niveau -0.5">Niveau -0.5</option>
                                                            <option value="Niveau -1">Niveau -1</option>
                                                            <option value="Niveau -1.5">Niveau -1.5</option>
                                                            <option value="Niveau -2">Niveau -2</option>
                                                            <option value="Niveau -2.5">Niveau -2.5</option>
                                                            <option value="Niveau -3">Niveau -3</option>
                                                            <option value="Niveau -3.5">Niveau -3.5</option>
                                                            <option value="Niveau -4">Niveau -4</option>
                                                            <option value="Niveau -4.5">Niveau -4.5</option>
                                                            <option value="Niveau -5">Niveau -5</option>
                                                            <option value="Niveau -5.5">Niveau -5.5</option>
                                                            <option value="Niveau -6">Niveau -6</option>
                                                            <option value="Niveau -6.5">Niveau -6.5</option>
                                                            <option value="Niveau -7">Niveau -7</option>
                                                            <option value="Niveau -7.5">Niveau -7.5</option>
                                                            <option value="Niveau -8">Niveau -8</option>
                                                            <option value="Niveau -8.5">Niveau -8.5</option>
                                                            <option value="Niveau -9">Niveau -9</option>
                                                            <option value="Niveau -9.5">Niveau -9.5</option>
                                                            <option value="Niveau -10">Niveau -10</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <div class="control-group">
                                                <label class="control-label">Heure(s) :</label>
                                                <div class="controls">
                                                    <input type="text" class="span2" id="ht6" name="ht6" value="" placeholder="Hre">
                                                </div>
                                            </div>
                                                <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                            <?php endif ; ?>
                                </fieldset>
                                <div class="control-group">
                                    <label class="control-label">Remarque(s) / Régie :</label>
                                    <div class="controls">
                                        <?php if(sizeof($workerToUpdate)===1) : ?>
                                            <?php foreach($workerToUpdate as $worker) :?>
                                                <textarea class="span9" value="<?= $worker['remarque'] ?>" name="remarque"><?= $worker['remarque'] ?></textarea>
                                            <?php endforeach;?>
                                        <?php else : ?>
                                            <textarea class="span9" value="" name="remarque"></textarea>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="">Travaux pénibles :</label>
                                    <div class="controls">
                                        <?php if(sizeof($workerToUpdate)===1) : ?>
                                            <?php foreach($workerToUpdate as $worker) :?>
                                                <input type="text" value="<?= $worker['hins'] ?>" name="hins" class="span1">
                                            <?php endforeach;?>
                                        <?php else : ?>
                                            <input type="text" value="" name="hins" class="span1">
                                        <?php endif ; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Machines :</label>
                                    <div class="controls">
                                        <?php if(sizeof($workerToUpdate) === 1) : ?>
                                            <?php foreach ($workerToUpdate as $worker) : ?>
                                                <select class="span4 select2-container" name="machine">
                                                    <option value="<?= $worker['machine'] ?>" <?php if(($worker['machine'] === 'Marteau')) : ?>
                                                    <?php elseif  (($worker['machine'] === 'Marteau piqueur')) : ?>
                                                    <?php elseif  (($worker['machine'] === 'BRH')) : ?>
                                                        selected = "selected" <?php endif; ?> ><?= $worker['machine'] ?></option>
                                                    <option></option>
                                                    <option value="Marteau">Marteau</option>
                                                    <option value="Marteau piqueur">Marteau piqueur</option>
                                                    <option value="BRH">BRH</option>
                                                </select>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <select class="span4 select2-container" name="machine">
                                                <option></option>
                                                <option value="Marteau">Marteau</option>
                                                <option value="Marteau piqueur">Marteau piqueur</option>
                                                <option value="BRH">BRH</option>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label  class=" control-label" for="">Transport du personnel "T"</label>
                                    <div class="controls">
                                        <?php if(sizeof($workerToUpdate)===1) : ?>
                                            <?php foreach($workerToUpdate as $worker) :?>
                                                <input  type="checkbox"  name="dpl_pers"<?php if($worker['dpl_pers'] === "1") : ?> checked <?php endif ; ?> >
                                            <?php endforeach;?>
                                        <?php else : ?>
                                            <input name="dpl_pers" type="checkbox" >
                                        <?php endif ; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="">Indemnités de déplacement (KM) :</label>
                                    <div class="controls">
                                        <?php if(sizeof($workerToUpdate)===1) : ?>
                                            <?php foreach($workerToUpdate as $worker) :?>
                                                <input type="number" value="<?= $worker['km'] ?>" name="km" class="span1">
                                            <?php endforeach;?>
                                        <?php else : ?>
                                            <input type="number" value="" name="km" class="span1">
                                        <?php endif ; ?>
                                    </div>
                                </div>
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