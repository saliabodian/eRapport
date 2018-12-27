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
                                        <th>Agence</th>
                                        <th>Intérimaire</th>
                                        <th>Métier / Qualif</th>
                                        <th>Département</th>
                                        <th>Chef d'équipe</th>
                                        <th>Chantier d'affectation</th>
                                        <th>Mobilité</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    <?php foreach ($interiamireList as $interimaire) : ?>
                                        <tr>
                                            <td><?= $interimaire['nom_agence']?></td>
                                            <td><?= $interimaire['matricule']." - ".$interimaire['firstname']." ".$interimaire['lastname'] ?></td>
                                            <td><?= $interimaire['nom_metier']." / ".$interimaire['nom_qualif'] ?></td>
                                            <td><?= $interimaire['nom_dpt'] ?></td>
                                            <td><?= $interimaire['chef_equipe']?></td>
                                            <td><?= $interimaire['chantier_de_base']?></td>
                                            <td>
                                                <?php
                                                foreach($intMobiles as $intMobile) {
                                                    if(array_search($intMobile['interimaire_id'], $interimaireId) && $intMobile['interimaire_id'] === $interimaire['id']){
                                                        echo $intMobile['chantier']."; " ;
                                                    }else{
                                                        "pas de mobilté";
                                                    }
                                                }
                                                ?>
                                            </td>
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