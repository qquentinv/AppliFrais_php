<h3>Fiche de frais du mois <?php echo $numMois . "-" . $numAnnee ?> :
</h3>
<div class="encadre">
  <h3 style="margin-left:5px;">
    Etat : <?php echo $libEtat ?> depuis le <?php echo $dateModif ?>
    <?php
    if ($libEtat == "Fiche créée, saisie en cours" || $libEtat == "Saisie clôturée") {?>
      <button style='margin-right: 10px; ' id='validation' class='btn btn-success' title='Validation de la fiche' type='submit' onClick="ValiderFiche('<?php echo $leVisiteur ?>', '<?php echo $leMois ?>')"><svg class='bi bi-check-circle' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
      <path fill-rule='evenodd' d='M15.354 2.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3-3a.5.5 0 11.708-.708L8 9.293l6.646-6.647a.5.5 0 01.708 0z' clip-rule='evenodd'/>
      <path fill-rule='evenodd' d='M8 2.5A5.5 5.5 0 1013.5 8a.5.5 0 011 0 6.5 6.5 0 11-3.25-5.63.5.5 0 11-.5.865A5.472 5.472 0 008 2.5z' clip-rule='evenodd'/>
    </svg></button>
    <?php 
    }

    ?>
    <br>
    Montant validé : <?php echo $montantValide ?>
  </h3>

  <table class="listeLegere">
    <h5 style="margin-left: 5px">Eléments forfaitisés </h5>
    <tr>
      <?php
      foreach ($lesFraisForfait as $unFraisForfait) {
        $libelle = $unFraisForfait['libelle'];
      ?>
        <th> <?php echo $libelle ?></th>
      <?php
      }
      ?>
    </tr>
    <tr>
      <?php
      foreach ($lesFraisForfait as $unFraisForfait) {
        $quantite = $unFraisForfait['quantite'];
      ?>
        <td class="qteForfait"><input type="text" class="form-changer" size="4" value="<?php echo $quantite ?>" /> </td>
      <?php
      }
      ?>
      <td><button id="ok" class="btn btn-primary" title="Corriger fiche frais" type="submit" value="Modifier" onClick="ModifierFF('<?php echo $leVisiteur ?>', '<?php echo $leMois ?>')"><svg class="bi bi-pencil-square" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.502 1.94a.5.5 0 010 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 01.707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 00-.121.196l-.805 2.414a.25.25 0 00.316.316l2.414-.805a.5.5 0 00.196-.12l6.813-6.814z" />
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 002.5 15h11a1.5 1.5 0 001.5-1.5v-6a.5.5 0 00-1 0v6a.5.5 0 01-.5.5h-11a.5.5 0 01-.5-.5v-11a.5.5 0 01.5-.5H9a.5.5 0 000-1H2.5A1.5 1.5 0 001 2.5v11z" clip-rule="evenodd" />
          </svg></button></td>
    </tr>
  </table>
  <div class="form-group row" style="margin-left: 5px; display:flex; margin-top:20px;">
    <h3>Nombre de justificatifs reçus :
      <input style="margin-left:10px;margin-right:10px;" id="justificatif" type="text" size="5" class="form-group" value="<?php echo $nbJustificatifs ?>" />

      <button id="modif" title="Corriger justification" class="btn btn-primary" type="submit" onClick="ModifierJR('<?php echo $leVisiteur ?>', '<?php echo $leMois ?>' )"><svg class="bi bi-pencil-square" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.502 1.94a.5.5 0 010 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 01.707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 00-.121.196l-.805 2.414a.25.25 0 00.316.316l2.414-.805a.5.5 0 00.196-.12l6.813-6.814z" />
          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 002.5 15h11a1.5 1.5 0 001.5-1.5v-6a.5.5 0 00-1 0v6a.5.5 0 01-.5.5h-11a.5.5 0 01-.5-.5v-11a.5.5 0 01.5-.5H9a.5.5 0 000-1H2.5A1.5 1.5 0 001 2.5v11z" clip-rule="evenodd" />
        </svg></button>
    </h3>
  </div>
  <table class="listeLegere">
    <h5 style="margin-left: 5px">Descriptif des éléments hors forfait</h5>
    <tr>
      <th class="date">Date</th>
      <th class="libelle">Libellé</th>
      <th class="montant">Montant</th>
      <th class="action">Action</th>
    </tr>
    <?php
    $i = 0;
    foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
      $date = $unFraisHorsForfait['date'];
      $libelle = $unFraisHorsForfait['libelle'];
      $montant = $unFraisHorsForfait['montant'];
      $id = $unFraisHorsForfait['id'];
    ?>
      <tr>
        <td><input type="text" class="form-control" size="10" value="<?php echo $date ?>" id="date<?php echo $i ?>" /></td>
        <td><input type="text" class="form-control" size="10" value="<?php echo $libelle ?>" id="libelle<?php echo $i ?>" /></td>
        <td><input type="text" class="form-control" size="5" value="<?php echo $montant ?>" id="montant<?php echo $i ?>" /></td>
        <td>
          <button id="ok" class="btn btn-primary" type="submit" onClick="ModifierLHF('<?php echo $leVisiteur ?>', '<?php echo $leMois ?>',<?php echo $id;
                                                                                      echo ",";
                                                                                      echo $i; ?>)" title='Modifie la fiche de frais'><svg class="bi bi-pencil-square" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M15.502 1.94a.5.5 0 010 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 01.707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 00-.121.196l-.805 2.414a.25.25 0 00.316.316l2.414-.805a.5.5 0 00.196-.12l6.813-6.814z" />
              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 002.5 15h11a1.5 1.5 0 001.5-1.5v-6a.5.5 0 00-1 0v6a.5.5 0 01-.5.5h-11a.5.5 0 01-.5-.5v-11a.5.5 0 01.5-.5H9a.5.5 0 000-1H2.5A1.5 1.5 0 001 2.5v11z" clip-rule="evenodd" />
            </svg></button>
          <button id="ok" class="btn btn-danger" type="submit" onClick="SupprimerLHF('<?php echo $leVisiteur ?>', '<?php echo $leMois ?>',<?php echo $id ?>)" title='Supprime la fiche de frais'><svg class="bi bi-x-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd" />
              <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z" clip-rule="evenodd" />
              <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z" clip-rule="evenodd" />
            </svg></button>
          <button id="ok" class="btn btn-secondary" type="reset" onClick="Reinitialiser('<?php echo $leVisiteur ?>', '<?php echo $leMois ?>')" title="Réinitialiser la fiche de frais"><svg class="bi bi-arrow-clockwise" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M3.17 6.706a5 5 0 017.103-3.16.5.5 0 10.454-.892A6 6 0 1013.455 5.5a.5.5 0 00-.91.417 5 5 0 11-9.375.789z" clip-rule="evenodd" />
              <path fill-rule="evenodd" d="M8.147.146a.5.5 0 01.707 0l2.5 2.5a.5.5 0 010 .708l-2.5 2.5a.5.5 0 11-.707-.708L10.293 3 8.147.854a.5.5 0 010-.708z" clip-rule="evenodd" />
            </svg></button>
          <button id="ok" class="btn btn-info" type="submit" onClick="ReportLHF('<?php echo $leVisiteur ?>', '<?php echo $leMois ?>',<?php echo $id;
                                                                                echo ",";
                                                                                echo $i; ?>)"><svg class="bi bi-reply" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M9.502 5.013a.144.144 0 00-.202.134V6.3a.5.5 0 01-.5.5c-.667 0-2.013.005-3.3.822-.984.624-1.99 1.76-2.595 3.876C3.925 10.515 5.09 9.982 6.11 9.7a8.741 8.741 0 011.921-.306 7.403 7.403 0 01.798.008h.013l.005.001h.001L8.8 9.9l.05-.498a.5.5 0 01.45.498v1.153c0 .108.11.176.202.134l3.984-2.933a.494.494 0 01.042-.028.147.147 0 000-.252.494.494 0 01-.042-.028L9.502 5.013zM8.3 10.386a7.745 7.745 0 00-1.923.277c-1.326.368-2.896 1.201-3.94 3.08a.5.5 0 01-.933-.305c.464-3.71 1.886-5.662 3.46-6.66 1.245-.79 2.527-.942 3.336-.971v-.66a1.144 1.144 0 011.767-.96l3.994 2.94a1.147 1.147 0 010 1.946l-3.994 2.94a1.144 1.144 0 01-1.767-.96v-.667z" clip-rule="evenodd" />
            </svg></button></td>
      </tr>
    <?php
      $i++;
    }
    ?>

  </table>
  <script>
    //Validation de la fiche 
    function ValiderFiche(vis, mois) {
      var loc = window.location;
      window.location = loc.protocol + '//' + loc.host + loc.pathname + "?uc=validerFrais&action=voirFicheFrais&lstVisiteur=" + vis +
        "&lstMois=" + mois + "&sure=1";
    }
    // fichefrais
    function ModifierFF(vis, mois) { //fonctionne pas
      var d = document.getElementsByClassName("form-changer")
      var ETP = d[0].value;
      var KM = d[1].value;
      var NUI = d[2].value;
      var REP = d[3].value;
      var loc = window.location;
      window.location = loc.protocol + '//' + loc.host + loc.pathname + "?uc=validerFrais&action=voirFicheFrais&lstVisiteur=" + vis +
        "&lstMois=" + mois + "&ETP=" + ETP + "&KM=" + KM + "&NUI=" + NUI + "&REP=" + REP;
    }

    //Justificatif reçu
    function ModifierJR(vis, mois) {
      var JR = document.getElementById("justificatif");
      var loc = window.location;
      window.location = loc.protocol + '//' + loc.host + loc.pathname + "?uc=validerFrais&action=voirFicheFrais&lstVisiteur=" + vis +
        "&lstMois=" + mois + "&modifierJR=" + JR.value;
    }

    // fichefrais hors forfait
    function ModifierLHF(vis, mois, id, i) {
      var date = document.getElementById("date" + i);
      var libelle = document.getElementById("libelle" + i);
      var montant = document.getElementById("montant" + i);
      var loc = window.location;
      window.location = loc.protocol + '//' + loc.host + loc.pathname + "?uc=validerFrais&action=voirFicheFrais&lstVisiteur=" + vis +
        "&lstMois=" + mois + "&modifyId=" + id + "&dateLHF=" + date.value + "&libelleLHF=" + libelle.value + "&montantLHF=" + montant.value;
    }

    function SupprimerLHF(vis, mois, id) {
      var loc = window.location;
      window.location = loc.protocol + '//' + loc.host + loc.pathname + "?uc=validerFrais&action=voirFicheFrais&lstVisiteur=" + vis +
        "&lstMois=" + mois + "&deleteId=" + id;
    }

    function Reinitialiser(vis, mois) {
      var loc = window.location;
      window.location = loc.protocol + '//' + loc.host + loc.pathname + "?uc=validerFrais&action=voirFicheFrais&lstVisiteur=" + vis +
        "&lstMois=" + mois;
    }

    function ReportLHF(vis, mois, id, i) {
      var DLHF = document.getElementById("date" + i);
      var LLHF = document.getElementById("libelle" + i);
      var MLHF = document.getElementById("montant" + i);
      var loc = window.location;
      window.location = loc.protocol + '//' + loc.host + loc.pathname + "?uc=validerFrais&action=voirFicheFrais&lstVisiteur=" + vis +
        "&lstMois=" + mois + "&report=" + id + "&LLHF=" + LLHF.value + "&DLHF=" + DLHF.value + "&MLHF=" + MLHF.value;
    }
  </script>
</div>
</div>