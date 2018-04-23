<div id="content">
    <div id="content-header">
        <hr>
        <h1>Mobilité des intérimaires sur chantier</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Affectations Temporaires des Intérimaires sur chantier</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form action="" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label for="date_deb" class="control-label">Date début <span>*</span> :</label>
                                <div class="controls">
                                    <input name="date_deb" class="datepicker" value=""/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="date_fin" class="control-label">
                                    Date fin <span>*</span> :
                                </label>
                                <div class="controls">
                                    <input name="date_fin" class="datepicker" value=""/>
                                </div>
                            </div>
                            <div class="control-group span12">
                                <label class="control-label">Liste des chantiers</label>
                                <div class="controls">
                                    <?php foreach($chantiers as $chantier) : ?>
                                    <label class="span4">
                                        <input type="radio" name="chantier_id" value="<?=$chantier['id']?>"/>
                                        <?= $chantier['code'].' - '.$chantier['nom'] ?></label>
                                    <label>
                                    <?php endforeach ; ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <select multiple="multiple" size="25" name="duallistbox_demo1[]">
                                        <?php foreach($interimaires as $interimaire) : ?>
                                            <option value="<?= isset($interimaire['id']) ? $interimaire['id'] : ''  ?>" ><?= isset($interimaire['id']) ? ($interimaire['matricule'].' - '.$interimaire['firstname'].' '.$interimaire['lastname']) : '' ?></option>
                                        <?php endforeach; ?>
                                        <?php foreach($isSelected as $id => $selected) : ?>
                                            <option value="<?=intval($id) ?>" selected="selected"><?= $selected ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span4 btn-block"></div>
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Affecter</button>
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