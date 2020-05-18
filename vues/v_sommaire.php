    <!-- Division pour le sommaire -->
    <div id="menuGauche">
       <div id="infosUtil">

          <h2>
          <?php echo $_SESSION['role']; ?>
          </h2>

       </div>
       <ul id="menuList">
          <li>
             <h5>
                <?php echo $_SESSION['prenom'] . "  " . $_SESSION['nom']; ?>
             </h5>
          </li>
          <li><a href="index.php?uc=connexion&action=accueil" title="Accueil">Accueil</a></li>
          <?php 
          if ($_SESSION['role'] == "Comptable"){
            echo "<li class='smenu'>
            <a href='index.php?uc=validerFrais&action=selectionnerVisiteurMois' title='Valider fiches de frais'>Valider fiche de frais</a>
         </li>
         <li class='smenu'>
            <a href='index.php?uc=suiviFrais&action=suiviPayement' title='Suivie payement fiches de frais'>Suivie de payement fiches de frais</a>
         </li>";
          }
          else {
             echo "<li class='smenu'>
             <a href='index.php?uc=gererFrais&action=saisirFrais' title='Saisie fiche de frais '>Saisie fiche de frais</a>
          </li>
          <li class='smenu'>
             <a href='index.php?uc=etatFrais&action=selectionnerMois' title='Consultation de mes fiches de frais'>Mes fiches de frais</a>
          </li>";
          }

         ?>
          <li class='smenu'>
             <a href='index.php?uc=connexion&action=deconnexion' title='Se déconnecter'>Déconnexion</a>
          </li>
       </ul>

    </div>