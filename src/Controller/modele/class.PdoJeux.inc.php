<?php

/**
 *  AGORA
 * 	©  Logma, 2019
 * @package default
 * @author MD
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 * 
 * Classe d'accès aux données. 
 * Utilise les services de la classe PDO
 * pour l'application AGORA
 * Les attributs sont tous statiques,
 * $monPdo de type PDO 
 * $monPdoJeux qui contiendra l'unique instance de la classe
 */
class PdoJeux
{

    private static $monPdo;
    private static $monPdoJeux = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct()
    {
        try {
            // encodage
            $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'');
            // Crée une instance (un objet) PDO qui représente une connexion à la base
            PdoJeux::$monPdo = new PDO($_ENV['AGORA_DSN'], $_ENV['AGORA_DB_USER'], $_ENV['AGORA_DB_PWD'], $options);
            // configure l'attribut ATTR_ERRMODE pour définir le mode de rapport d'erreurs 
            // PDO::ERRMODE_EXCEPTION: émet une exception 
            PdoJeux::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // configure l'attribut ATTR_DEFAULT_FETCH_MODE pour définir le mode de récupération par défaut 
            // PDO::FETCH_OBJ: retourne un objet anonyme avec les noms de propriétés 
            //     qui correspondent aux noms des colonnes retournés dans le jeu de résultats
            PdoJeux::$monPdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {	// $e est un objet de la classe PDOException, il expose la description du problème
            die('<section id="main-content"><section class="wrapper"><div class = "erreur">Erreur de connexion à la base de données !<p>'
                . $e->getmessage() . '</p></div></section></section>');
        }
    }

    /**
     * Destructeur, supprime l'instance de PDO  
     */
    public function _destruct()
    {
        PdoJeux::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoJeux = PdoJeux::getPdoJeux();
     * 
     * @return l'unique objet de la classe PdoJeux
     */
    public static function getPdoJeux()
    {
        if (PdoJeux::$monPdoJeux == null) {
            PdoJeux::$monPdoJeux = new PdoJeux();
        }
        return PdoJeux::$monPdoJeux;
    }

    //==============================================================================
    //
    //	METHODES POUR LA GESTION DES GENRES
    //
    //==============================================================================

    /**
     * Retourne tous les genres sous forme d'un tableau d'objets 
     * avec le nombre de jeux pour chaque genre
     * 
     * @return array le tableau d'objets (Genre)
     */
    public function getLesGenres(): array
    {
        $requete = 'SELECT g.idGenre as identifiant, 
                       g.libGenre as libelle,
                       COUNT(j.refJeu) as nbJeux
                FROM genre g
                LEFT JOIN jeu_video j ON g.idGenre = j.idGenre
                GROUP BY g.idGenre, g.libGenre
                ORDER BY g.libGenre';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbGenres = $resultat->fetchAll();
            return $tbGenres;
        } catch (PDOException $e) {
            die('<div class="erreur">Erreur dans la requête !<p>'
                . $e->getMessage() . '</p></div>');
        }
    }


     //==============================================================================
    //
    //	METHODES POUR LA GESTION DES JEUX
    //
    //==============================================================================


    /**
     * Retourne tous les jeux sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Jeux)
     */
    public function getLesJeux(): array
    {
        $requete = 'SELECT refJeu as identifiant, nom as nom, nomMarque as marque, 
						libGenre as genre, libPlateforme as plateforme, ageLimite as pegi, prix as prix, dateParution as dateParution 
						FROM jeu_video
						NATURAL JOIN plateforme
						NATURAL JOIN marque
						NATURAL JOIN genre
                        NATURAL JOIN pegi
						ORDER BY nom';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbJeux = $resultat->fetchAll();
            return $tbJeux;
        } catch (PDOException $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Ajoute un nouveau jeu avec le nom donné en paramètre
     * 
     * @param string $nomJeu : le nom du jeu à ajouter
     * @param string $marqueJeu : la marque du jeu à ajouter
     * @param string $genreJeu : le genre du jeu à ajouter
     * @param string $plateformeJeu : la plateforme du jeu à ajouter
     * @param int $pegiJeu : le pegi du jeu à ajouter
     * @param float $prixJeu : le prix du jeu à ajouter
     * @param string $dateParutionJeu : la date de parution du jeu
     */
    public function ajouterJeu(string $refJeu, string $nomJeu, string $marqueJeu, string $genreJeu, string $plateformeJeu, string $pegiJeu, float $prixJeu, string $dateParutionJeu): int
    {
        try {
            // Vérification de l'existence
            $check = PdoJeux::$monPdo->prepare("SELECT refJeu FROM jeu_video WHERE refJeu = :refJeu");
            $check->bindParam(':refJeu', $refJeu, PDO::PARAM_STR);
            $check->execute();

            if ($check->rowCount() > 0) {
                throw new Exception("Un jeu avec la référence '$refJeu' existe déjà dans la base");
            }

            // Formatage de la date au format français
            $date = \DateTime::createFromFormat('Y-m-d', $dateParutionJeu);
            if ($date === false) {
                throw new Exception("Format de date invalide");
            }
            $dateFr = $date->format('d/m/Y');

            $requete_prepare = PdoJeux::$monPdo->prepare(
                "INSERT INTO jeu_video (refJeu, nom, idMarque, idGenre, idPlateforme, idPegi, prix, dateParution) 
                 VALUES (:uneRefJeu, :unNom, 
                        (SELECT idMarque FROM marque WHERE nomMarque = :uneMarque), 
                        (SELECT idGenre FROM genre WHERE libGenre = :unGenre), 
                        (SELECT idPlateforme FROM plateforme WHERE libPlateforme = :unePlateforme), 
                        (SELECT idPegi FROM pegi WHERE ageLimite = :unPegi),
                        :unPrix, 
                        STR_TO_DATE(:uneDateParution, '%d/%m/%Y'))"
            );

            $requete_prepare->bindParam(':uneRefJeu', $refJeu, PDO::PARAM_STR);
            $requete_prepare->bindParam(':unNom', $nomJeu, PDO::PARAM_STR);
            $requete_prepare->bindParam(':uneMarque', $marqueJeu, PDO::PARAM_STR);
            $requete_prepare->bindParam(':unGenre', $genreJeu, PDO::PARAM_STR);
            $requete_prepare->bindParam(':unePlateforme', $plateformeJeu, PDO::PARAM_STR);
            $requete_prepare->bindParam(':unPegi', $pegiJeu, PDO::PARAM_STR);
            $requete_prepare->bindParam(':unPrix', $prixJeu, PDO::PARAM_STR);
            $requete_prepare->bindParam(':uneDateParution', $dateFr, PDO::PARAM_STR);

            $requete_prepare->execute();
            return 1;

        } catch (PDOException $e) {
            // Afficher plus de détails sur l'erreur SQL
            die('<div class="erreur">Erreur SQL : ' . $e->getCode() . '<p>'
                . $e->getMessage() . '</p></div>');
        } catch (Exception $e) {
            die('<div class="erreur">Erreur : <p>' . $e->getMessage() . '</p></div>');
        }
    }

    /**
     * Modifie toutes les informations d'un jeu vidéo
     * 
     * @param string $refJeu : l'identifiant du jeu à modifier  
     * @param string $nomJeu : le nom modifié
     * @param string $nomMarque : le nom de la marque modifiée
     * @param string $libGenre : le libellé du genre modifié
     * @param string $libPlateforme : le libellé de la plateforme modifiée
     * @param int $idPegi : l'id du pegi modifié
     * @param float $prixJeu : le prix modifié
     * @param string $dateParutionJeu : la date de parution modifiée
     */
    public function modifierJeu(
        string $refJeu,
        string $nomJeu,
        string $nomMarque,
        string $libGenre,
        string $libPlateforme,
        int $idPegi,
        float $prixJeu, // Ajout du paramètre prix manquant
        string $dateParutionJeu // Ajout du paramètre date manquant
    ): void {
        try {
            // Conversion des libellés en ids
            $sqlMarque = "SELECT idMarque FROM marque WHERE nomMarque = :nomMarque";
            $stmtMarque = self::$monPdo->prepare($sqlMarque);
            $stmtMarque->bindParam(':nomMarque', $nomMarque, PDO::PARAM_STR);
            $stmtMarque->execute();
            $idMarque = $stmtMarque->fetchColumn();

            $sqlGenre = "SELECT idGenre FROM genre WHERE libGenre = :libGenre";
            $stmtGenre = self::$monPdo->prepare($sqlGenre);
            $stmtGenre->bindParam(':libGenre', $libGenre, PDO::PARAM_STR);
            $stmtGenre->execute();
            $idGenre = $stmtGenre->fetchColumn();

            $sqlPlateforme = "SELECT idPlateforme FROM plateforme WHERE libPlateforme = :libPlateforme";
            $stmtPlateforme = self::$monPdo->prepare($sqlPlateforme);
            $stmtPlateforme->bindParam(':libPlateforme', $libPlateforme, PDO::PARAM_STR);
            $stmtPlateforme->execute();
            $idPlateforme = $stmtPlateforme->fetchColumn();

            // Mise à jour du jeu
            $requete_prepare = self::$monPdo->prepare("UPDATE jeu_video 
                SET nom = :unNom, 
                    idMarque = :unIdMarque, 
                    idGenre = :unIdGenre, 
                    idPlateforme = :unIdPlateforme, 
                    idPegi = :unIdPegi,
                    prix = :unPrix,
                    dateParution = :uneDateParution
                WHERE refJeu = :unRefJeu");
                
            $requete_prepare->bindParam(':unRefJeu', $refJeu, PDO::PARAM_STR);
            $requete_prepare->bindParam(':unNom', $nomJeu, PDO::PARAM_STR);
            $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unIdPlateforme', $idPlateforme, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unPrix', $prixJeu, PDO::PARAM_STR); // Changé de PARAM_INT à PARAM_STR
            $requete_prepare->bindParam(':uneDateParution', $dateParutionJeu, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }

    /**
     * Supprime le genre donné en paramètre
     * 
     * @param int $idGenre :l'identifiant du genre à supprimer 
     */
    public function supprimerJeu(string $refJeu): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM jeu_video "
                . "WHERE jeu_video.refJeu = :unRefJeu");
            $requete_prepare->bindParam(':unRefJeu', $refJeu, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }

    public function getIdPegiFromAgeLimite($ageLimite)
    {
        $sql = "SELECT idPegi FROM pegi WHERE ageLimite = :ageLimite";
        $stmt = self::$monPdo->prepare($sql);
        $stmt->bindParam(':ageLimite', $ageLimite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn(); // Retourne l'idPegi correspondant
    }

    //==============================================================================
    //
    //	METHODES POUR LA GESTION DES MARQUES
    //
    //==============================================================================

    /**
     * Retourne toutes les marque sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Marque)
     */
    public function getLesMarques(): array
    {
        $requete = 'SELECT idMarque as identifiant, nomMarque as nom 
						FROM marque
						ORDER BY nomMarque';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbMarques = $resultat->fetchAll();
            return $tbMarques;
        } catch (PDOException $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }



    /**
     * Ajoute une nouvelle marque avec le nom donné en paramètre
     * 
     * @param string $nomMarque : le nom de la marque à ajouter
     * @return int l'identifiant de la marque crée
     */
    public function ajouterMarque(string $nomMarque): int
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO marque "
                . "(idMarque, nomMarque) "
                . "VALUES (0, :unNomMarque) ");
            $requete_prepare->bindParam(':unNomMarque', $nomMarque, PDO::PARAM_STR);
            $requete_prepare->execute();
            // récupérer l'identifiant crée
            return PdoJeux::$monPdo->lastInsertId();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Modifie le nom de la marque donné en paramètre
     * 
     * @param int $idMarque : l'identifiant de la marque à modifier  
     * @param string $nomMarque : le nom modifié
     */
    public function modifierMarque(int $idMarque, string $nomMarque): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE marque "
                . "SET nomMarque = :unNomMarque "
                . "WHERE marque.idMarque = :unIdMarque");
            $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unNomMarque', $nomMarque, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Supprime la marque donnée en paramètre
     * 
     * @param int $idMarque :l'identifiant de la marque à supprimer 
     */
    public function supprimerMarque(int $idMarque): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM marque "
                . "WHERE marque.idMarque = :unIdMarque");
            $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    //==============================================================================
    //
    //	METHODES POUR LA GESTION DES PEGIS
    //
    //==============================================================================

    /**
     * Retourne tous les pegis sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Pegi)
     */
    public function getLesPegis(): array
    {
        $requete = 'SELECT idPegi as identifiant, ageLimite as ageLimite, descPegi as description
                        FROM pegi 
                        ORDER BY ageLimite';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbPegis = $resultat->fetchAll();
            return $tbPegis;
        } catch (PDOException $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }

    }

    /**
     * Ajoute un nouveau pegi avec l'âge limite et la description donnés en paramètre
     * 
     * @param int $ageLimite : l'âge limite du pegi
     * @param string $descPegi : la description du pegi à ajouter
     * @return int l'identifiant du pegi créé
     */
    public function ajouterPegi(int $ageLimite, string $descPegi): int
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO pegi "
                . "(ageLimite, descPegi) "
                . "VALUES (:unAgeLimite, :uneDescPegi) ");
            $requete_prepare->bindParam(':unAgeLimite', $ageLimite, PDO::PARAM_INT);
            $requete_prepare->bindParam(':uneDescPegi', $descPegi, PDO::PARAM_STR);
            $requete_prepare->execute();
            // récupérer l'identifiant créé
            return PdoJeux::$monPdo->lastInsertId();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }

    /**
     * Modifie le libellé du pegi donné en paramètre
     * 
     * @param int $idPegi : l'identifiant du pegi à modifier  
     * @param string $ageLimite : le libellé modifié
     * @param string $descPegi : la description modifiée
     */
    public function modifierPegi(int $idPegi, string $ageLimite, string $descPegi): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE pegi "
                . "SET ageLimite = :unAgeLimite, descPegi = :uneDescPegi "
                . "WHERE pegi.idPegi = :unIdPegi");
            $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unAgeLimite', $ageLimite, PDO::PARAM_STR);
            $requete_prepare->bindParam(':uneDescPegi', $descPegi, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }
    /**
     * Supprime le pegi donné en paramètre
     * 
     * @param int $idPegi :l'identifiant du pegi à supprimer 
     */
    public function supprimerPegi(int $idPegi): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM pegi "
                . "WHERE pegi.idPegi = :unIdPegi");
            $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    //==============================================================================
    //
    //	METHODES POUR LA GESTION DES PLATEFORMES
    //
    //==============================================================================
    /**
     * Retourne tous les plateformes sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Plateforme)
     */
    public function getLesPlateformes(): array
    {
        $requete = 'SELECT idPlateforme as identifiant, libPlateforme as libelle 
                        FROM plateforme 
                        ORDER BY libPlateforme';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbPlateformes = $resultat->fetchAll();
            return $tbPlateformes;
        } catch (PDOException $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }

    /**
     * Ajoute un nouveau plateforme avec le libellé donné en paramètre
     * 
     * @param string $libPlateforme : le libelle du plateforme à ajouter
     * @return int l'identifiant du plateforme crée
     */
    public function ajouterPlateforme(string $libPlateforme): int
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO plateforme "
                . "(idPlateforme, libPlateforme) "
                . "VALUES (0, :unLibPlateforme) ");
            $requete_prepare->bindParam(':unLibPlateforme', $libPlateforme, PDO::PARAM_STR);
            $requete_prepare->execute();
            // récupérer l'identifiant crée
            return PdoJeux::$monPdo->lastInsertId();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }

    /**
     * Modifie le libellé du plateforme donné en paramètre
     * 
     * @param int $idPlateforme : l'identifiant du plateforme à modifier  
     * @param string $libPlateforme : le libellé modifié
     */
    public function modifierPlateforme(int $idPlateforme, string $libPlateforme): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE plateforme "
                . "SET libPlateforme = :unLibPlateforme "
                . "WHERE plateforme.idPlateforme = :unIdPlateforme");
            $requete_prepare->bindParam(':unIdPlateforme', $idPlateforme, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unLibPlateforme', $libPlateforme, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }

    /**
     * Supprime le plateforme donné en paramètre
     * 
     * @param int $idPlateforme :l'identifiant du plateforme à supprimer 
     */
    public function supprimerPlateforme(int $idPlateforme): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM plateforme "
                . "WHERE plateforme.idPlateforme = :unIdPlateforme");
            $requete_prepare->bindParam(':unIdPlateforme', $idPlateforme, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }

    //==============================================================================
    //
    //	METHODES POUR LA GESTION DES MEMBRES
    //
    //==============================================================================

    /**
     * Retourne tous les membres sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets (Membre)
     */
    public function getLesMembres(): array
    {
        $requete = 'SELECT idMembre as identifiant, nomMembre as nom, 
                       prenomMembre as prenom, mailMembre as email
                FROM membre 
                ORDER BY nomMembre, prenomMembre';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbMembres = $resultat->fetchAll();
            return $tbMembres;
        } catch (PDOException $e) {
            die('<div class="erreur">Erreur dans la requête !<p>'
                . $e->getMessage() . '</p></div>');
        }
    }
}

?>