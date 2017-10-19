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
                                                <input type="hidden" class="span2" name="htot" value="<?= $worker['htot']  ?>" />
                                            <?php endforeach ; ?>
                                            <input type="number" class="span2" name="" value="" disabled/>
                                        <?php endif; ?>
                                        <?php if(!(in_array('Ouvrier', $workerType)) && in_array('Interimaire',$workerType ) && sizeof($workerToUpdate) > 1 ):?>
                                            <?php foreach($workerToUpdate as $worker) : ?>
                                                <input type="hidden" class="span2" name="htot" value="<?= $worker['htot']?>"/>
                                            <?php endforeach ; ?>
                                            <input type="number" class="span2" name="" value="" disabled/>
                                        <?php endif; ?>
                                        <?php if(!(in_array('Ouvrier', $workerType)) && in_array('Interimaire',$workerType ) && sizeof($workerToUpdate) === 1 ):?>
                                            <?php foreach($workerToUpdate as $worker) : ?>
                                                <input type="number" class="span2" name="htot" value="<?= $worker['htot']  ?>"/>
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
                                                <select name="abs">
                                                    <option value="<?= $worker['abs'] ?>" <?php if(($worker['abs'] === 'Maladie (M)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Accident (A)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Congé (C)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Absence  Excusée (EX)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Intempéries (INT)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Congé Extraordinaire (CE)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Absence non Excusée (ABS)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Congé Syndical (CS)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Visite Médicale STI (STI)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Travaux Autre Chantier (TAC)')) : ?>
                                                        <?php elseif  (($worker['abs'] === 'Maladie (M)')) : ?>
                                                        selected = "selected" <?php endif; ?> ><?= $worker['abs'] ?></option>
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
                                            <select name="abs">
                                                <option>Chosir le type d'absence</option>
                                                <option value="Maladie (M)">Maladie (M)</option>
                                                <option value="Accident (A)">Accident (A)</option>
                                                <option value="Congé (C)">Congé (C)</option>
                                                <option value="Absence Excusée (EX)">Absence Excusée (EX)</option>
                                                <option value="Formation (FOR)">Formation (FOR)</option>
                                                <option value="Intempéries (INT)">Intempéries (INT)</option>
                                                <option value="Congé Extraordinaire (CE)">Congé Extraordinaire (CE)</option>
                                                <option value="">Absence non Excusée (ABS)</option>
                                                <option value="Absence non Excusée (ABS)">Congé Syndical (CS)</option>
                                                <option value="Visite Médicale STI (STI)">Visite Médicale STI (STI)</option>
                                                <option value="Travaux Autre Chantier (TAC)">Travaux Autre Chantier (TAC)</option>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                    <label class="control-label">Heures absence :</label>
                                    <div class="controls">
                                        <?php if(sizeof($workerToUpdate) === 1) : ?>
                                            <?php foreach ($workerToUpdate as $worker) : ?>
                                                <input type="number" class="span2" name="habs" value="<?= $worker['habs'] ?>"/>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <input type="number" class="span2" name="habs" value=""/>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <!-- Ajout des tâches de manières dynamiques avec jQuery-->
                                <div class="control-group">
                                    <label class="control-label">Tâche(s) effectuée(s) :</label>
                                    <div class="controls controls-row tasks">
                                        <?php if(sizeof($workerToUpdate)=== 1) : ?>
                                            <select class="span2 typeTask mySelect" name="type_task" onchange="getId(this.value)">
                                                <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <?php foreach($workerToUpdate as $worker) :?>
                                                            <option value="<?= $typeTache['id']?>" <?php if($worker['type_task_id_1']=== $typeTache['id']) : ?> selected="selected" <?php endif; ?>><?= $typeTache['nom_type_tache']?></option>
                                                        <?php endforeach;?>
                                                    <?php endforeach;?>
                                            </select>
                                        <?php else : ?>
                                            <select class="span2 typeTask mySelect" name="type_task" onchange="getId(this.value)">
                                                <option>Catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                                <?php endforeach;?>
                                            </select>
                                        <?php endif; ?>
                                        <?php if(sizeof($workerToUpdate)=== 1) : ?>
                                            <select class="span2 mySelect task" name="tasks">
                                                <option>Tâche</option>
                                                <?php foreach($listTache as $tache) : ?>
                                                    <?php foreach($workerToUpdate as $worker) : ?>
                                                        <option value="<?= $tache['id']?>" <?php if($worker['task_id_1']=== $tache['id']) : ?> selected="selected" <?php endif; ?>><?= $tache['nom']?></option>
                                                    <?php endforeach ;?>
                                                <?php endforeach ;?>
                                            </select>
                                        <?php else : ?>
                                            <select class="span2 mySelect task" name="tasks">
                                                <option>Tâche</option>
                                            </select>
                                        <?php endif; ?>
                                        <?php if(sizeof($workerToUpdate)=== 1) : ?>
                                            <?php foreach($workerToUpdate as $worker): ?>
                                                <input type="text" class="span2" id="bat" name="bat" value="<?=$worker['bat_1']?>" placeholder="Batiment">
                                                <input type="text" class="span2" id="axe" name="axe" value="<?=$worker['axe_1']?>" placeholder="Axe">
                                                <input type="text" class="span1" id="et" name="et" value="<?=$worker['et_1']?>" placeholder="Etage">
                                                <input type="number" class="span1" id="ht" name="ht" value="<?=$worker['ht1']?>" placeholder="Hre">
                                            <?php endforeach ; ?>
                                        <?php else : ?>
                                            <input type="text" class="span2" id="bat" name="bat" value="" placeholder="Batiment">
                                            <input type="text" class="span2" id="axe" name="axe" value="" placeholder="Axe">
                                            <input type="text" class="span1" id="et" name="et" value="" placeholder="Etage">
                                            <input type="number" class="span1" id="ht" name="ht" value="" placeholder="Hre">
                                        <?php endif ; ?>
                                        <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                        <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls controls-row tasks">
                                        <?php if(sizeof($workerToUpdate)=== 1 ) : ?>
                                        <select class="span2 typeTask2 mySelect" name="type_task2" onchange="getId2(this.value)">
                                            <option>Catégorie</option>
                                            <?php foreach($listTypeTache as $typeTache) :?>
                                                <?php foreach($workerToUpdate as $worker) : ?>
                                                    <option value="<?= $typeTache['id']?>" <?php if($worker['type_task_id_2']=== $typeTache['id']) : ?> selected="selected" <?php endif; ?> ><?= $typeTache['nom_type_tache']?></option>
                                                <?php endforeach ; ?>
                                            <?php endforeach;?>
                                        </select>
                                        <?php else : ?>
                                            <select class="span2 typeTask2 mySelect" name="type_task2" onchange="getId2(this.value)">
                                                <option>Catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                                <?php endforeach;?>
                                            </select>
                                        <?php endif ; ?>
                                        <?php if(sizeof($workerToUpdate)=== 1 ) : ?>
                                            <select class="span2 mySelect task2" name="tasks2">
                                                <option>Tâche</option>
                                                <?php foreach($listTache as $tache) : ?>
                                                    <?php foreach($workerToUpdate as $worker) : ?>
                                                        <option value="<?= $worker['task_id_2'] ?>" <?php  if($worker['task_id_2'] === $tache['id']) : ?> selected="selected" <?php endif ; ?>><?= $tache['nom'] ?></option>
                                                    <?php endforeach ; ?>
                                                <?php endforeach ; ?>
                                            </select>
                                        <?php else : ?>
                                        <select class="span2 mySelect task2" name="tasks2">
                                            <option>Tâche</option>
                                        <?php endif; ?>
                                        <?php if(sizeof($workerToUpdate)===1) :?>
                                            <?php foreach($workerToUpdate as $worker) : ?>
                                                <input type="text" class="span2" id="bat2" name="bat2" value="<?= $worker['bat_2'] ?>" placeholder="Batiment">
                                                <input type="text" class="span2" id="axe2" name="axe2" value="<?= $worker['axe_2'] ?>" placeholder="Axe">
                                                <input type="text" class="span1" id="et2" name="et2" value="<?= $worker['et_2'] ?>" placeholder="Etage">
                                                <input type="number" class="span1" id="ht2" name="ht2" value="<?= $worker['ht2'] ?>" placeholder="Hre">
                                            <?php endforeach ; ?>
                                        <?php else : ?>
                                            <input type="text" class="span2" id="bat2" name="bat2" value="" placeholder="Batiment">
                                            <input type="text" class="span2" id="axe2" name="axe2" value="" placeholder="Axe">
                                            <input type="text" class="span1" id="et2" name="et2" value="" placeholder="Etage">
                                            <input type="number" class="span1" id="ht2" name="ht2" value="" placeholder="Hre">
                                        <?php endif ; ?>
                                        <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                        <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                    </div>
                                </div>
                                <div class="controls controls-row">
                                    <!--button id="addButton" type="button">Plus de tâches</button-->
                                    <div class=" span2 btn-block"></div>
                                    <a id="addButton" class="sAdd btn btn-success span2" title="" href="#"><i class="icon-plus"></i> Plus de tâches</a>
                                    <!--button  type="button">Moins de tâches</button-->
                                    <div class=" span2 btn-block"></div>
                                    <a id="minusButton" class="sAdd btn btn-danger danger span2" title="" href="#"><i class="icon-minus"></i> Moins de tâches</a>
                                    <div class=" span2 btn-block"></div>
                                </div>
                                <fieldset class="moreActions">
                                    <div class="control-group">
                                        <div class="controls controls-row tasks">
                                            <?php if(sizeof($workerToUpdate)===1) :?>
                                            <select class="span2 typeTask3 mySelect" name="type_task3" onchange="getId3(this.value)">
                                                <option>Catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <?php foreach($workerToUpdate as $worker) : ?>
                                                        <option value="<?= $typeTache['id']?>" <?php if($worker['type_task_id_3']===$typeTache['id']) : ?> selected="selected" <?php endif ;?>><?= $typeTache['nom_type_tache']?></option>
                                                    <?php endforeach ; ?>
                                                <?php endforeach;?>
                                            </select>
                                            <?php else : ?>
                                                <select class="span2 typeTask3 mySelect" name="type_task3" onchange="getId3(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php endif; ?>
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                            <select class="span2 mySelect task3" name="tasks3">
                                                <option>Tâche</option>
                                                <?php foreach($listTache as $tache) :?>
                                                    <?php foreach($workerToUpdate as $worker) :?>
                                                        <option value="<?= $tache['id']?>" <?php if($tache['id']=== $worker['task_id_3']) : ?> selected="selected" <?php endif; ?>><?= $tache['nom']?></option>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php else : ?>
                                                <select class="span2 mySelect task3" name="tasks3">
                                                    <option>Tâche</option>
                                                </select>
                                            <?php endif ; ?>
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <?php foreach($workerToUpdate as $worker) : ?>
                                                <input type="text" class="span2" id="bat3" name="bat3" value="<?= $worker['bat_3'] ?>" placeholder="Batiment">
                                                <input type="text" class="span2" id="axe3" name="axe3" value="<?= $worker['axe_3'] ?>" placeholder="Axe">
                                                <input type="text" class="span1" id="et3" name="et3" value="<?= $worker['et_3'] ?>" placeholder="Etage">
                                                <input type="number" class="span1" id="ht3" name="ht3" value="<?= $worker['ht3'] ?>" placeholder="Hre">
                                           <?php endforeach ;?>
                                            <?php else : ?>
                                                <input type="text" class="span2" id="bat3" name="bat3" value="" placeholder="Batiment">
                                                <input type="text" class="span2" id="axe3" name="axe3" value="" placeholder="Axe">
                                                <input type="text" class="span1" id="et3" name="et3" value="" placeholder="Etage">
                                                <input type="number" class="span1" id="ht3" name="ht3" value="" placeholder="Hre">
                                            <?php endif ; ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls controls-row tasks">
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <select class="span2 typeTask4 mySelect" name="type_task4" onchange="getId4(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <?php foreach($workerToUpdate as $worker) : ?>
                                                            <option value="<?= $typeTache['id']?>" <?php if($typeTache['id']=== $worker['type_task_id_4']): ?> selected="selected" <?php endif;?>><?= $typeTache['nom_type_tache']?></option>
                                                        <?php endforeach;?>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php else : ?>
                                                <select class="span2 typeTask4 mySelect" name="type_task4" onchange="getId4(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php endif; ?>
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <select class="span2 mySelect task4" name="tasks4">
                                                    <option>Tâche</option>
                                                    <?php foreach($listTache as $tache) :?>
                                                        <?php foreach($workerToUpdate as $worker) : ?>
                                                            <option value="<?= $tache['id']?>" <?php if($tache['id']===$worker['task_id_4']) :?> selected="selected" <?php endif ; ?>><?= $tache['nom']?></option>
                                                        <?php endforeach ; ?>
                                                    <?php endforeach ; ?>
                                                </select>
                                            <?php else : ?>
                                                <select class="span2 mySelect task4" name="tasks4">
                                                    <option>Tâche</option>
                                                </select>
                                            <?php endif; ?>
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <?php foreach($workerToUpdate as $worker) : ?>
                                                    <input type="text" class="span2" id="bat4" name="bat4" value="<?= $worker['bat_4'] ?>" placeholder="Batiment">
                                                    <input type="text" class="span2" id="axe4" name="axe4" value="<?= $worker['axe_4'] ?>" placeholder="Axe">
                                                    <input type="text" class="span1" id="et4" name="et4" value="<?= $worker['et_4'] ?>" placeholder="Etage">
                                                    <input type="number" class="span1" id="ht4" name="ht4" value="<?= $worker['ht4'] ?>" placeholder="Hre">
                                                    <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                    <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                                <?php endforeach ; ?>
                                            <?php else : ?>
                                                <input type="text" class="span2" id="bat4" name="bat4" value="" placeholder="Batiment">
                                                <input type="text" class="span2" id="axe4" name="axe4" value="" placeholder="Axe">
                                                <input type="text" class="span1" id="et4" name="et4" value="" placeholder="Etage">
                                                <input type="number" class="span1" id="ht4" name="ht4" value="" placeholder="Hre">
                                                <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls controls-row tasks">
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                            <select class="span2 typeTask5 mySelect" name="type_task5" onchange="getId5(this.value)">
                                                <option>Catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <?php foreach($workerToUpdate as $worker) : ?>
                                                        <option value="<?= $typeTache['id']?>" <?php if($typeTache['id']=== $worker['type_task_id_5']): ?> selected="selected" <?php endif;?>><?= $typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                <?php endforeach;?>
                                            </select>
                                            <?php else : ?>
                                                <select class="span2 typeTask5 mySelect" name="type_task5" onchange="getId5(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php endif; ?>
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                            <select class="span2 mySelect task5" name="tasks5">
                                                <option>Tâche</option>
                                                <?php foreach($listTache as $tache) :?>
                                                    <?php foreach($workerToUpdate as $worker) : ?>
                                                        <option value="<?= $tache['id']?>" <?php if($tache['id']===$worker['task_id_5']) :?> selected="selected" <?php endif ; ?>><?= $tache['nom']?></option>
                                                    <?php endforeach ; ?>
                                                <?php endforeach ; ?>
                                            </select>
                                            <?php else : ?>
                                                <select class="span2 mySelect task5" name="tasks5">
                                                    <option>Tâche</option>
                                                </select>
                                            <?php endif; ?>
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <?php foreach($workerToUpdate as $worker) : ?>
                                                    <input type="text" class="span2" id="bat5" name="bat5" value="<?= $worker['bat_5'] ?>" placeholder="Batiment">
                                                    <input type="text" class="span2" id="axe5" name="axe5" value="<?= $worker['axe_5'] ?>" placeholder="Axe">
                                                    <input type="text" class="span1" id="et5" name="et5" value="<?= $worker['et_5'] ?>" placeholder="Etage">
                                                    <input type="number" class="span1" id="ht5" name="ht5" value="<?= $worker['ht5'] ?>" placeholder="Hre">
                                                    <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                    <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                                <?php endforeach ; ?>
                                            <?php else : ?>
                                                <input type="text" class="span2" id="bat5" name="bat5" value="" placeholder="Batiment">
                                                <input type="text" class="span2" id="axe5" name="axe5" value="" placeholder="Axe">
                                                <input type="text" class="span1" id="et5" name="et5" value="" placeholder="Etage">
                                                <input type="number" class="span1" id="ht5" name="ht5" value="" placeholder="Hre">
                                                <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls controls-row tasks">
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <select class="span2 typeTask6 mySelect" name="type_task6" onchange="getId6(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <?php foreach($workerToUpdate as $worker) :?>
                                                            <option value="<?= $typeTache['id']?>" <?php if($typeTache['id'] === $worker['type_task_id_6']) : ?> selected="selected" <?php endif;?>><?= $typeTache['nom_type_tache']?></option>
                                                        <?php endforeach;?>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php else : ?>
                                                <select class="span2 typeTask6 mySelect" name="type_task6" onchange="getId6(this.value)">
                                                    <option>Catégorie</option>
                                                    <?php foreach($listTypeTache as $typeTache) :?>
                                                        <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php endif ; ?>
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <select class="span2 mySelect task6" name="tasks6">
                                                    <option>Tâche</option>
                                                <?php foreach($listTache as $tache) :?>
                                                    <?php foreach($workerToUpdate as $worker) :?>
                                                        <option value="<?=$tache['id'] ?>"  <?php if($tache['id']=== $worker['task_id_6']) : ?> selected="selected" <?php endif ; ?>><?= $tache['nom'] ?></option>
                                                    <?php endforeach;?>
                                                <?php endforeach;?>
                                                </select>
                                            <?php else : ?>
                                                <select class="span2 mySelect task6" name="tasks6">
                                                    <option>Tâche</option>
                                                </select>
                                            <?php endif ; ?>
                                            <?php if(sizeof($workerToUpdate)===1) : ?>
                                                <?php foreach($workerToUpdate as $worker) :?>
                                                    <input type="text" class="span2" id="bat6" name="bat6" value="<?= $worker['bat_6'] ?>" placeholder="Batiment">
                                                    <input type="text" class="span2" id="axe6" name="axe6" value="<?= $worker['axe_6'] ?>" placeholder="Axe">
                                                    <input type="text" class="span1" id="et6" name="et6" value="<?= $worker['et_6'] ?>" placeholder="Etage">
                                                    <input type="number" class="span1" id="ht6" name="ht6" value="<?= $worker['ht6'] ?>" placeholder="Hre">
                                                    <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                    <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                                <?php endforeach;?>
                                            <?php else : ?>
                                                <input type="text" class="span2" id="bat6" name="bat6" value="" placeholder="Batiment">
                                                <input type="text" class="span2" id="axe6" name="axe6" value="" placeholder="Axe">
                                                <input type="text" class="span1" id="et6" name="et6" value="" placeholder="Etage">
                                                <input type="number" class="span1" id="ht6" name="ht6" value="" placeholder="Hre">
                                                <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                                <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                            <?php endif ; ?>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="">Travaux pénibles</label>
                                    <div class="controls">
                                        <?php if(sizeof($workerToUpdate)===1) : ?>
                                            <?php foreach($workerToUpdate as $worker) :?>
                                                <input type="number" value="<?= $worker['hins'] ?>" name="hins" class="span1">
                                            <?php endforeach;?>
                                        <?php else : ?>
                                            <input type="number" value="" name="hins" class="span1">
                                        <?php endif ; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label  class="control-label" for="">Transport du personel "T"</label>
                                    <div class="controls">
                                        <?php if(sizeof($workerToUpdate)===1) : ?>
                                            <?php foreach($workerToUpdate as $worker) :?>
                                                <input  type="checkbox"  name="dpl_pers"<?php if($worker['dpl_pers'] === 1) : ?> checked <?php endif ; ?>>
                                            <?php endforeach;?>
                                        <?php else : ?>
                                            <input name="dpl_pers" type="checkbox" >
                                        <?php endif ; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="">Indemnités de déplacement (KM)</label>
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