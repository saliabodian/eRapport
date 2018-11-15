<div id="content">
    <div id="content-header">
        <hr>
        <h1>Activation / Désactivation des intempéries</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="col span6">
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <input class="span12" id="myInputChantierWithoutItp" type="text" placeholder=" Filtrer les chantiers ...">
                        <?php if(!empty($chantierWithoutItp)){ ?>
                            <div class="widget-box">
                                <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                    <h5>Chantiers Sans Intempéries</h5>
                                </div>
                                <div class="widget-content">
                                    <form method="post" action="chantierEnIntemperie.php">
                                        <table class="table table-bordered with-check">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" name="check_all" id="check_all" value=""/></th>
                                                    <th>Numéro de chantier</th>
                                                    <th>Nom Chantier</th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTableChantierWithoutItp">
                                                <?php foreach ($chantierWithoutItp as $chantier ) : ?>
                                                    <tr>
                                                        <td><input type="checkbox" name="siteToSet[]" class="checkbox checkbox_noyau" value="<?= $chantier['id'] ?>" /></td>
                                                        <td><?= $chantier['code'] ?></td>
                                                        <td ><?= $chantier['nom'] ?></td>
                                                    </tr>
                                                <?php  endforeach;  ?>
                                            </tbody>
                                        </table>
                                        <hr>
                                            <input class="span4 btn btn-success" type="submit" value="Activer les intempéries">
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col span6">
                    <?php if(!empty($chantierWithItp)){ ?>
                        <div class="widget-content nopadding">
                            <?php include 'alert.php'; ?>
                            <input class="span12" id="myInputChantierWithItp" type="text" placeholder=" Filtrer les chantiers ...">
                            <div class="widget-box">
                                <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                    <h5>Chantiers En Intempéries</h5>
                                </div>
                                <div class="widget-content">
                                    <form method="post" action="chantierEnIntemperie.php">
                                        <table class="table table-bordered with-check">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" name="check_all_site" id="check_all_site" value=""/></th>
                                                <th>Numéro de chantier</th>
                                                <th>Nom Chantier</th>
                                            </tr>
                                            </thead>
                                            <tbody id="myTableChantierWithItp">
                                            <?php foreach ($chantierWithItp as $chantier ) : ?>
                                                <tr>
                                                    <td><input type="checkbox" name="siteToUnset[]" class="checkbox checkbox_site" value="<?= $chantier['id'] ?>" /></td>
                                                    <td><?= $chantier['code'] ?></td>
                                                    <td ><?= $chantier['nom'] ?></td>
                                                </tr>
                                            <?php  endforeach;  ?>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <input class="span4 btn btn-success" type="submit" value="Déactiver les intempéries">
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>