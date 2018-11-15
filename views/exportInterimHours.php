<div id="content">
    <div id="content-header">
        <hr>
        <h1>Export des "T"</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Période d'export</h5>
                    </div>
                    <?php include 'alert.php'; ?>
                    <div class="widget-content nopadding">
                        <form action="" method="post" class="form-horizontal">
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
            </div>
        </div>
        <hr>
        <?php ?>
        <div class="row-fluid">
            <div class="span12">
            </div>
        </div>
        <?php  ?>
    </div>
</div>