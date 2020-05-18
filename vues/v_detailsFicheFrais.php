<div id="contenu">
    <h2>La fiche de frais du <?php echo substr($mois, 4, 2) . "-" . substr($mois, 0, 4)  ?></h2>
    <h5 style="text-decoration: underline">Informations :</h5>
    <h3>
        Visiteur : <?php echo $InfosVisiteur[0]['nom'] . " " . $InfosVisiteur[0]['prenom'] ?></br>
        Etat : <?php echo $InfosFichesFrais['libEtat'] ?> </br>
        Montant Validé : <?php echo $InfosFichesFrais['montantValide'] ?></br>
    </h3>
    <h5 style="text-decoration: underline">Eléments forfaitisés :</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Frais</th>
                <th scope="col">Montant unitaire</th>
                <th scope="col">Quantité</th>
                <th scope="col">Montant total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Forfait Etape</th>
                <td><?php echo $LesTauxFraisForfait[0]['montant'] ?></td>
                <td><?php echo $LesFraisForfaitACalc[0]['quantite'] ?></td>
                <td><?php echo $LesTauxFraisForfait[0]['montant']*$LesFraisForfaitACalc[0]['quantite'] ?></td>
            </tr>
            <tr>
                <th scope="row">Frais Kilométrique</th>
                <td><?php echo $LesTauxFraisForfait[1]['montant'] ?></td>
                <td><?php echo $LesFraisForfaitACalc[1]['quantite'] ?></td>
                <td><?php echo $LesTauxFraisForfait[1]['montant']*$LesFraisForfaitACalc[1]['quantite'] ?></td>
            </tr>
            <tr>
                <th scope="row">Nuitée Hôtel</th>
                <td><?php echo $LesTauxFraisForfait[2]['montant'] ?></td>
                <td><?php echo $LesFraisForfaitACalc[2]['quantite'] ?></td>
                <td><?php echo $LesTauxFraisForfait[2]['montant']*$LesFraisForfaitACalc[2]['quantite'] ?></td>
            </tr>
            <tr>
                <th scope="row">Repas Restaurant</th>
                <td><?php echo $LesTauxFraisForfait[3]['montant'] ?></td>
                <td><?php echo $LesFraisForfaitACalc[3]['quantite'] ?></td>
                <td><?php echo $LesTauxFraisForfait[3]['montant']*$LesFraisForfaitACalc[3]['quantite'] ?></td>
            </tr>
            <tr>
                <th scope="row">Montant total</th>
                <td></td>
                <td></td>
                <td style="font-weight:bold"><?php echo $TotFichesFrais.'€' ?></td>
            </tr>
        </tbody>
    </table>
    <h5 style="text-decoration: underline">Eléments hors forfait - <?php echo $InfosFichesFrais['nbJustificatifs'] ?> justificatif reçus:</h5> <!-- remplacé nb -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Libelle</th>
                <th scope="col">Montant</th>
        </thead>
        <tbody>
            <?php
            foreach ($InfosFraisHF as $uneInfosFraisHF) {
                $date = $uneInfosFraisHF['date'];
                $libelle = $uneInfosFraisHF['libelle'];
                $montant = $uneInfosFraisHF['montant'];
            
            ?>
            <!-- foreach pour afficher toutes les lignes de frais -->
            <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td style="font-weight:bold">Montant total</td>
                <td></td>
                <td style="font-weight:bold"><?php echo $TotFraisHF.'€'?></td>
            </tr>
        </tbody>
    </table>
    <h5 style="text-decoration: underline">Total des frais :</h5> 
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Total Frais Forfaitisés</th>
                <th scope="col">Total Frais Hors Forfait</th>
                <th scope="col">Total des frais rembourser</th>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $TotFichesFrais.'€' ?></td>
                <td><?php echo $TotFraisHF.'€'?></td>
                <td style="font-weight:bold"><?php echo $TotalMontantFrais.'€'?></td>
            </tr>
        </tbody>
    </table>
</div>