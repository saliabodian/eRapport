<div id="content">
    <div id="content-header">
        <hr>
        <h1>Impression des E-rapports par lot</h1>
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
                                    Chantier  :
                                </label>
                                <div class="controls mySelect">
                                    <select class="chantier_id" name="chantier_id" onchange="getChantierId2(this.value)">
                                        <option value="<?= isset($_POST['chantier_id'])? $_POST['chantier_id'] : '' ?>">choose</option>
                                        <?php foreach($listChantier as $chantier) :?>
                                            <option value="<?= $chantier['id']?>"> <?= $chantier['code'].' '.$chantier['nom']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="matricule" class="control-label">
                                    Chef d'équipe :
                                </label>
                                <div class="controls mySelect">
                                    <select class="mySelect chef_dequipe select2-container" name="chef_dequipe">
                                        <option value="">choose</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_deb" class="control-label">
                                    Date début :
                                </label>
                                <div class="controls">
                                    <input name="date_deb" class="datepicker" value="<?= isset($dateDeb)? $dateDeb : '' ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_fin" class="control-label">
                                    Date fin :
                                </label>
                                <div class="controls">
                                    <input name="date_fin" class="datepicker" value="<?= isset($dateFin)? $dateFin : '' ?>"/>
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
                    <?php if(!empty($rapportValidatedList)){ ?>
                        <input class="span12" id="myInput" type="text" placeholder="Rechercher..">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Liste des rapports à imprimer (<?= isset($nb)? $nb : '' ?>)</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped" id="myTable">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Noyau</th>
                                        <th>Chantier</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($rapportValidatedList as $rapportValidated ) : ?>
                                        <tr class="odd gradeX">
                                            <td><?= date('d-m-Y',strtotime($rapportValidated['date'])) ?></td>
                                            <td style="text-align: center"><?= $rapportValidated['username'].' - '.$rapportValidated['lastname'].' '.$rapportValidated['firstname'] ?></td>
                                            <td style="text-align: center"><?= $rapportValidated['code'].' - '.$rapportValidated['nom'] ?></td>
                                        </tr>
                                    <?php  endforeach;  ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <hr>
        <?php if(!empty($rapportValidatedList)){ ?>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div>
                        <div class="widget-content nopadding">
                            <form action="" method="get" class="form-horizontal">
                                <div class="form-actions">
                                    <input name="nb" id="nb" type="hidden" value="<?= $nb ?>">
                                    <?php for ($i=0; $i<$nb ; $i++){ ?>
                                        <input type="hidden" name="id_rapport_<?= $i?>" id="id_rapport_<?= $i?>" value="<?= $idRapport[$i]?>">
                                        <input type="hidden" name="date_<?= $i?>" id="date_<?= $i?>" value="<?= $date[$i]?>">
                                        <input type="hidden" name="rapport_type_<?= $i?>" id="rapport_type_<?= $i?>" value="<?= $rapportType[$i]?>">
                                        <input type="hidden" name="user_id_<?= $i?>" id="user_id_<?= $i?>" value="<?= $userId[$i]?>">
                                        <input type="hidden" name="username_<?= $i?>" id="username_<?= $i?>" value="<?= $username[$i]?>">
                                        <input type="hidden" name="firstname_<?= $i?>" id="firstname_<?= $i?>" value="<?= $firstname[$i]?>">
                                        <input type="hidden" name="lastname_<?= $i?>" id="lastname_<?= $i?>" value="<?= $lastname[$i]?>">
                                        <input type="hidden" name="chantier_id_<?= $i?>" id="chantier_id_<?= $i?>" value="<?= $chantierId[$i]?>">
                                        <input type="hidden" name="code_<?= $i?>" id="code_<?= $i?>" value="<?= $code[$i]?>">
                                        <input type="hidden" name="nom_<?= $i?>" id="nom_<?= $i?>" value="<?= $nom[$i]?>">
                                        <input type="hidden" name="submitted_<?= $i?>" id="submitted_<?= $i?>" value="<?= $submitted[$i]?>">
                                        <input type="hidden" name="validated_<?= $i?>" id="validated_<?= $i?>" value="<?= $validated[$i]?>">
                                        <input type="hidden" name="generated_by_<?= $i?>" id="generated_by_<?= $i?>" value="<?= $generatedBy[$i]?>">
                                    <?php } ?>
                                    <div class="span3">
                                        <input type="hidden" class="btn " disabled>
                                    </div>
                                    <a href="#" onclick="printErapport()"  class="btn btn-inverse span6" style="align-content: center">Imprimer les rapports</a>
                                    <div class="span3">
                                        <input type="hidden" class="btn " disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>