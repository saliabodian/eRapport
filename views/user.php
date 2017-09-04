<div id="content">
    <div id="content-header">
        <hr>
        <h1>Gestion des utilisateurs</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Sélection d'une tâche</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="" method="get" class="form-horizontal">
                            <div class="controls-row">
                                <label class="control-label span3 m-wrap">Liste des utilisateurs</label>
                                <div class="controls span3 m-wrap">
                                    <?php $selectUser->displayHTML(); ?>
                                </div>
                                <div class="controls span3 m-wrap">
                                    <input type="submit" class="btn btn-success btn-block" value="Sélectionner" />
                                </div>
                                <div class="controls span3 m-wrap">
                                    <a href="?" class="btn btn-info btn-block">Ajouter</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5><?php if ($userObject->getId() > 0) : ?>Modification d'un <?php else : ?>Ajout d'un <?php endif ?>utilisteur</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php include 'alert.php'; ?>
                        <form action="" method="post" class="form-horizontal" id="demoform">
                            <input type="hidden" name="user_id" value="<?= $userObject->getId() ?>">
                            <div class="control-group">
                                <label class="control-label" >Prénom <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Prénom" name="firstname" value="<?= $userObject->getFirstname() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nom <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nom" name="lastname" value="<?= $userObject->getLastname() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Login <span>*</span>:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Login" name="username" value="<?= $userObject->getUsername() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Email <span>*</span>:</label>
                                <div class="controls">
                                    <input type="email" class="span11" placeholder="m.mariano@cdclux.com" name="email" value="<?= $userObject->getEmail() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Mot de passe <span>*</span></label>
                                <div class="controls">
                                    <input type="password"  class="span11" placeholder="Mot de passe" name="password1" value="<?= $userObject->getPassword() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Confirmer mot de passe <span>*</span></label>
                                <div class="controls">
                                    <input type="password"  class="span11" placeholder="Confirmer votre mot de passe" name="password2" value="<?= $userObject->getPassword() ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="role" class="control-label">Fonction :</label>
                                <div class="controls mySelect">
                                    <?php $selectPost->displayHTML(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">

                                    <select multiple="multiple" size="10" name="duallistbox_demo1[]">
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
                                    <a href="?delete=<?= $userObject->getId() ?>" class="btn btn-warning  btn-block<?php if ($userObject->getId() <= 0) : ?> disabled<?php endif; ?>" role="button" aria-disabled="true">Supprimer</a>
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