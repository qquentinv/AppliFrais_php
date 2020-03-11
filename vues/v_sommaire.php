    <!-- Division pour le sommaire -->
    <div id="menuGauche">
       <div id="infosUtil">

          <h2>
          Visiteur
          </h2>

       </div>
       <ul id="menuList">
          <li>
             <h5>
                <?php echo $_SESSION['prenom'] . "  " . $_SESSION['nom']  ?>
             </h5>
          </li>
          <li><a href="index.php?uc=connexion&action=accueil" title="Accueil">Accueil</a></li>
          <li class="smenu">
             <a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais ">Saisie fiche de frais</a>
          </li>
          <li class="smenu">
             <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
          </li>
          <li class="smenu">
             <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
          </li>
       </ul>

    </div>