<div id="content">
    <div id="content-header">
        <hr>
        <h1>Export de Données RH</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="col span6">
                    <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Export dest "T" <strong>- Ouvriers CDCL</strong></h5>
                    </div>
                    <?php
                        if(isset($_POST['T']) && $_POST['T'] === '1'){
                            include 'alert.php';
                        }

                    ?>
                    <div class="widget-content nopadding">
                        <form action="" method="post" class="form-horizontal">
                            <input id="T" name="T" type="hidden" value="<?= true ?>"/>
                            <div class="control-group">
                                <label for="date_deb" class="control-label">
                                    Date début :
                                </label>
                                <div class="controls">
                                    <input name="date_deb" autocomplete="off" class="datepicker" value="<?= isset($dateDebut)? $dateDebut : '' ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_fin" class="control-label">
                                    Date fin :
                                </label>
                                <div class="controls">
                                    <input name="date_fin" autocomplete="off" class="datepicker" value="<?= isset($dateFin)? $dateFin : '' ?>"/>
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
                    <?php if(!empty($ExportTxtDir)){ ?>
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
                            <h5>Liste des exports des "T"</h5>
                        </div>
                        <div class="widget-content">
                            <div class="todo">
                                <ul>
                                    <?php foreach($ExportTxtDir as $exp) : ?>
                                        <li class="clearfix">
                                            <div class="txt"><?= strtoupper($exp) ?><span class="by label"></span></div>
                                            <div class="pull-right">
                                                <a class="tip" href="ExportTxt\<?= $exp ?>" download><i class="icon-print"></i></a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="col span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Export des Heures <strong>- Intérimaires </strong></h5>
                        </div>
                        <?php
                            if(isset($_POST['H']) && $_POST['H'] === '1'){
                                include 'alert.php';
                            }
                        ?>
                        <div class="widget-content nopadding">
                            <form action="" method="post" class="form-horizontal">
                                <input name="H" id="H" type="hidden" value="<?= true ?>"/>
                                <div class="control-group">
                                    <label for="date_deb" class="control-label">
                                        Date début :
                                    </label>
                                    <div class="controls">
                                        <input name="date_deb" autocomplete="off" class="datepicker" value="<?= isset($dateDebut)? $dateDebut : '' ?>"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="date_fin" class="control-label">
                                        Date fin :
                                    </label>
                                    <div class="controls">
                                        <input name="date_fin" autocomplete="off" class="datepicker" value="<?= isset($dateFin)? $dateFin : '' ?>"/>
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
                    <?php if(!empty($ExportHoursDir)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
                                <h5>Liste des exports des heures Intérimaires</h5>
                            </div>
                            <div class="widget-content">
                                <div class="todo">
                                    <ul>
                                        <?php foreach($ExportHoursDir as $exp) : ?>
                                            <li class="clearfix">
                                                <div class="txt"><?= strtoupper($exp) ?><span class="by label"></span></div>
                                                <div class="pull-right">
                                                    <a class="tip" href="ExportHours\<?= $exp ?>" download><i class="icon-print"></i></a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="col span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Export des Kilométres</strong></h5>
                        </div>
                        <?php
                            if(isset($_POST['KM']) && $_POST['KM'] === '1'){
                                include 'alert.php';
                            }
                        ?>
                        <div class="widget-content nopadding">
                            <form action="" method="post" class="form-horizontal">
                                <input id="KM" name="KM" type="hidden" value="<?= true ?>"/>
                                <div class="control-group">
                                    <label for="date_deb" class="control-label">
                                        Date début :
                                    </label>
                                    <div class="controls">
                                        <input name="date_deb" autocomplete="off" class="datepicker" value="<?= isset($dateDebut)? $dateDebut : '' ?>"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="date_fin" class="control-label">
                                        Date fin :
                                    </label>
                                    <div class="controls">
                                        <input name="date_fin" autocomplete="off" class="datepicker" value="<?= isset($dateFin)? $dateFin : '' ?>"/>
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
                    <?php if(!empty($ExportKmDir)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
                                <h5>Liste des exports des Kilométres</h5>
                            </div>
                            <div class="widget-content">
                                <div class="todo">
                                    <ul>
                                        <?php foreach($ExportKmDir as $exp) : ?>
                                            <li class="clearfix">
                                                <div class="txt"><?= strtoupper($exp) ?><span class="by label"></span></div>
                                                <div class="pull-right">
                                                    <a class="tip" href="ExportKm\<?= $exp ?>" download><i class="icon-print"></i></a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Export des Heures de travaux pénibles</h5>
                        </div>
                        <?php
                        if(isset($_POST['TPEN']) && $_POST['TPEN'] === '1'){
                            include 'alert.php';
                        }
                        ?>
                        <div class="widget-content nopadding">
                            <form action="" method="post" class="form-horizontal">
                                <input name="TPEN" id="TPEN" type="hidden" value="<?= true ?>"/>
                                <div class="control-group">
                                    <label for="date_deb" class="control-label">
                                        Date début :
                                    </label>
                                    <div class="controls">
                                        <input name="date_deb" autocomplete="off" class="datepicker" value="<?= isset($dateDebut)? $dateDebut : '' ?>"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="date_fin" class="control-label">
                                        Date fin :
                                    </label>
                                    <div class="controls">
                                        <input name="date_fin" autocomplete="off" class="datepicker" value="<?= isset($dateFin)? $dateFin : '' ?>"/>
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
                    <?php if(!empty($ExportTpenDir)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
                                <h5>Liste des exports des Heures de travaux pénibles</h5>
                            </div>
                            <div class="widget-content">
                                <div class="todo">
                                    <ul>
                                        <?php foreach($ExportTpenDir as $exp) : ?>
                                            <li class="clearfix">
                                                <div class="txt"><?= strtoupper($exp) ?><span class="by label"></span></div>
                                                <div class="pull-right">
                                                    <a class="tip" href="ExportTpen\<?= $exp ?>" download><i class="icon-print"></i></a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>