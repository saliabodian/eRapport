<div id="content">
    <div id="content-header">
        <hr>
        <h1>Génération de rapport journalier</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Sélection du chantier</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="get" class="form-horizontal">
                            <div class="controls-row">
                                <label class="control-label span5 m-wrap">Chantier(s) affecté(s) à l'utilisateur</label>
                                <div class="controls span4 m-wrap">
                                    <?php $selectChantier->displayHTML(); ?>
                                </div>
                                <div class="controls span3 m-wrap">
                                    <input type="submit" class="btn btn-success btn-block" value="Sélectionner" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Choix du chef d'équipe et de la date</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form action="" method="post" class="form-horizontal">
                            <input type="hidden" name="chantier_id" value="<?= $chantierObject->getId() ?>">
                            <div class="control-group">
                                <label for="chef_dequipe" class="control-label">Chef d'équipe :</label>
                                <div class="controls mySelect">
                                    <?php $selectChefDEquipe->displayHTML(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_fin" class="control-label">Date de génération:</label>
                                <div class="controls">
                                    <input name="date_gen" class="datepicker" value=""/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span4 btn-block"></div>
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Générer</button>
                                </div>

                                <div class=" span4 btn-block"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <?php if(!empty($rapportGeneratedList)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Liste des rapports générés</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Noyau</th>
                                        <th>Chantier</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($rapportGeneratedList as $rapportGenerated ) : ?>
                                        <tr class="odd gradeX">
                                            <td><?= $rapportGenerated['date'] ?></td>
                                            <td style="text-align: center"><?= $rapportGenerated['username'].' - '.$rapportGenerated['lastname'].' '.$rapportGenerated['firstname'] ?></td>
                                            <td style="text-align: center"><?= $rapportGenerated['code'].''.$rapportGenerated['nom'] ?></td>
                                            <td>
                                                <a href="erapportShow.php?chef_dequipe_id=<?= $rapportGenerated['user_id']?>&chef_dequipe_matricule=<?= $rapportGenerated['username']?>&date_generation=<?= $rapportGenerated['date']?>&chantier_id=<?= $rapportGenerated['chantier_id']?>&chantier_id=<?= $rapportGenerated['code']?>"  class="btn btn-warning  btn-block">Consulter</a>
                                            </td>
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
    </div>
</div>