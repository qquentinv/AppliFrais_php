<div id="contenu">
    <h2>Valider fiches de frais</h2>
    <h3>Visiteur et Mois à sélectionner : </h3>
    <form action="index.php?uc=validerFrais&action=affichageFrais" method="post">
        <div class="corpsForm">
            <p>

                <label for="lstVisiteur" accesskey="n">Visiteur : </label>
                <select id="lstVisiteur" name="lstVisiteur">
                    <?php
                    
                    foreach ($lesVisiteurs as $unVis) {
                        $idVis = $unVis['id'];
                        $nomVis = $unVis['nom'];
                        $prenomVis =  $unVis['prenom'];
                        
                        if ($idVis == $visiteurASelectionner) {
                    ?>
                            <option selected value="<?php echo $idVis ?>"><?php echo  $prenomVis . " " . $nomVis ?> </option>
                        <?php
                        } else { ?>
                            <option value="<?php echo $idVis ?>"><?php echo  $prenomVis . " " . $nomVis ?> </option>
                    <?php
                        }
                    }

                    ?>

                </select>
            </p>
            <p>

                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee =  $unMois['numAnnee'];
                        $numMois =  $unMois['numMois'];
                        if ($mois == $moisASelectionner) {
                    ?>
                            <option selected value="<?php echo $mois ?>"><?php echo  $numMois . "/" . $numAnnee ?> </option>
                        <?php
                        } else { ?>
                            <option value="<?php echo $mois ?>"><?php echo  $numMois . "/" . $numAnnee ?> </option>
                    <?php
                        }
                    }

                    ?>

                </select>
            </p>
        </div>
        <div class="piedForm">
            <p>
                <input id="ok" class="btn btn-primary" type="submit" value="Rechercher" size="20" />
            </p>
        </div>

    </form>