<div id="content">
    <div id="content-header">
        <hr>
        <h1>Affectation des intérimaires</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Liste des intérmaires à affecter</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form action="" method="post" class="form-horizontal" id="demoform">
                            <input type="hidden" value="<?=$_GET['chantier_id']?>" name="chantier_id_to_treat">
                            <input type="hidden" value="<?=$selectedWeek?>" name="week">
                            <div class="control-group">
                                <label class="control-label span3 m-wrap">Chantier Choisi</label>
                                <div class="controls span3 m-wrap">
                                    <input value="<?=$nomChantierChoisi?>"  disabled>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label span3 m-wrap">Numéro de Semaine </label>
                                <div class="controls span3 m-wrap">
                                    <input value="<?=$selectedWeek?>"  disabled>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <select multiple="multiple" size="25" name="duallistbox_demo1[]">
                                        <?php foreach($isNotSelected as $id => $selectable) : ?>
                                            <option value="<?=intval($id) ?>" ><?= $selectable ?></option>
                                        <?php endforeach; ?>
                                        <?php foreach($isSelected as $id => $selected) : ?>
                                            <option value="<?=intval($id) ?>" selected="selected"><?= $selected ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class=" span2 btn-block"></div>
                                <div class="span4">
                                    <button type="submit" class="btn btn-success btn-block" >Enregistrer</button>
                                </div>
                                <div class="span4">
                                    <a href="?delete=<? ?>" class="btn btn-warning  btn-block<?php  ?> disabled" role="button" aria-disabled="true">Supprimer</a>
                                </div>
                                <div class=" span2 btn-block"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>