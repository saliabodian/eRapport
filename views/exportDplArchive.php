<div id="content">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
                            <h5>Liste des fichiers générés</h5>
                        </div>
                        <div class="widget-content">
                            <div class="todo">
                                <ul>
                                    <?php foreach($dir as $exp) : ?>
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
                </div>
            </div>
        </div>
    </div>
</div>