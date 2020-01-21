<?php
/** 
 * Contient la division pour le sommaire, sujet à des variations suivant la 
 * connexion ou non d'un utilisateur, et dans l'avenir, suivant le type de cet utilisateur 
 * @todo  RAS
 */

?>
    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    <?php      
      if (estUtilisateurConnecte() ) {
          $idUser = obtenirIdUserConnecte() ;
          if (comptableOuNon($idConnexion, $idUser)){
            $lgUserCp = obtenirDetailComptable($idConnexion, $idUser);
            $nom = $lgUserCp['nom'];
            $prenom = $lgUserCp['prenom'];             
    ?>
        <h2>
    <?php  
            echo $nom . " " . $prenom ;
    ?>
        </h2>
        <h3>Comptable</h3>        
    <?php
       }
       else {
         $lgUserVis = obtenirDetailVisiteur($idConnexion, $idUser);
         $nom = $lgUserVis['nom'];
         $prenom = $lgUserVis['prenom'];   
    ?>  
         <h2>
    <?php  
            echo $nom . " " . $prenom ;
    ?>
        </h2>
        <h3>Visiteur médical</h3>        
    <?php
       }
      }
      ?>
      </div>  
<?php      
  if (estUtilisateurConnecte() ) {
     if(comptableOuNon($idConnexion, $idUser)){
?>
<ul id="menuList">
           <li class="smenu">
              <a href="cAccueil.php" title="Page d'accueil">Accueil</a>
           </li>
           <li class="smenu">
              <a href="cSeDeconnecter.php" title="Se déconnecter">Se déconnecter</a>
           </li>
           <li class="smenu">
              <a href="cValideFicheFrais.php" title="Valide fiches frais">Valider fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="cSaisiePayeFicheFrais.php" title="Saisie payement fiche frais">Saisie payement fiche frais</a>
           </li>
         </ul>
<?php
     }
     else{
     ?>
        <ul id="menuList">
           <li class="smenu">
              <a href="cAccueil.php" title="Page d'accueil">Accueil</a>
           </li>
           <li class="smenu">
              <a href="cSeDeconnecter.php" title="Se déconnecter">Se déconnecter</a>
           </li>
           <li class="smenu">
              <a href="cSaisieFicheFrais.php" title="Saisie fiche de frais du mois courant">Saisie fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="cConsultFichesFrais.php" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
           </li>
         </ul>
        <?php
     }
          // affichage des éventuelles erreurs déjà détectées
          if ( nbErreurs($tabErreurs) > 0 ) {
              echo toStringErreurs($tabErreurs) ;
          }
  }
        ?>
    </div>
    