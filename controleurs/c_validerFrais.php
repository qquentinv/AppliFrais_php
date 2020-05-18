<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
switch($action){
    case 'selectionnerVisiteurMois':{
		$lesVisiteurs=$pdo->getToutesLesVisiteurs();
		$LesKeys = array_keys($lesVisiteurs);
		$visiteurASelectionner = $LesKeys[0];
		
		$lesMois=$pdo->getLesMoisDisponibles($visiteurASelectionner);
		$lesCles = array_keys($lesMois);
		$moisASelectionner = $lesCles[0];
		include("vues/v_listeVisiteurMois.php");
		break;
	}
	case'affichageFrais':{
		$leVisiteur = $_REQUEST['lstVisiteur'];
		$leMois = $_REQUEST['lstMois'];
		header('location: index.php?uc=validerFrais&action=voirFicheFrais&lstVisiteur='.$leVisiteur.'&lstMois='.$leMois);
		break;
	};
	case 'voirFicheFrais':{
		$leVisiteur = $_GET['lstVisiteur'];
		$leMois = $_GET['lstMois'];

		if(isset($_GET["sure"])){
			$letat= "VA";
			//total des Frais forfait
			$LesFraisForfaitACalc = $pdo->getLesFraisForfait($leVisiteur, $leMois);
			$LesTauxFraisForfait = $pdo->getTauxFraisForfait();
			$TotFichesFrais = 0;
			for($k=0; $k < count($LesFraisForfaitACalc); $k++){
				$TotFichesFrais = $TotFichesFrais + $LesFraisForfaitACalc[$k]['quantite']*$LesTauxFraisForfait[$k]['montant'];
			}
			//total des frais hors forfait
			$TotFraisHF = $pdo->sumMontantFicheFraisHF($leVisiteur, $leMois);

			//Cumule des deux totals
			$TotFrais = $TotFichesFrais + $TotFraisHF;
			$pdo->majMontantValideFicheFrais($leVisiteur, $leMois, $TotFrais);
			$pdo->majEtatFicheFrais($leVisiteur,$leMois,$letat);
		}
		if (isset($_GET["ETP"])) {
			$ETP = $_GET['ETP'];
			$KM = $_GET['KM'];
			$NUI= $_GET['NUI'];
			$REP = $_GET['REP'];
			$lesFrais = ['ETP' => $ETP, 'KM'=> $KM, 'NUI' => $NUI, 'REP'=> $REP];
			$pdo->majFraisForfait($leVisiteur, $leMois, $lesFrais);
		}
		if (isset($_GET["modifierJR"])) { //non focntionnel pour justificatif
			$pdo->majNbJustificatifs($leVisiteur, $leMois, $_GET['modifierJR']);
		}
		//fichefrais hors forfait
		if (isset($_GET["modifyId"])) {
			$pdo->majFraisHorsForfait($_GET["modifyId"], $_GET["libelleLHF"],$_GET["dateLHF"], $_GET["montantLHF"]);
		}
		if (isset($_GET["deleteId"])) {
			$pdo->supprimerFraisHorsForfait($_GET["deleteId"]); //Ajouter dans les fonctions 
		} 
		if(isset($_GET['report'])){
			if(substr($leMois, 4, 2) != "12"){
				$reportMois = $leMois + 1;
			}
			else{
				$lannee = substr($leMois, 0, 4);
				$lannee = $lannee + 1;
				$reportMois = (string)$lannee;
				$reportMois = $reportMois."01";
			}
			if($pdo->estPremierFraisMois($leVisiteur,$reportMois)){
				$pdo->creeNouvellesLignesFrais($leVisiteur,$reportMois);
			}
			$pdo->supprimerFraisHorsForfait($_GET["report"]);
			$pdo->creeNouveauFraisHorsForfait($leVisiteur,$reportMois,$_GET['LLHF'],$_GET['DLHF'],$_GET['MLHF']);
		}
		   
		$lesVisiteurs=$pdo->getToutesLesVisiteurs();
		$lesMois=$pdo->getLesMoisDisponibles($leVisiteur);
		$visiteurASelectionner = $leVisiteur;
		$moisASelectionner = $leMois;
		include("vues/v_listeVisiteurMois.php");
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($leVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_validerFicheFrais.php");
	}
}
?>