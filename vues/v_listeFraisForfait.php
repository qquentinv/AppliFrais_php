<div id="contenu">
  <h2>Renseigner ma fiche de frais du mois <?php echo $numMois . "-" . $numAnnee ?></h2>

  <form method="POST" action="index.php?uc=gererFrais&action=validerMajFraisForfait">
    <div class="corpsForm">

      <fieldset>
        <legend>Eléments forfaitisés
        </legend>
        <?php
        foreach ($lesFraisForfait as $unFrais) {
          $idFrais = $unFrais['idfrais'];
          $libelle = $unFrais['libelle'];
          $quantite = $unFrais['quantite'];
        ?>
          <p>
            <label for="idFrais"><?php echo $libelle ?></label>
            <input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais ?>]" size="10" maxlength="5" value="<?php echo $quantite ?>">
          </p>

        <?php
        }
        ?>
      </fieldset>
    </div>
    <div class="piedForm">
      <p>
        <input id="ok" class="btn btn-primary" type="submit" value="Valider" size="20" />
        <input id="annuler" class="btn btn-secondary" type="reset" value="Effacer" size="20" />
      </p>
    </div>

  </form>