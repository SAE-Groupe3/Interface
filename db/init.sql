-- Fichier SQL pour la gestion des stages à l'IUT de Villetaneuse basé sur le MCD fourni

-- 1. Création de la table Utilisateur
CREATE TABLE Utilisateur (
    Id SERIAL PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    login VARCHAR(50) NOT NULL,
    motdepasse VARCHAR(255) NOT NULL
);

-- 2. Création de la table Entreprise
CREATE TABLE Entreprise (
    Id_Entreprise SERIAL PRIMARY KEY,
    adresse VARCHAR(255) NOT NULL,
    code_postal VARCHAR(10),
    ville VARCHAR(100),
    indicationVisite VARCHAR(255),
    tel VARCHAR(20)
);

-- 3. Création de la table Stage
CREATE TABLE Stage (
    Id_Stage SERIAL PRIMARY KEY,
    id_etudiant INT NOT NULL,
    id_tuteur_pedagogique INT NOT NULL,
    id_tuteur_entreprise INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    mission TEXT NOT NULL,
    date_soutenance DATE,
    salle_soutenance VARCHAR(50),
    FOREIGN KEY (id_etudiant) REFERENCES Utilisateur(Id),
    FOREIGN KEY (id_tuteur_pedagogique) REFERENCES Utilisateur(Id),
    FOREIGN KEY (id_tuteur_entreprise) REFERENCES Utilisateur(Id)
);

-- 4. Création de la table TypeAction
CREATE TABLE TypeAction (
    Id_TypeAction SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    Executant VARCHAR(50),
    Destinataire VARCHAR(50),
    delaiEnJours INT,
    ReferenceDelai VARCHAR(100),
    requiertDoc BOOLEAN,
    LienModeleDoc VARCHAR(255)
);

-- 5. Création de la table Action
CREATE TABLE Action (
    Id_Action SERIAL PRIMARY KEY,
    Id_Stage INT NOT NULL,
    Id_TypeAction INT NOT NULL,
    date_realisation DATE,
    lienDocument VARCHAR(255),
    FOREIGN KEY (Id_Stage) REFERENCES Stage(Id_Stage),
    FOREIGN KEY (Id_TypeAction) REFERENCES TypeAction(Id_TypeAction)
);

-- 6. Création de la table Département
CREATE TABLE Departement (
    Id_Departement SERIAL PRIMARY KEY,
    Libelle VARCHAR(100) NOT NULL
);

-- 7. Création de la table Semestre
CREATE TABLE Semestre (
    numSemestre INT PRIMARY KEY
);

-- 8. Création de la table Inscription
CREATE TABLE Inscription (
    id_etudiant INT NOT NULL,
    Id_Departement INT NOT NULL,
    numSemestre INT NOT NULL,
    PRIMARY KEY (id_etudiant, Id_Departement, numSemestre),
    FOREIGN KEY (id_etudiant) REFERENCES Utilisateur(Id),
    FOREIGN KEY (Id_Departement) REFERENCES Departement(Id_Departement),
    FOREIGN KEY (numSemestre) REFERENCES Semestre(numSemestre)
);

-- 9. Création de la table Jury
CREATE TABLE Jury (
    Id_Jury SERIAL PRIMARY KEY,
    id_stage INT NOT NULL,
    id_enseignant INT NOT NULL,
    FOREIGN KEY (id_stage) REFERENCES Stage(Id_Stage),
    FOREIGN KEY (id_enseignant) REFERENCES Utilisateur(Id)
);

-- 10. Création de la table Enseignant
CREATE TABLE Enseignant (
    Id_Enseignant SERIAL PRIMARY KEY,
    Bureau VARCHAR(50)
);

-- 11. Création de la table Administrateur
CREATE TABLE Administrateur (
    Id_Administrateur SERIAL PRIMARY KEY
);

-- Insertion de quelques données de test
INSERT INTO Utilisateur (nom, prenom, email, telephone, login, motdepasse) VALUES
('Dupont', 'Jean', 'jean.dupont@example.com', '0601020304', 'jdupont', 'password123'),
('Martin', 'Claire', 'claire.martin@example.com', '0605060708', 'cmartin', 'password123');

INSERT INTO Entreprise (adresse, code_postal, ville, indicationVisite, tel) VALUES
('123 Rue de Paris', '75001', 'Paris', '1er étage', '0147253648');

INSERT INTO Stage (id_etudiant, id_tuteur_pedagogique, id_tuteur_entreprise, date_debut, date_fin, mission) VALUES
(1, 2, 1, '2025-01-15', '2025-03-15', 'Développement dune application web');

INSERT INTO TypeAction (libelle, Executant, Destinataire, delaiEnJours, ReferenceDelai, requiertDoc, LienModeleDoc) VALUES
('Compte rendu dinstallation', 'Etudiant', 'Tuteur pédagogique', 7, 'date_debut', TRUE, 'modele_compte_rendu.pdf');
