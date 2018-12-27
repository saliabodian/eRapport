<div id="content">
    <div id="content-header">
        <hr>
        <h1>Liste des intérimaires actifs - <strong><?=count($interiamireList) ?> Actifs </strong>- en date du <?= date('d/m/Y', strtotime("now")) ?></h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <?php include 'alert.php'; ?>
                    <?php if(!empty($interiamireList)){ ?>

                        <input type="button" onclick="tableToExcel('testTable', 'Liste des interimaires actifs')" value="Export to Excel" class="btn btn-inverse btn-large" >
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                                <h5>Liste intérimaires</h5>
                            </div>
                            <div class="widget-content">
                                <table class="table table-bordered headerTable" id="testTable">
                                    <thead>
                                    <tr>
                                        <th>Agence</th>
                                        <th>Interimaire</th>
                                        <th>Metier / Qualif</th>
                                        <th>Departement</th>
                                        <th>Chef d'equipe</th>
                                        <th>Chantier d'affectation</th>
                                        <th>Mobilite</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    <?php foreach ($interiamireList as $interimaire) : ?>
                                        <tr>
                                            <td><?= strtr(utf8_decode($interimaire['nom_agence']), utf8_decode("âäàéèëêïîôöûüùççÂÀÉÊÏÎÛ"), "aaaeeeeiioouuuccaaeeiiu") ?></td>
                                            <td><?= strtr(utf8_decode($interimaire['matricule']), utf8_decode("âäàéèëêïîôöûüùççÂÀÉÊÏÎÛ"), "aaaeeeeiioouuuccaaeeiiu")." - ".strtr(utf8_decode($interimaire['firstname']), utf8_decode("âäàéèëêïîôöûüùççÂÀÉÊÏÎÛ"), "aaaeeeeiioouuuccaaeeiiu")." ".strtr(utf8_decode($interimaire['lastname']), utf8_decode("âäàéèëêïîôöûüùççÂÀÉÊÏÎÛ"), "aaaeeeeiioouuuccaaeeiiu") ?></td>
                                            <td><?= strtr(utf8_decode($interimaire['nom_metier']), utf8_decode("âäàéèëêïîôöûüùççÂÀÉÊÏÎÛ"), "aaaeeeeiioouuuccaaeeiiu")." / ".strtr(utf8_decode($interimaire['nom_qualif']), utf8_decode("âäàéèëêïîôöûüùççÂÀÉÊÏÎÛ"), "aaaeeeeiioouuuccaaeeiiu") ?></td>
                                            <td><?= strtr(utf8_decode($interimaire['nom_dpt']), utf8_decode("âäàéèëêïîôöûüùççÂÀÉÊÏÎÛ"), "aaaeeeeiioouuuccaaeeiiu") ?></td>
                                            <td><?= $interimaire['chef_dequipe_username'].' - '.strtr(utf8_decode($interimaire['chef_dequipe_firstname']), utf8_decode("âäàéèëêïîôöûüùççÂÀÉÊÏÎÛ"), "aaaeeeeiioouuuccaaeeiiu").' '.strtr(utf8_decode($interimaire['chef_dequipe_lastname']), utf8_decode("âäàéèëêïîôöûüùççÂÀÉÊÏÎÛ"), "aaaeeeeiioouuuccaaeeiiu")?></td>
                                            <td><?= strtr(utf8_decode($interimaire['chantier_de_base']), utf8_decode("âäàéèëêïîôöûüùççÂÀÉÊÏÎÛ"), "aaaeeeeiioouuuccaaeeiiu")?></td>
                                            <td>
                                                <?php
                                                foreach($intMobiles as $intMobile) {
                                                    if(array_search($intMobile['interimaire_id'], $interimaireId) && $intMobile['interimaire_id'] === $interimaire['id']){
                                                        echo strtr(utf8_decode($intMobile['chantier']), utf8_decode("âäàéèëêïîôöûüùççÂÀÉÊÏÎÛ"), "aaaeeeeiioouuuccaaeeiiu")."; " ;
                                                    }else{
                                                        "pas de chantiers temporaires";
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
                        <input type="button" onclick="tableToExcel('testTable', 'Liste des interimaires actifs')" value="Export to Excel" class="btn btn-inverse btn-large">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>