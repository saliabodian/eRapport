<div id="content">
    <div id="content-header">
        <hr>
        <h1>Désactivation des intérimaires</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Liste des Intérimaires actifs</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form action="" method="post" class="form-horizontal">
                            <div class="control-group span12">
                                <div class="controls">
                                    <?php foreach($interimaires as $interimaire) : ?>
                                    <label class="span4">
                                        <input type="checkbox" name="interimaire_id[]" value="<?=$interimaire['id']?>"/>
                                        <?= $interimaire['matricule'].' - '.$interimaire['firstname'].' '.$interimaire['lastname'] ?></label>
                                    <label>
                                        <?php endforeach ; ?>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span4 btn-block"></div>
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Désactiver</button>
                                </div>
                                <div class=" span4 btn-block"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>