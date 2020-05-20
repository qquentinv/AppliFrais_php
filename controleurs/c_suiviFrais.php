<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
switch($action){
    case 'suiviPayement':{
		$LesFichesFrais = $pdo->getTousLesFichesFrais();

		if (isset($_GET["id"])and $_GET["id"]!='') {
            $LesFichesFrais = array_filter($LesFichesFrais, function($var) {
                return $var['idVis'] === $_GET['id'];
            });
        }
		if (isset($_GET["mois"])and $_GET["mois"]!='') {
			$LesFichesFrais = array_filter($LesFichesFrais, function($var) {
                return $var['mois'] === $_GET['mois'];
            });	
		}
		if (isset($_GET["montVal"])and $_GET["montVal"]!='') {
			$LesFichesFrais = array_filter($LesFichesFrais, function($var) {
                return $var['montantVal'] === $_GET['montVal'];
            });	
		}
		if (isset($_GET["dM"]) and $_GET["dM"]!='') {
			$LesFichesFrais = array_filter($LesFichesFrais, function($var) {
                return $var['dateModif'] === $_GET['dM'];
            });	
		}
		if (isset($_GET["Etat"])and $_GET["Etat"]!='') {
			$LesFichesFrais = array_filter($LesFichesFrais, function($var) {
                return $var['etatlibelle'] === $_GET['Etat'];
            });	
		}

		$LesVisiteurs = $pdo->getToutesLesVisiteurs();
		$LesEtats = $pdo->getTousLesEtats();
		include("vues/v_suiviPaiement.php");
		break;
	}
	case 'consultPayement':{
		$vis = $_GET['idVis'];
		$mois = $_GET['moisSaisi'];
		$InfosVisiteur = $pdo->getInfosVisiteurParId($vis);
		$InfosFichesFrais = $pdo->getLesInfosFicheFrais($vis,$mois);
		$InfosFraisHF = $pdo->getLesFraisHorsForfait($vis,$mois);

		$TotFraisHF = $pdo->sumMontantFicheFraisHF($vis, $mois);

		$LesFraisForfaitACalc = $pdo->getLesFraisForfait($vis, $mois);
		$LesTauxFraisForfait = $pdo->getTauxFraisForfait();
		
		$TotFichesFrais = 0;
		for($k=0; $k < count($LesFraisForfaitACalc); $k++){
			$TotFichesFrais = $TotFichesFrais + $LesFraisForfaitACalc[$k]['quantite']*$LesTauxFraisForfait[$k]['montant'];
		}

		$TotalMontantFrais = $TotFichesFrais + $TotFraisHF;

		include("vues/v_detailsFicheFrais.php");
		break;
	}
	case 'misePaiement':{
		$visiteur = $_POST['visiteur'];
		$mois = $_POST['mois'];
		$pdo->majEtatFicheFrais($visiteur, $mois, "VA");
		break;
	}
	case 'confirmationPaiement':{
		$visiteur = $_POST['visiteur'];
        $mois = $_POST['mois'];
        $pdo->majEtatFicheFrais($visiteur, $mois, "RB");
		break;
}
}
?>