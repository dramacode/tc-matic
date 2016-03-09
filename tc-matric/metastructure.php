<?php
// nom 	: metastructure.php
// auteur 	: Paul Fièvre
// date 	: 11/05/10
// maj 		: 27/05/10
// appelant : (à la demande)
// appelé 	: aucun
// paramètre : aucun
// fonction : Permet de contruitre la métastructure de requête et d'affichage des textes
//

ini_set('max_execution_time','600');
$fsortie=fopen("./metastructure.xml","w");

fwrite($fsortie, "<?xml version='1.0' encoding='iso-8859-1'?>
<metastructure>
<header>
		<fileDesc>
			<titleStmt>
				<title>METASTRUCTURE DU SITE theatre_classique.FR</title>
				<author>FIEVRE, Paul</author>
				<date>20130202</date>
			</titleStmt>
		</fileDesc>
</header>
<body>
");
$z=0;
$n=1;
if ($handle = opendir('../documents')) {
	// INITIALiSATION DES VARIABLES POUR CHAQUE TEXTE
	$totalNombreActes=0;
	$totalNombrePersonnages=0;
	$totalNombreScenes=0;
	$totalNombreRepliques=0;
	$totalNombreVers=0;
	$totalNombreLignes=0;
	$totalNombreMots=0;
	$totalNombreCaracteres=0;
	$totalNombrePersonnages=0;
	$maxNombreActes=0;
	$maxNombrePersonnages=0;
	$maxNombreScenes=0;
	$maxNombreRepliques=0;
	$maxNombreVers=0;
	$maxNombreLignes=0;
	$maxNombreMots=0;
	$maxNombreCaracteres=0;
	$maxNombrePersonnages=0;

	$minNombreActes=100;
	$minNombrePersonnages=1000;
	$minNombreScenes=1000;
	$minNombreRepliques=10000;
	$minNombreVers=100000;
	$minNombreLignes=100000;
	$minNombreMots=100000;
	$minNombreCaracteres=1000000;
	$minNombrePersonnages=1000;

	$medNombreActes=0;
	$medNombrePersonnages=0;
	$medNombreScenes=0;
	$medNombreRepliques=0;
	$medNombreVers=0;
	$medNombreLignes=0;
	$medNombreMots=0;
	$medNombreCaracteres=0;
	$medNombrePersonnages=0;
	$auteur='';
    while (false !== ($file = readdir($handle))) {
		$z++;
		$nombreActes=0;
		$nombrePersonnages=0;
		$nombreScenes=0;
		$nombreRepliques=0;
		$nombreMots=0;
		$nombreVers=0;
		$nombreLignes=0;
		$nombreCaracteres=0;
		$nombrePersonnages=0;
		$nombrePhrase=0;
		$totalNombreMots = 0;
		$totalNombreCaracteres = 0;
		$totalNombreLignes = 0;
		
		if ($file != "." && $file != "..") {
			$nomFichierTexte="../documents/".$file;
			$contenuFichierTexte=file_get_contents ($nomFichierTexte);
			$xmlContenuFichierTexte=simplexml_load_string( $contenuFichierTexte);
			$titre=utf8_decode(trim($xmlContenuFichierTexte->text->front->docTitle->titlePart));
			$auteur=trim($xmlContenuFichierTexte->text->front->docAuthor['id']);
			$lAuteur=utf8_decode($auteur);
				$laBio=trim($xmlContenuFichierTexte->text->front->docAuthor['bio']);
				$laDate=trim($xmlContenuFichierTexte->text->front->docDate['value']);
				$naissance=utf8_decode(trim($xmlContenuFichierTexte->teiHeader->fileDesc->titleStmt->author['born']));
				$lieu_naissance=utf8_decode(trim($xmlContenuFichierTexte->teiHeader->fileDesc->titleStmt->author['born_location']));
				$deces=trim($xmlContenuFichierTexte->teiHeader->fileDesc->titleStmt->author['death']);
				$lieu_deces=utf8_decode(trim($xmlContenuFichierTexte->teiHeader->fileDesc->titleStmt->author['death_location']));
				$academie=trim($xmlContenuFichierTexte->teiHeader->fileDesc->titleStmt->author['academie']);
		  
			$permalien=utf8_decode(trim($xmlContenuFichierTexte->teiHeader->fileDesc->SourceDesc->permalien));
			$monGenre=utf8_decode(trim($xmlContenuFichierTexte->teiHeader->fileDesc->SourceDesc->genre));
			$monInspiration=utf8_decode(trim($xmlContenuFichierTexte->teiHeader->fileDesc->SourceDesc->inspiration));
			$maStructure=utf8_decode(trim($xmlContenuFichierTexte->teiHeader->fileDesc->SourceDesc->structure));
			$monTypeTexte=utf8_decode(trim($xmlContenuFichierTexte->teiHeader->fileDesc->SourceDesc->type));
			$maPeriode=trim($xmlContenuFichierTexte->teiHeader->fileDesc->SourceDesc->periode);
			$maTaille=trim($xmlContenuFichierTexte->teiHeader->fileDesc->SourceDesc->taille);
						
			$set_location=utf8_decode(trim($xmlContenuFichierTexte->text->front->set['location']));
			$set_country=utf8_decode(trim($xmlContenuFichierTexte->text->front->set['country']));
			$set_periode=utf8_decode(trim($xmlContenuFichierTexte->text->front->set['periode']));
		
			$premiere_location=utf8_decode(trim($xmlContenuFichierTexte->text->front->performance->premiere['location']));
			$premiere_date=utf8_decode(trim($xmlContenuFichierTexte->text->front->performance->premiere['date']));
		
			//************ PERSONNAGES 
			$varPersonnages="";
			foreach ($xmlContenuFichierTexte->text->front->castList as $groupeDistribution) {
				foreach ($groupeDistribution->castItem as $laDistribution) {

					$monType="---";
					$monStatut="---";
					$monAge="---";
					$monCivil="---";
					
					$monRole=utf8_decode(trim($laDistribution->role));
					$monRoleId=utf8_decode(trim($laDistribution->role['id']));
					
					$monCivil=utf8_decode(trim($laDistribution->role['civil']));
					$monType=utf8_decode(trim($laDistribution->role['type']));
					$monStatut=utf8_decode(trim($laDistribution->role['statut']));
					$monAge=utf8_decode(trim($laDistribution->role['age']));
					$monStatutAmoureux=utf8_decode(trim($laDistribution->role['stat_amour']));

					$nombrePersonnages = $nombrePersonnages + 1;
					
					//$varPersonnages=$varPersonnages.'\r\n<role civil="'.$monCivil.'" type="'.$monType.'" id="'.$monRoleId.'" statut="'.$monStatut.'">'.$monRole.'</role>';
					$varPersonnages=$varPersonnages.'<role civil="'.$monCivil.'" id="'.$monRoleId.'" statut="'.$monStatut.'" type="'.$monType.'" age="'.$monAge.'">'.$monRole.'</role>';
					
				}
			}
			//*********** Fin PERSONNAGE
			if ($nombrePersonnages > $maxNombrePersonnages) $maxNombrePersonnages = $nombrePersonnages;
			if ($nombrePersonnages < $minNombrePersonnages) $minNombrePersonnages = $nombrePersonnages;
			$totalNombrePersonnages = $totalNombrePersonnages + $nombrePersonnages;
		foreach ($xmlContenuFichierTexte->text->body->div1 as $acte) {
			$nombreActes = $nombreActes + 1;
			foreach ($acte->div2 as $scene) {
				$nombreScenes = $nombreScenes + 1;
				foreach ($scene->sp as $sp) {
					$nombreRepliques = $nombreRepliques + 1;
					foreach ($sp->l as $ligne) {
						$nombreLignes = $nombreLignes + 1;
						$nombreVers = trim($ligne['id']);
						if ($nombreVers =="") {
							$nombreVers = trim($ligne['n']);
						}
						$lignePlate = preg_replace( "/<[^>]*>/", "", $ligne->asXML());
						$lignePlate=utf8_decode($lignePlate);
						//$motsDeLaLigne = preg_split("/[\s?!.':;,\"]+/",$lignePlate, -1,PREG_SPLIT_NO_EMPTY);
						$motsDeLaLigne = preg_split("/[\s?!.': ;,\"]+/",$lignePlate, -1,PREG_SPLIT_NO_EMPTY);
						$nombreMots = count($motsDeLaLigne);
							
						$nombreCaracteres = $nombreCaracteres + strlen($lignePlate);
						$totalNombreMots = $totalNombreMots + $nombreMots;
						$totalNombreCaracteres = $totalNombreCaracteres + strlen($lignePlate);
						$totalNombreLignes = $totalNombreLignes + 1;
					}
					foreach ($sp->poem->lg->l as $ligne) {
						$nombreLignes = $nombreLignes + 1;
						$nombreVers = trim($ligne['id']);
						$lignePlate = preg_replace( "/<[^>]*>/", "", $ligne->asXML());
						$lignePlate=utf8_decode($lignePlate);
						$motsDeLaLigne = preg_split("/[\s?!.':;,\"]+/",$lignePlate, -1,PREG_SPLIT_NO_EMPTY);
						$nombreMots = count($motsDeLaLigne);
							
						$nombreCaracteres = $nombreCaracteres + strlen($lignePlate);
						$totalNombreMots = $totalNombreMots + $nombreMots;
						$totalNombreCaracteres = $totalNombreCaracteres + strlen($lignePlate);
						$totalNombreLignes = $totalNombreLignes + 1;
					}
					foreach ($sp->lg->lg->l as $ligne) {
						$nombreLignes = $nombreLignes + 1;
						$nombreVers = trim($ligne['id']);
						$lignePlate = preg_replace( "/<[^>]*>/", "", $ligne->asXML());
						$lignePlate=utf8_decode($lignePlate);
						$motsDeLaLigne = preg_split("/[\s?!.':;,\"]+/",$lignePlate, -1,PREG_SPLIT_NO_EMPTY);
						$nombreMots = count($motsDeLaLigne);
							
						$nombreCaracteres = $nombreCaracteres + strlen($lignePlate);
						$totalNombreMots = $totalNombreMots + $nombreMots;
						$totalNombreCaracteres = $totalNombreCaracteres + strlen($lignePlate);
						$totalNombreLignes = $totalNombreLignes + 1;
					}

					foreach ($sp->p as $paragraphe) {
						foreach ($paragraphe->s as $ligne) {
							$nombreLignes = $nombreLignes + 1;
							$nombrePhrase = $nombrePhrase+1;
							$lignePlate=preg_replace( "/<[^>]*>/", "", $ligne->asXML());
							$lignePlate=utf8_decode($lignePlate);
							$motsDeLaLigne = preg_split("/[\s?!.':;,\"]+/",$lignePlate, -1,PREG_SPLIT_NO_EMPTY);
							$nombreMots = count($motsDeLaLigne);
							
							$nombreCaracteres = $nombreCaracteres + strlen($lignePlate);
							$totalNombreMots = $totalNombreMots + $nombreMots;
							$totalNombreCaracteres = $totalNombreCaracteres + strlen($lignePlate);
							$totalNombreLignes = $totalNombreLignes + 1;
						}
					}
				}
			}
		}
		$totalNombreRepliques = $totalNombreRepliques + $nombreRepliques;
		if ($nombreRepliques > $maxNombreRepliques) $maxNombreRepliques=$nombreRepliques;
		if ($nombreRepliques < $minNombreRepliques) $minNombreRepliques=$nombreRepliques;
		$tableauRepliques[] = $nombresRepliques;
		$totalNombreActes = $totalNombreActes + $nombreActes;
		if ($nombreActes > $maxNombreActes) $maxNombreActes=$nombreActes;
		if ($nombreActes < $minNombreActes) $minNombreActes=$nombreActes;

		$totalNombreScenes = $totalNombreScenes + $nombreScenes;
		if ($nombreScenes > $maxNombreScenes) $maxNombreScenes=$nombreScenes;
		if ($nombreScenes < $minNombreScenes) $minNombreScenes=$nombreScenes;

		$totalNombreVers = $totalNombreVers + $nombreVers;
		if ($nombreVers > $maxNombreVers) $maxNombreVers=$nombreVers;
		if ($nombreVers < $minNombreVers) $minNombreVers=$nombreVers;

		if ($nombreMots > $maxNombreMots) $maxNombreMots=$nombreMots;
		if ($nombreMots < $minNombreMots) $minNombreMots=$nombreMots;

		if ($nombreCaracteres > $maxNombreCaracteres) $maxNombreCaracteres=$nombreCaracteres;
		if ($nombreCaracteres < $minNombreCaracteres) $minNombreCaracteres=$nombreCaracteres;
		if ($nombreLignes > $maxNombreLignes) $maxNombreLignes=$nombreLignes;
		if ($nombreLignes < $minNombreLignes) $minNombreLignes=$nombreLignes;
		
		echo "=== $auteur - $titre";
		
		fwrite($fsortie, "<record id='$n' file='$file'>
		<auteur>
			<name>$lAuteur</name>
			<born>$naissance</born>
			<bornLocation>$lieu_naissance</bornLocation>
			<death>$deces</death>
			<deathLocation>$lieu_deces</deathLocation>
			<academie>$academie</academie>
			<bio>$laBio</bio> 
		</auteur>
		<texte>
			<titre date='$laDate'>$titre</titre>
			<permalien>$permalien</permalien>
			<inspiration>$monInspiration</inspiration>
			<genre>$monGenre</genre>
			<structure>$maStructure</structure>
			<taille>$maTaille</taille>
			<typeTexte>$monTypeTexte</typeTexte>
			<periode>$maPeriode</periode>
			<set>
				<location>$set_location</location>
				<country>$set_country</country>
				<periode>$set_periode</periode>
			</set>
			<premiere>
				<location>$premiere_location</location>
				<date>$premiere_date</date>
			</premiere>
			<personnages>$varPersonnages</personnages>
		</texte>
		<statistique>
			<nbPersonnages>$nombrePersonnages</nbPersonnages>
			<nbActes>$nombreActes</nbActes>
			<nbScenes>$nombreScenes</nbScenes>
			<nbRepliques>$nombreRepliques</nbRepliques>
			<nbLignes>$nombreLignes</nbLignes>
			<nbPhrases>$nombreLignes</nbPhrases>
			<nbVers>$nombreVers</nbVers>
			<nbMots>$totalNombreMots</nbMots>");
			
		if ($nombreCaracteres < 20000) {
			$leType="0-20000";
		}
		else {
			if ($nombreCaracteres < 40000) {
				$leType="20001-40000";
			}
			else {
				if ($nombreCaracteres < 60000) {
					$leType="40001-60000";
				}
				else {
					if ($nombreCaracteres < 80000) {
						$leType="60001-80000";
					}
					else {
						if ($nombreCaracteres < 100000) {
							$leType="80001-100000";
						}
						else {
							if ($nombreCaracteres < 120000) {
								$leType="120001-140000";
							}
							else {
								$leType="plus de 140001";
						}
						}
					}
				}
			}
		}
	
		fwrite($fsortie, "	<nbCaracteres type='$leType'>$nombreCaracteres</nbCaracteres>");
		if ($nombreVers > 0) {
			$fractionnement=(($nombreLignes-$nombreVers)/$nombreVers)*100;
			$fractionnement=number_format($fractionnement,2, ',', ' ');
			}
			else
			{
			$fractionnement='N/A';
		}
		fwrite($fsortie, "	<ifractionnement>$fractionnement</ifractionnement>");
		if ($nombreVers > 0) {
			$versParReplique=$nombreVers/$nombreRepliques;
			$versParReplique=number_format($versParReplique,2, ',', ' ');
			}
			else
			{
			$versParReplique='N/A';
		}
		fwrite($fsortie, "	<versParReplique>$versParReplique</versParReplique>");
		if ($nombreVers > 0) {
			$caractereParVers = $nombreCaracteres / $nombreVers ;
			$caractereParVers=number_format($caractereParVers,2, ',', ' ');
			}
			else
			{
			$caractereParVers='N/A';
		}
		fwrite($fsortie, "	<caractereParVers>$caractereParVers</caractereParVers>
		</statistique>
		</record>\n");
		$n=$n+1;
        }
    }
    closedir($handle);
}
$n=$n-1;
// FERMETURE DU FICHIER
fwrite($fsortie, "</body>
</metastructure>");
fclose ($fsortie);
?>