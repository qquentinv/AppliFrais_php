<?php

/** 
 * Page d'accueil de l'application web AppliFrais
 * @package default
 * @todo  RAS
 */
$repInclude = './include/';
require($repInclude . "_init.inc.php");

// page inaccessible si visiteur non connecté
if (!estUtilisateurConnecte()) {
  header("Location: cSeConnecter.php");
}



require($repInclude . "_entete.inc.html");
require($repInclude . "_sommaire.inc.php");

// acquisition des données entrées, ici le numéro de mois, l'id du visteur et l'étape du traitement
$moisSaisi = lireDonnee("lstMois", "");
$etape = lireDonnee("etape", "");
$visiteurSaisi = lireDonnee("lstVisiteur", "");
$tabQteEltsForfait = lireDonnee("txtEltsForfait", ""); //non focntionnel

//fichefrais 

if (isset($_GET["modifierFF"])) { //non focntionnel
  modifierEltsForfait($idConnexion, $moisSaisi, $visiteurSaisi, $tabQteEltsForfait);
}

if (isset($_GET["supprimerFF"])) { //non focntionnel
  modifierEltsForfait($idConnexion, $moisSaisi, $visiteurSaisi, $tabQteEltsForfait);
}

//fichefrais hors forfait

if (isset($_GET["modifyId"])) {
  modifierLHF($idConnexion, $_GET["modifyId"], $_GET["dateLHF"], $_GET["libelleLHF"], $_GET["montantLHF"]);
}

if (isset($_GET["deleteId"])) {
  supprimerLigneHF($idConnexion, $_GET["deleteId"]);
}




if ($etape != "demanderConsult" && $etape != "validerConsult" && $etape != "validerSaisi") {
  // si autre valeur, on considère que c'est le début du traitement
  $etape = "demanderConsult";
}
if ($etape == "validerConsult") { // l'utilisateur valide ses nouvelles données

  // vérification de l'existence de la fiche de frais pour le mois demandé
  $existeFicheFrais = existeFicheFrais($idConnexion, $moisSaisi, $visiteurSaisi);
  // si elle n'existe pas, on la crée avec les élets frais forfaitisés à 0
  if (!$existeFicheFrais) {
    ajouterErreur($tabErreurs, "Ce visiteur n'a pas de fiche de frais pour ce mois.");
  } else {
    // récupération des données sur la fiche de frais demandée
    $tabFicheFrais = obtenirDetailFicheFrais($idConnexion, $moisSaisi, $visiteurSaisi);
  }
}

?>

<!-- Division principale -->
<div id="contenu">
  <h2>Validation des Fiches de Frais</h2>
  <h3>Visiteur et Mois à sélectionner : </h3>
  <form action="" method="get" style="text-align:center;">
    <div class="corpsForm">
      <input type="hidden" name="etape" value="validerConsult" />
      <p>
        Visiteur :
        <select id="lstVisiteur" name="lstVisiteur" title="Sélectionnez le visiteur souhaité pour la fiche de frais" style="margin:15px;">
          <?php
          // On récupére tous les visiteurs
          $req = obtenirReqVisiteur();
          $idJeuMois = mysqli_query($idConnexion, $req);
          $lgVisiteur = mysqli_fetch_assoc($idJeuMois);
          while (is_array($lgVisiteur)) {
            $idVisiteur = $lgVisiteur["id"];
            $visiteur = $lgVisiteur["nom"];
            ?>
            <option value="<?php echo $idVisiteur; ?>" <?php if ($visiteurSaisi == $idVisiteur) { ?> selected="selected" <?php } ?>><?php echo $visiteur; ?></option>
          <?php
            $lgVisiteur = mysqli_fetch_assoc($idJeuMois);
          }
          mysqli_free_result($idJeuMois);
          ?>
        </select>
        Mois :
        <select id="lstMois" name="lstMois" title="Sélectionnez le mois souhaité pour la fiche de frais">
          <?php
          // on propose tous les mois pour lesquels le visiteur a une fiche de frais
          $req = obtenirTousLesMois($visiteurSaisi);
          $idJeuMois = mysqli_query($idConnexion, $req);
          $lgMois = mysqli_fetch_assoc($idJeuMois);
          while (is_array($lgMois)) {
            $mois = $lgMois["mois"];
            $noMois = intval(substr($mois, 4, 2));
            $annee = intval(substr($mois, 0, 4));
            ?>
            <option value="<?php echo $mois; ?>" <?php if ($moisSaisi == $mois) { ?> selected="selected" <?php } ?>><?php echo obtenirLibelleMois($noMois) . " " . $annee; ?></option>
          <?php
            $lgMois = mysqli_fetch_assoc($idJeuMois);
          }
          mysqli_free_result($idJeuMois);
          ?>
        </select>
      </p>
    </div>

    <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" title="Demandez à consulter cette fiche de frais" />
      </p>
    </div>
  </form>

  <?php
  if ($etape == "validerConsult") {
    if (nbErreurs($tabErreurs) > 0) {
      echo toStringErreurs($tabErreurs);
    } else {
      ?>
      <h3>Fiche de frais du mois de <?php echo obtenirLibelleMois(intval(substr($moisSaisi, 4, 2))) . " " . substr($moisSaisi, 0, 4); ?> :
        <em><?php echo $tabFicheFrais["libelleEtat"]; ?> </em>
        depuis le <em><?php echo $tabFicheFrais["dateModif"]; ?></em></h3>
      <div class="encadre">
        <p>Montant validé : <?php echo $tabFicheFrais["montantValide"]; ?></p>
        <?php
            // demande de la requête pour obtenir la liste des éléments 
            // forfaitisés du visiteur connecté pour le mois demandé
            $req = obtenirReqEltsForfaitFicheFrais($idConnexion, $moisSaisi, $visiteurSaisi);
            $idJeuEltsFraisForfait = mysqli_query($idConnexion, $req);
            echo mysqli_error($idConnexion);
            $lgEltForfait = mysqli_fetch_assoc($idJeuEltsFraisForfait);
            // parcours des frais forfaitisés du visiteur connecté
            // le stockage intermédiaire dans un tableau est nécessaire
            // car chacune des lignes du jeu d'enregistrements doit être doit être
            // affichée au sein d'une colonne du tableau HTML
            $tabEltsFraisForfait = array();
            while (is_array($lgEltForfait)) {
              $tabEltsFraisForfait[$lgEltForfait["libelle"]] = $lgEltForfait["quantite"];
              $lgEltForfait = mysqli_fetch_assoc($idJeuEltsFraisForfait);
              $idFraisForfait = $lgEltForfait["idFraisForfait"];
            }
            mysqli_free_result($idJeuEltsFraisForfait);
            ?>

        <form action="" method="get">
          <div class="corpsForm">
            <input type="hidden" name="etape" value="validerSaisie" />
            <table class="listeLegere">
              <caption>Quantités des éléments forfaitisés</caption>
              <tr>
                <?php
                    // affiche les tires des colonnes fiches frais 
                    foreach ($tabEltsFraisForfait as $unLibelle => $uneQuantite) { ?>
                  <th><?php echo $unLibelle; ?></th>
                <?php } ?>
              </tr>
              <tr>
                <?php
                    // affiche la ligne des quantités des frais forfaitisés
                    foreach ($tabEltsFraisForfait as $unLibelle => $uneQuantite) { ?>
                  <td class="qteForfait"><input type="text" size="5" value="<?php echo $uneQuantite; ?>"></td>
                <?php } ?>
                <td><input id="modif" type="submit" value="Modifier" size="20" title="Modifie la fiche de frais" onClick="ModifierFF()" /></td>
                <td><input id="sup" type="submit" value="Supprimer" size="20" title="Supprime la fiche de frais" onClick="SupprimerFF()" /></td>
              </tr>
            </table>
          </div>
        </form>

        <table class="listeLegere">
          <caption>Descriptif des éléments hors forfait - <?php echo $tabFicheFrais["nbJustificatifs"]; ?> justificatifs reçus -
          </caption>
          <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class="montant">Montant</th>
          </tr>
          <?php
              // demande de la requête pour obtenir la liste des éléments hors
              // forfait du visiteur connecté pour le mois demandé
              $req = obtenirReqEltsHorsForfaitFicheFrais($idConnexion, $moisSaisi, $visiteurSaisi);
              $idJeuEltsHorsForfait = mysqli_query($idConnexion, $req);
              $lgEltHorsForfait = mysqli_fetch_assoc($idJeuEltsHorsForfait);

              $i = 0;

              // parcours des éléments hors forfait 
              while (is_array($lgEltHorsForfait)) {
                $date = $lgEltHorsForfait["date"];
                $libelle = filtrerChainePourNavig($lgEltHorsForfait["libelle"]);
                $montant = $lgEltHorsForfait["montant"];
                $id = $lgEltHorsForfait["id"];

                ?>
            <tr>
              <?php
                    echo ("<td><input type='text' size='7' name='qteForfait' value='$date' id='date$i'></td>");
                    echo ("<td><input type='text' size='38' name='qteForfait' value='$libelle' id='libelle$i'></td>");
                    echo ("<td><input type='text' size='4' name='qteForfait' value='$montant' id='montant$i'></td>");
                    echo ("<td><input id='modif' type='submit' value='Modifier' size='20' title='Modifie la fiche de frais' onClick='ModifierLHF($id, $i)'/></td>");
                    echo ("<td><input id='sup' type='submit' value='Supprimer' size='20' title='Supprime la fiche de frais' onClick='SupprimerLHF($id)' /></td>");
                    echo ("<td><input id='reinitialiser' type='submit' value='Réinitialiser' size='20' title='reinitialiser' onClick='Reinitialiser()'/></td>");
                    ?>
            </tr>
          <?php
                $lgEltHorsForfait = mysqli_fetch_assoc($idJeuEltsHorsForfait);
                $i = $i + 1;
              }
              mysqli_free_result($idJeuEltsHorsForfait);
              ?>
        </table>
      </div>
  <?php
    }
  }
  ?>
</div>

<script>
  // fichefrais
  function ModifierFF() { //fonctionne pas
    var loc = window.location;
    window.location = loc.protocol + '//' + loc.host + loc.pathname + loc.search + "&modifierFF=1";
  }

  function SupprimerFF() { //fonctionne pas
    var loc = window.location;
    window.location = loc.protocol + '//' + loc.host + loc.pathname + loc.search + "&supprimerFF=1";
  }
  // fichefrais hors forfait
  function ModifierLHF(id, i) { 
    var date = document.getElementById("date" + i);
    var libelle = document.getElementById("libelle" + i);
    var montant = document.getElementById("montant" + i);
    var loc = window.location;
    window.location = loc.protocol + '//' + loc.host + loc.pathname + loc.search + "&modifyId=" + id + "&dateLHF=" + date.value + "&libelleLHF=" + libelle.value + "&montantLHF=" + montant.value;
  }

  function SupprimerLHF(id) {
    var loc = window.location;
    window.location = loc.protocol + '//' + loc.host + loc.pathname + loc.search + "&deleteId=" + id;
  }

  function Reinitialiser() {
    var loc = window.location;
    window.location = loc.protocol + '//' + loc.host + loc.pathname + loc.search;
  }
</script>

<?php
require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");
?>