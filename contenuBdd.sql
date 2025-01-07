-- Suppression des données dans la table Action
DELETE FROM Action;

-- Suppression des données dans la table TypeAction
DELETE FROM TypeAction;

-- Suppression des données dans la table Stage
DELETE FROM Stage;

-- Suppression des données dans la table Inscription
DELETE FROM Inscription;

-- Suppression des données dans la table Tuteur_Entreprise
DELETE FROM Tuteur_Entreprise;

-- Suppression des données dans la table Administrateur
DELETE FROM Administrateur;

-- Suppression des données dans la table Enseignant
DELETE FROM Enseignant;

-- Suppression des données dans la table Secretaire
DELETE FROM Secretaire;

-- Suppression des données dans la table Etudiant
DELETE FROM Etudiant;

-- Suppression des données dans la table Departement
DELETE FROM Departement;

-- Suppression des données dans la table Entreprise
DELETE FROM Entreprise;

-- Suppression des données dans la table Utilisateur
DELETE FROM Utilisateur;

-- Insertion dans la table Utilisateur
INSERT INTO Utilisateur (nom, prenom, email, telephone, login, motdepasse)
VALUES 
    ('Dupont', 'Jean', 'jean.dupont@email.com', '0102030405', 'jdupont', 'password123'),
    ('Martin', 'Claire', 'claire.martin@email.com', '0607080910', 'cmartin', 'password123');

-- Insertion dans la table Entreprise
INSERT INTO Entreprise (adresse, code_postal, ville, indicationVisite, tel)
VALUES 
    ('123 Rue de Paris', '75001', 'Paris', 'Entrer par la porte principale', '0123456789'),
    ('456 Avenue de Lyon', '69001', 'Lyon', 'Entrer par l’arrière', '0987654321');

-- Insertion dans la table Departement
INSERT INTO Departement (libelle, Bureau)
VALUES 
    ('Informatique', 'Bureau A'),
    ('Marketing', 'Bureau B');

-- Insertion dans la table Secretaire
INSERT INTO Secretaire (id_Departement)
VALUES 
    (1),
    (2);

-- Insertion dans la table Enseignant
INSERT INTO Enseignant (id_Departement, Bureau)
VALUES 
    (1, 'Bureau C'),
    (2, 'Bureau D');

-- Insertion dans la table Administrateur
INSERT INTO Administrateur (id_Utilisateur)
VALUES 
    (1),
    (2);

-- Insertion dans la table Tuteur_Entreprise
INSERT INTO Tuteur_Entreprise (id_Entreprise)
VALUES 
    (1),
    (2);

-- Insertion dans la table Etudiant
INSERT INTO Etudiant (id_Utilisateur, id_Departement)
VALUES 
    (1, 1),
    (2, 2);

-- Insertion dans la table Semestre
INSERT INTO Semestre (numSemestre, annee)
VALUES 
    (1, 2024),
    (2, 2024);

-- Insertion dans la table Stage
INSERT INTO Stage (id_Etudiant, id_TuteurEntreprise, id_Enseignant, date_debut, date_fin, sujet, lieu_soutenance, date_soutenance)
VALUES 
    (1, 1, 1, '2024-06-01', '2024-12-01', "Développement d\'une application web", 'Salle A', '2024-12-15'),
    (2, 2, 2, '2024-06-01', '2024-12-01', 'Stratégies marketing digital', 'Salle B', '2024-12-16');

-- Insertion dans la table TypeAction
INSERT INTO TypeAction (libelle, description)
VALUES 
    ('Réunion', 'Réunion de suivi de projet'),
    ('Rapport', "Rédaction d\'un rapport de stage");

-- Insertion dans la table Action
INSERT INTO Action (id_TypeAction, date_realisation, lienDocument)
VALUES 
    (1, '2024-06-15', 'documents/reunion_june.pdf'),
    (2, '2024-06-20', 'documents/rapport_june.pdf');

-- Insertion dans la table Inscription
INSERT INTO Inscription (id_Etudiant, id_Departement, numSemestre)
VALUES 
    (1, 1, 1),
    (2, 2, 2);
