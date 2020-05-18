<div id="contenu">
    <h2>Suivi de paiement des fiches de frais</h2>
    <div style="margin:15px; text-align:center">
        <input type="submit" onclick="MiseEnPaiement()" class="btn btn-primary" value="Mettre en paiement" />
        <input type="submit" onclick="ConfirmerRemboursement()" class="btn btn-success" value="Confirmer le remboursement" size="20" />
    </div>
    <div style="display:flex;" class="encadre">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">
                        <div class="form-check">
                            <input class="form-check-input" onclick="Touscheck()" type="checkbox" value="" id="defaultCheck1">
                        </div>
                    </th>
                    <th scope="col">Visiteur</th>
                    <th scope="col">Mois</th>
                    <th scope="col">Montant Validée</th>
                    <th scope="col">Date de modification</th>
                    <th scope="col">Etat</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"></th>
                    <td> <select class="form-control" id="lstVisiteur">
                        <option disabled selected value> -- selectionner un visiteur -- </option>
                            <?php foreach ($LesVisiteurs as $unVisiteur) {
                                $idVis = $unVisiteur['id'];
                                $nomVis = $unVisiteur['nom'];
                                $prenomVis = $unVisiteur['prenom'];
                            ?>
                                <option value="<?php echo $idVis?>"><?php echo $nomVis . " " . $prenomVis; ?></option>
                            <?php } ?>
                        </select></td>
                    <td><input type="text" class="form-control" id="Mois" placeholder="AAAA-MM"></td>
                    <td><input type="text" class="form-control" id="montant"></td>
                    <td><input type="text" class="form-control" id="DateModif" placeholder="AAAA-MM-JJ"></td>
                    <td> <select class="form-control" id="Etat">
                    <option disabled selected value> -- selectionner un état -- </option>
                            <?php foreach ($LesEtats as $unEtat) {
                                $idEtat = $unEtat['libelle'];
                            ?>
                                <option value="<?php echo $idEtat;?>"><?php echo $idEtat; ?></option>
                            <?php } ?>
                        </select></td>
                    <td style="text-align:center;">
                        <buttton type="submit" class="btn btn-primary" onClick="recherche()"><svg class="bi bi-search" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 011.415 0l3.85 3.85a1 1 0 01-1.414 1.415l-3.85-3.85a1 1 0 010-1.415z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 100-11 5.5 5.5 0 000 11zM13 6.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" clip-rule="evenodd" />
                            </svg></buttton>
                    </td>
                </tr>

                <?php
                foreach ($LesFichesFrais as $uneFichesFrais) {
                    $idVis = $uneFichesFrais['idVis'];
                    $nomVis = $uneFichesFrais['nomVis'];
                    $prenomVis = $uneFichesFrais['prenomVis'];
                    $mois = $uneFichesFrais['mois'];
                    $montantVal = $uneFichesFrais['montantVal'];
                    $dateModif = $uneFichesFrais['dateModif'];
                    $etat = $uneFichesFrais['etatlibelle'];
                ?>
                    <tr>
                        <th scope="row">
                            <div class="form-check">
                                <input class="element-check" type="checkbox" name="<?php echo $idVis;?> <?php echo $mois?>"  value="" id="defaultCheck1">
                            </div>
                        </th>
                        <td><?php echo $nomVis . " " . $prenomVis ?></td>
                        <td><?php echo substr($mois, 0, 4) . "-" . substr($mois, 4, 2) ?></td>
                        <td><?php echo $montantVal ?></td>
                        <td><?php echo $dateModif ?></td>
                        <td><?php echo $etat ?></td>
                        <td style="text-align:center;">
                            <button id="ok" class="btn btn-light"  type="submit" onClick="changePage('<?php echo $idVis ?>','<?php echo $mois; ?>')">
                                <svg class="bi bi-eye-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5 8a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <script>
            function Touscheck(){
                var checkbox = document.getElementsByClassName('element-check');
                for(const k of checkbox){
                    k.checked = !k.checked;
                }
            }
            function MiseEnPaiement(){
                var checkbox = document.getElementsByClassName('element-check');
                for(const k of checkbox){
                    if(k.checked){
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'index.php?uc=suiviFrais&action=misePaiement');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.send(encodeURI('visiteur='+k.name.split(' ')[0])+'&mois='+k.name.split(' ')[1]);
                    }
                }
                var loc = window.location;
                window.location = loc.protocol + '//' + loc.host + loc.pathname +"?uc=suiviFrais&action=suiviPayement";
            }   
            function ConfirmerRemboursement(){
                var checkbox = document.getElementsByClassName('element-check');
                for(const k of checkbox){
                    if(k.checked){
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'index.php?uc=suiviFrais&action=confirmationPaiement');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.send(encodeURI('visiteur='+k.name.split(' ')[0])+'&mois='+k.name.split(' ')[1]);
                    }
                }
                var loc = window.location;
                window.location = loc.protocol + '//' + loc.host + loc.pathname +"?uc=suiviFrais&action=suiviPayement";
            }
            function recherche(){
                var id = document.getElementById("lstVisiteur");
                var moissaisi = document.getElementById("Mois");
                var monVal = document.getElementById("montant");
                var dateModif = document.getElementById("DateModif");
                var etat = document.getElementById("Etat");

                var loc = window.location;
                window.location = loc.protocol + '//' + loc.host + loc.pathname +"?uc=suiviFrais&action=suiviPayement" +  "&id="+ id.value + "&mois=" + moissaisi.value.substr(0,4) + moissaisi.value.substr(5,2) 
                + "&montVal=" + monVal.value + "&dM=" + dateModif.value + "&Etat=" + etat.value;
            }
            function changePage(vis, mois) {
                var loc = window.location;
                window.location = loc.protocol + '//' + loc.host + loc.pathname + "?uc=suiviFrais&action=consultPayement&idVis=" + vis + "&moisSaisi=" + mois;
            }
        </script>
    </div>
</div>