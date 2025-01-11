<?php
class Stage {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllStages() {
        $query = $this->pdo->query("
            SELECT Stage.Id_Stage, Utilisateur.nom AS etudiant_nom, Stage.mission 
            FROM Stage
            JOIN Utilisateur ON Stage.id_etudiant = Utilisateur.Id
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
