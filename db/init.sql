CREATE EXTENSION IF NOT EXISTS pgcrypto;
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

CREATE TABLE Enseignant (
    id_enseignant INT PRIMARY KEY,
    bureau VARCHAR(50),
    FOREIGN KEY (id_enseignant) REFERENCES Utilisateur(Id) ON DELETE CASCADE
);


CREATE TABLE Etudiant (
    id_etudiant INT PRIMARY KEY,
    FOREIGN KEY (id_etudiant) REFERENCES Utilisateur(Id) ON DELETE CASCADE
);

CREATE TABLE Secretaire (
    id_secretaire INT PRIMARY KEY,
    FOREIGN KEY (id_secretaire) REFERENCES Utilisateur(Id) ON DELETE CASCADE
);

CREATE TABLE Tuteur_Entreprise (
    id_tuteur_entreprise INT PRIMARY KEY,
    FOREIGN KEY (id_tuteur_entreprise) REFERENCES Utilisateur(Id) ON DELETE CASCADE
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
    id_tuteur_pedagogique INT,
    id_tuteur_entreprise INT,
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
    FOREIGN KEY (Id_TypeAction) REFERENCES TypeAction(Id_TypeAction),
    CONSTRAINT unique_stage_action UNIQUE (Id_Stage, Id_TypeAction) -- Contrainte d'unicité
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

-- 10. Création de la table Administrateur
CREATE TABLE Administrateur (
    Id_Administrateur SERIAL PRIMARY KEY,
    CONSTRAINT fk_utilisateur FOREIGN KEY (Id_Administrateur) REFERENCES Utilisateur(Id) ON DELETE CASCADE
);

-- Création de la table Fichiers
CREATE TABLE Fichiers (
    id SERIAL PRIMARY KEY,
    id_stage INT NOT NULL,
    nom_fichier VARCHAR(255) NOT NULL,
    chemin_fichier VARCHAR(255) NOT NULL,
    date_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_stage) REFERENCES Stage(Id_Stage) ON DELETE CASCADE
);

CREATE TABLE Notifications (
    id_notification SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    message TEXT NOT NULL,
    type VARCHAR(50) DEFAULT 'info', -- 'success', 'error', 'info', etc.
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(Id) ON DELETE CASCADE
);


BEGIN;

-- Insérer l'admin dans la table Utilisateur
WITH new_user AS (
    INSERT INTO Utilisateur (nom, prenom, email, login, motdepasse, telephone) 
    VALUES ('Admin', 'Super', 'admin@example.com', 'admin', crypt('password123', gen_salt('bf')), '0601020304')
    RETURNING id
)
INSERT INTO Administrateur (Id_Administrateur) 
SELECT id FROM new_user;

COMMIT;

BEGIN;

-- Insérer les enseignants dans la table Utilisateur
WITH new_user AS (
    INSERT INTO Utilisateur (nom, prenom, email, login, motdepasse, telephone) 
    VALUES 
    ('Dupont', 'Pierre', 'enseignant1@example.com', 'enseignant1', crypt('password123', gen_salt('bf')), '0605060708'),
    ('Martin', 'Claire', 'enseignant2@example.com', 'enseignant2', crypt('password123', gen_salt('bf')), '0608091011'),
    ('Durand', 'Sophie', 'enseignant3@example.com', 'enseignant3', crypt('password123', gen_salt('bf')), '0612131415'),
    ('Morel', 'Julien', 'enseignant4@example.com', 'enseignant4', crypt('password123', gen_salt('bf')), '0623242526'),
    ('Dubois', 'Elodie', 'enseignant5@example.com', 'enseignant5', crypt('password123', gen_salt('bf')), '0634354647'),
    ('Lemoine', 'Paul', 'enseignant6@example.com', 'enseignant6', crypt('password123', gen_salt('bf')), '0645465768')
    RETURNING id
)
-- Insérer les enseignants dans la table Enseignant avec l'ID récupéré
INSERT INTO Enseignant (id_enseignant, bureau) 
SELECT id, 'Bureau 101' FROM new_user;

COMMIT;

BEGIN;

-- Insérer les étudiants dans la table Utilisateur
WITH new_user AS (
    INSERT INTO Utilisateur (nom, prenom, email, login, motdepasse, telephone) 
    VALUES 
    ('Lemoine', 'Paul', 'etudiant1@example.com', 'etudiant1', crypt('password123', gen_salt('bf')), '0611223344'),
    ('Dubois', 'Sophie', 'etudiant2@example.com', 'etudiant2', crypt('password123', gen_salt('bf')), '0612334455'),
    ('Morel', 'Julien', 'etudiant3@example.com', 'etudiant3', crypt('password123', gen_salt('bf')), '0613445566')
    RETURNING id
)   
-- Insérer les étudiants dans la table Etudiant avec l'ID récupéré
INSERT INTO Etudiant (id_etudiant) 
SELECT id FROM new_user;

COMMIT;

BEGIN;

-- Insérer les tuteurs d'entreprise dans la table Utilisateur
WITH new_user AS (
    INSERT INTO Utilisateur (nom, prenom, email, login, motdepasse, telephone) 
    VALUES 
    ('Durand', 'Marc', 'tuteur1@example.com', 'tuteur1', crypt('password123', gen_salt('bf')), '0655566778'),
    ('Martinez', 'Elodie', 'tuteur2@example.com', 'tuteur2', crypt('password123', gen_salt('bf')), '0656677889'),
    ('Gerrar', 'Pierre', 'tuteur3@example.com', 'tuteur3', crypt('password123', gen_salt('bf')), '0657788990')
    RETURNING id
)
-- Insérer les tuteurs dans la table Tuteur_Entreprise avec l'ID récupéré
INSERT INTO Tuteur_Entreprise (id_tuteur_entreprise) 
SELECT id FROM new_user;

COMMIT;


-- Ajouter des stages dans la table Stage
-- Insérer des stages dans la table Stage


INSERT INTO TypeAction (libelle, Executant, Destinataire, delaiEnJours, ReferenceDelai, requiertDoc, LienModeleDoc)
VALUES (
    'Demande de Stage',         -- Libellé de l'action
    'Etudiant',                -- Exécutant de l'action
    'Administrateur',          -- Destinataire de l'action
    7,                         -- Délai en jours pour la validation
    'Date de soumission',      -- Référence pour le calcul du délai
    FALSE,                     -- Pas de document requis
    NULL                       -- Pas de modèle de document
);

INSERT INTO TypeAction (libelle, Executant, Destinataire, delaiEnJours, ReferenceDelai, requiertDoc, LienModeleDoc)
VALUES
('Validation de Stage', 'Administrateur', 'Etudiant', 0, 'Date de validation', FALSE, NULL);


INSERT INTO Stage (id_etudiant, id_tuteur_pedagogique, id_tuteur_entreprise, mission, date_debut, date_fin)
VALUES
(8, 2, 11, 'Développement d''une application mobile', '2025-02-01', '2025-04-30'),
(9, 3, 12, 'Analyse de données et reporting', '2025-03-01', '2025-05-30'),  
(10, 4, 13, 'Déploiement d''un système d''information', '2025-04-01', '2025-06-30'),
(8, 5, 11, 'Conception et optimisation d''une base de données', '2025-05-01', '2025-07-31'),
(9, 6, 12, 'Développement d''un chatbot pour support client', '2025-06-01', '2025-08-31'),
(10, 7, 13, 'Mise en place d''un système de supervision réseau', '2025-07-01', '2025-09-30');



INSERT INTO Action (Id_Stage, Id_TypeAction, date_realisation, lienDocument)
VALUES
(1, 2, NOW(), NULL), -- Validation du stage 1
(2, 2, NOW(), NULL), -- Validation du stage 2
(3, 2, NOW(), NULL), -- Validation du stage 3
(4, 2, NOW(), NULL), -- Validation du stage 4
(5, 2, NOW(), NULL), -- Validation du stage 5
(6, 2, NOW(), NULL); -- Validation du stage 6