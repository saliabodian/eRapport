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
                            <form method="post" class="form-horizontal">
                                <input type="hidden" name="matriculeList" value="<?= $workerToUpdate ?>"/>
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
                                        <input type="number" class="span2" name="htot" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Absence :</label>
                                    <div class="controls">
                                        <select name="abs">
                                            <option>Maladie (M)</option>
                                            <option>Accident (A)</option>
                                            <option>Congé (C)</option>
                                            <option>Absence Excusée (EX)</option>
                                            <option>Formation (FOR)</option>
                                            <option>Intempéries (INT)</option>
                                            <option>Congé Extraordinaire (CE)</option>
                                            <option>Absence non Excusée (ABS)</option>
                                            <option>Congé Syndical (CS)</option>
                                            <option>Visite Médicale STI (STI)</option>
                                            <option>Travaux Autre Chantier (TAC)</option>
                                        </select>
                                    </div>
                                    <label class="control-label">Heures absence :</label>
                                    <div class="controls">
                                        <input type="number" class="span2" name="habs" />
                                    </div>
                                </div>
                                <!-- Ajout des tâches de manières dynamiques avec jQuery-->
                                <div class="control-group">
                                    <label class="control-label">Tâche(s) effectuée(s) :</label>
                                    <div class="controls controls-row tasks">
                                        <select class="span3 typeTask mySelect" name="type_task" >
                                            <option>Choisir une catégorie</option>
                                            <?php foreach($listTypeTache as $typeTache) :?>
                                                <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <select class="span3 mySelect task" name="tasks">
                                            <option selected="selected">Choisir une tâche</option>
                                        </select>

                                        <input type="text" class="span2" id="batiment" name="batiment" value="" placeholder="Batiment">
                                        <input type="text" class="span2" id="axe" name="axe" value="" placeholder="Axe">
                                        <input type="text" class="span1" id="etage" name="etage" value="" placeholder="Etage">
                                        <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                        <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls controls-row tasks">
                                        <select class="span3 typeTask2 mySelect" name="type_task2" >
                                            <option>Choisir une catégorie</option>
                                            <?php foreach($listTypeTache as $typeTache) :?>
                                                <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <select class="span3 mySelect task2" name="tasks2">
                                            <option selected="selected">Choisir une tâche</option>
                                        </select>

                                        <input type="text" class="span2" id="batiment" name="batiment2" value="" placeholder="Batiment">
                                        <input type="text" class="span2" id="axe" name="axe2" value="" placeholder="Axe">
                                        <input type="text" class="span1" id="etage" name="etage2" value="" placeholder="Etage">
                                        <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                        <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                    </div>
                                </div>
                                <!--div class="controls controls-row"-->
                                    <!--button id="addButton" type="button">Plus de tâches</button-->
                                    <!--a id="addButton" class="sAdd btn btn-success" title="" href="#"><i class="icon-plus"></i> Plus de tâches</a-->
                                    <!--button  type="button">Moins de tâches</button-->
                                    <!--a id="minusButton" class="sAdd btn btn-danger danger" title="" href="#"><i class="icon-minus"></i> Moins de tâches</a-->
                                <!--/div-->
                                <fieldset class="moreActions">
                                    <div class="control-group">
                                        <div class="controls controls-row tasks">
                                            <select class="span3 typeTask3 mySelect" name="type_task3" >
                                                <option>Choisir une catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <select class="span3 mySelect task3" name="tasks3">
                                                <option selected="selected">Choisir une tâche</option>
                                            </select>

                                            <input type="text" class="span2" id="batiment" name="batiment3" value="" placeholder="Batiment">
                                            <input type="text" class="span2" id="axe" name="axe3" value="" placeholder="Axe">
                                            <input type="text" class="span1" id="etage" name="etage3" value="" placeholder="Etage">
                                            <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                            <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls controls-row tasks">
                                            <select class="span3 typeTask4 mySelect" name="type_task4" >
                                                <option>Choisir une catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <select class="span3 mySelect task4" name="tasks4">
                                                <option selected="selected">Choisir une tâche</option>
                                            </select>

                                            <input type="text" class="span2" id="batiment" name="batiment4" value="" placeholder="Batiment">
                                            <input type="text" class="span2" id="axe" name="axe4" value="" placeholder="Axe">
                                            <input type="text" class="span1" id="etage" name="etage4" value="" placeholder="Etage">
                                            <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                            <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls controls-row tasks">
                                            <select class="span3 typeTask5 mySelect" name="type_task5" >
                                                <option>Choisir une catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <select class="span3 mySelect task5" name="tasks5">
                                                <option selected="selected">Choisir une tâche</option>
                                            </select>

                                            <input type="text" class="span2" id="batiment" name="batiment5" value="" placeholder="Batiment">
                                            <input type="text" class="span2" id="axe" name="axe5" value="" placeholder="Axe">
                                            <input type="text" class="span1" id="etage" name="etage5" value="" placeholder="Etage">
                                            <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                            <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls controls-row tasks">
                                            <select class="span3 typeTask6 mySelect" name="type_task6" >
                                                <option>Choisir une catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <select class="span3 mySelect task6" name="tasks6">
                                                <option selected="selected">Choisir une tâche</option>
                                            </select>

                                            <input type="text" class="span2" id="batiment" name="batiment6" value="" placeholder="Batiment">
                                            <input type="text" class="span2" id="axe" name="axe6" value="" placeholder="Axe">
                                            <input type="text" class="span1" id="etage" name="etage6" value="" placeholder="Etage">
                                            <!--a Gestion dynamique de l'ajout d'une tache mis en suspend</a-->
                                            <!--a class="sAdd btn btn-success add-more" title="" href="#"><i class="icon-plus"></i></a-->
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- Ligne 74 à 95, Gestion dynamique de l'ajout d'une tache mis en suspend-->
                                <div class="copy hide">
                                    <div class="control-group addRow">
                                        <label class="control-label"></label>
                                        <div class="controls controls-row">
                                            <select class="span3 typeTask mySelect" name="type_task[]" >
                                                <option>Choisir une catégorie</option>
                                                <?php foreach($listTypeTache as $typeTache) :?>
                                                    <option value="<?= $typeTache['id']?>"><?= $typeTache['nom_type_tache']?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <select class="span3 mySelect task" name="tasks[]">
                                                <option selected="selected">Choisir une tâche</option>
                                            </select>

                                            <input type="text" class="span2" id="batiment" name="batiment[]" value="" placeholder="Batiment">
                                            <input type="text" class="span2" id="axe" name="axe[]" value="" placeholder="Axe">
                                            <input type="text" class="span1" id="etage" name="etage[]" value="" placeholder="Etage">
                                            <a class="sAdd btn btn-danger remove" title="" href="#"><i class="icon-minus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin ajout dynamique des tâches de manières dynamiques avec jQuery-->
                                <div class="control-group">
                                    <label class="control-label" for="">Travaux pénibles</label>
                                    <div class="controls">
                                        <input type="number" value="" name="hins" class="span1">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label  class="control-label" for="">Transport du personel "T"</label>
                                    <div class="controls">
                                        <input value="" name="dpl_pers" type="checkbox" >
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="">Indemnités de déplacement (KM)</label>
                                    <div class="controls">
                                        <input type="number" value="" name="km" class="span1">
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