
<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <!--li><a href="index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li-->
    <!--li> <a href="charts.php"><i class="icon icon-signal"></i> <span>Charts &amp; graphs</span></a> </li-->
    <!--li> <a href="widgets.php"><i class="icon icon-inbox"></i> <span>Widgets</span></a> </li-->
    <!--li><a href="tables.php"><i class="icon icon-th"></i> <span>Tables</span></a></li-->
    <!--li class="submenu"> <a href="#"><i class="icon-cog"></i> <span>Paramètrage</span> <span class="label label-important"></span></a>
      <ul>
        <li> <a href="user.php">Gestion des utilisateurs</a></li>
        <li> <a href="agence.php"> Gestion des agences</a></li>
        <li> <a href="chantier.php">Gestion des chantiers</a></li>
        <li> <a href="post.php">Gestion des fonctions</a></li>
        <li> <a href="metier.php">Gestion des métiers</a></li>
        <li> <a href="typeTache.php">Gestion des types de tâches</a></li>
        <li> <a href="tache.php">Gestion des tâches</a></li>
        <li> <a href="qualification.php">Gestion des qualifications</a></li>
        <li> <a href="departement.php">Gestion des départements</a></li>
        <li> <a href="interimaire.php">Gestion des intérimaires</a></li>
        <li> <a href="affectation.php">Ré-affectation des intérimaires</a></li>
        <li> <a href="showAffectation.php">Intérimaires affectés par chantier</a></li>
        <li> <a href="erapport.php">Génération du erapport</a></li>
        <li> <a href="anomalieRh.php">Les anomalies</a></li>
      </ul>
    </li-->
    <?php
      if ($_SESSION['post_id']=== "4" || $_SESSION['post_id']=== "7"){
    ?>
      <li class="submenu"> <a href="#"><i class="icon-cogs"></i> <span>Paramètrage</span> <span class="label label-important"></span></a>
        <ul>
          <li> <a href="user.php"><i class="icon-user"></i><span>&nbsp;&nbsp;Gestion des utilisateurs</span></a></li>
          <?php
            if ($_SESSION['post_id']=== "7" ){
          ?>
            <li> <a href="post.php"><i class="icon-briefcase"></i><span>&nbsp;&nbsp;Gestion des fonctions</span></a></li>
          <?php
            }
          ?>
        </ul>
      </li>
    <?php
      }
    ?>
    <?php
      if ($_SESSION['post_id']=== "4" || $_SESSION['post_id']=== "7"){
    ?>
      <li class="submenu"> <a href="#"><i class="icon-user-md"></i> <span>Ressources Humaines</span> <span class="label label-important"></span></a>
        <ul>
          <li> <a href="agence.php"><i class="icon-home"></i>&&nbsp;&nbsp;Gestion des agences</a></li>
          <li> <a href="departement.php"><i class="icon-building"></i>&nbsp;&nbsp;Gestion des départements</a></li>
          <li> <a href="qualification.php"><i class="icon-book"></i>&nbsp;&nbsp;Gestion des qualifications</a></li>
          <li> <a href="metier.php"><i class="icon-file"></i>&nbsp;&nbsp;Gestion des métiers</a></li>
          <li> <a href="interimaire.php"><i class="icon-group"></i>&nbsp;&nbsp;Gestion des intérimaires</a></li>
          <li> <a href="desactivationInterimaires.php"><i class="icon-check-empty"></i>&nbsp;&nbsp;Désactivation des intérimaires</a></li>
          <li> <a href="mobilite.php"><i class="icon-map-marker"></i>&nbsp;&nbsp;Mobilité des Intérimaires</a></li>
          <li> <a href="affectation.php"><i class="icon-hand-right"></i>&nbsp;&nbsp;Affectation des intérimaires</a></li>
          <li> <a href="showAffectation.php"><i class="icon-tags"></i> &nbsp;&nbsp;Intérimaires affectés par chantier</a></li>
        </ul>
      </li>
    <?php
      }
    ?>
    <?php
      if ($_SESSION['post_id']=== "4" || $_SESSION['post_id']=== "7" || $_SESSION['post_id']=== "12"){
    ?>
      <li class="submenu"> <a href="#"><i class="icon-eye-open"></i> <span>Contrôle de gestion</span> <span class="label label-important"></span></a>
        <ul>
          <li> <a href="typeTache.php"><i class="icon-list"></i>&nbsp;&nbsp;Gestion des types de tâches</a></li>
          <li> <a href="tache.php"><i class="icon-list-alt"></i>&nbsp;&nbsp;Gestion des tâches</a></li>
        </ul>
      </li>
    <?php
      }
    ?>
    <?php
    if ($_SESSION['post_id']=== "4" || $_SESSION['post_id']=== "7"){
      ?>
      <li class="submenu"> <a href="#"><i class="icon-map-marker"></i> <span>Gestion des chantiers</span> <span class="label label-important"></span></a>
        <ul>
          <li> <a href="chantier.php"><i class="icon-picture"></i>&nbsp;&nbsp;Création des chantiers</a></li>
          <li> <a href="chantierEnIntemperie.php"><i class="icon-asterisk"></i>&nbsp;&nbsp;Chantiers en Intempéries</a></li>
        </ul>
      </li>

    <?php
    }
    ?>
    <?php
      if ($_SESSION['post_id']=== "4" || $_SESSION['post_id']=== "7" || $_SESSION['post_id']=== "1"|| $_SESSION['post_id']=== "2" || $_SESSION['post_id']=== "3" || $_SESSION['post_id']=== "5"){
    ?>
      <li> <a href="erapport.php"><i class="icon-tasks"></i> <span>Génération du erapport</span> <span class="label label-important"></span></a></li>
    <?php
      }
    ?>
    <?php
      if ($_SESSION['post_id']=== "4" || $_SESSION['post_id']=== "7"){
    ?>
      <li> <a href="anomalieRh.php"><i class="icon-remove-sign"></i> <span>Les anomalies</span> <span class="label label-important"></span></a></li>
    <?php
      }
    ?>
    <?php
    if ($_SESSION['post_id']=== "4" ||  $_SESSION['post_id']=== "7" || $_SESSION['post_id']=== "1"|| $_SESSION['post_id']=== "2" || $_SESSION['post_id']=== "3" || $_SESSION['post_id']=== "5" || $_SESSION['post_id']=== "12" ){
      ?>
      <li class="submenu"> <a href="#"><i class="icon-bar-chart"></i> <span>Reporting</span> <span class="label label-important"></span></a>
        <ul>
          <li> <a href="condenseTaskDoneOnSite.php"><i class="icon-caret-right"></i><span>&nbsp;&nbsp;Résumé tâches / chantier</span></a></li>
          <li> <a href="tasksHoursDoneBySite.php"><i class="icon-caret-right"></i><span>&nbsp;&nbsp;Récap. tâches / chantier</span></a></li>

          <li> <a href="tasksHoursByWorkersBySite.php"><i class="icon-caret-right"></i><span>&nbsp;Tâches / travailleurs / chantier</span></a></li>
            <?php
          if ( $_SESSION['post_id'] === "14"){
          ?>
            <li> <a href="tasksHoursByWorkersBySiteFull.php"><i class="icon-caret-right"></i><span>&nbsp;Tâches / travailleurs / chantier - Full</span></a></li>
          <?php } ?>
          <li> <a href="exportToExcelListInt.php"><i class="icon-caret-right"></i><span>&nbsp;Liste des intérimaires actifs</span></a></li>
         <?php
          if ( $_SESSION['post_id'] === "7" || $_SESSION['post_id']=== "4"){
          ?>
            <li> <a href="exportDpl.php"><i class="icon-caret-right"></i><span>&nbsp;Export de Données RH</span></a></li>
          <?php } ?>
        </ul>
      </li>
    <?php
    }
    ?>
    <?php
    if ( $_SESSION['post_id'] === "7" || $_SESSION['post_id']=== "4"){
      ?>
      <li> <a href="printAllErapport.php"><i class="icon-print"></i> <span>Impression des erapport</span> <span class="label label-important"></span></a></li>
    <?php
    }
    ?>
    <?php
    if ( $_SESSION['post_id'] === "14"){
      ?>
      <li> <a href="exportInterimaire.php"><i class="icon-list-ul"></i> <span>Liste des intérimaires actifs</span> <span class="label label-important"></span></a></li>
    <?php
    }
    ?>

  </ul>
</div>
<!--sidebar-menu-->