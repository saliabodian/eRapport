<div id="content">
    <div id="content-header">
        <hr>
        <h1>Liste des intérimaire actifs </h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <?php include 'alert.php'; ?>
                    <?php if(!empty($interiamireList)){ ?>
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Liste intérimaires</h5>
                            </div>
                            <div class="widget-content">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Prénom</th>
                                        <th>Nom</th>
                                        <th>Actif</th>
                                        <th>Métier</th>
                                        <th>Agence</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    <?php foreach ($interiamireList as $interimaire) : ?>
                                        <tr>
                                            <td><?= $interimaire['matricule']?></td>
                                            <td><?= $interimaire['firstname']?></td>
                                            <td><?= $interimaire['lastname'] ?></td>
                                            <td><?= $interimaire['actif']?></td>
                                            <td><?= $interimaire['nom_metier']?></td>
                                            <td><?= $interimaire['nom_agence']?></td>
                                        </tr>
                                    <?php endforeach ?>
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