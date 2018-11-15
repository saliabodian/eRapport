<div id="content">
    <div id="content-header">
        <hr>
        <h1>Affectation des intérimaires</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Choix du chantier & de la semaine</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="get" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Liste des chantiers</label>
                                <div class="controls">
                                    <?php $selectChantier->displayHTML(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Semaine du</label>
                                <div class="controls">
                                    <input type="text" autocomplete="off" name="date_deb" class="btn datepicker btn-block span11 " value=""/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success span4" value="">Rechercher</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Choix du chantier & du jour</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Liste des chantiers</label>
                                <div class="controls">
                                    <?php $selectChantier->displayHTML(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Date</label>
                                <div class="controls">
                                    <input type="text" name="date_deb" autocomplete="off" class="btn datepicker btn-block span11 " value=""/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success span4" value="">Rechercher</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <?php if(!empty($listInterimaires)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Intérimaires affectés</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Intérimaires</th>
                                        <th>Chantier</th>
                                        <th>Semaine</th>
                                        <th>Jour</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($listInterimaires as $interimaireAffectes ) : ?>
                                        <tr class="odd gradeX">
                                            <td><?= $interimaireAffectes['matricule'].' - '.$interimaireAffectes['lastname'].' '.$interimaireAffectes['firstname'] ?></td>
                                            <td style="text-align: center"><?= $interimaireAffectes['nom'] ?></td>
                                            <td style="text-align: center"><?= $interimaireAffectes['woy'] ?></td>
                                            <td style="text-align: center"><?= date('l', strtotime($interimaireAffectes['doy'])).', '.date('d-m-Y', strtotime($interimaireAffectes['doy'])) ?></td>
                                            <td>
                                                <a href="changeAffectation.php?row_id=<?= $interimaireAffectes['int_has_cht_id']?>&date_debut=<?= $interimaireAffectes['date_debut'] ?>&date_fin=<?= $interimaireAffectes['date_fin'] ?>&weekly_search=<?= isset($interimaireAffectes['weekly_search'])? $interimaireAffectes['weekly_search'] : '' ?>&dayly_search=<?= isset($interimaireAffectes['dayly_search'])? $interimaireAffectes['dayly_search'] : '' ?>&chantier_id=<?= $interimaireAffectes['chantier_id']?>&maj=true"  class="btn btn-warning  btn-block">Modifier</a>
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