-- Table Utilisateur
CREATE TABLE Utilisateur (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telephone VARCHAR(15),
    login VARCHAR(50) UNIQUE NOT NULL,
    motdepasse VARCHAR(255) NOT NULL
);

-- Table Entreprise
CREATE TABLE Entreprise (
    id_Entreprise SERIAL PRIMARY KEY,
    adresse VARCHAR(255) NOT NULL,
    code_postal VARCHAR(10),
    ville VARCHAR(100),
    indicationVisite TEXT,
    tel VARCHAR(15)
);

-- Table Departement
CREATE TABLE Departement (
    id_Departement SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    Bureau VARCHAR(50)
);

-- Table Secretaire
CREATE TABLE Secretaire (
    id_Secretaire SERIAL PRIMARY KEY,
    id_Departement INT NOT NULL,
    FOREIGN KEY (id_Departement) REFERENCES Departement(id_Departement)
);

-- Table Enseignant
CREATE TABLE Enseignant (
    id_Enseignant SERIAL PRIMARY KEY,
    id_Departement INT NOT NULL,
    Bureau VARCHAR(50),
    FOREIGN KEY (id_Departement) REFERENCES Departement(id_Departement)
);

-- Table Administrateur
CREATE TABLE Administrateur (
    id_Administrateur SERIAL PRIMARY KEY,
    id_Utilisateur INT NOT NULL,
    FOREIGN KEY (id_Utilisateur) REFERENCES Utilisateur(id)
);

-- Table Tuteur_Entreprise
CREATE TABLE Tuteur_Entreprise (
    id_TuteurEntreprise SERIAL PRIMARY KEY,
    id_Entreprise INT NOT NULL,
    FOREIGN KEY (id_Entreprise) REFERENCES Entreprise(id_Entreprise)
);

-- Table Etudiant
CREATE TABLE Etudiant (
    id_Etudiant SERIAL PRIMARY KEY,
    id_Utilisateur INT NOT NULL,
    id_Departement INT NOT NULL,
    FOREIGN KEY (id_Utilisateur) REFERENCES Utilisateur(id),
    FOREIGN KEY (id_Departement) REFERENCES Departement(id_Departement)
);

-- Table Semestre
CREATE TABLE Semestre (
    numSemestre INT PRIMARY KEY,
    annee INT NOT NULL
);

-- Table Stage
CREATE TABLE Stage (
    id_Stage SERIAL PRIMARY KEY,
    id_Etudiant INT NOT NULL,
    id_TuteurEntreprise INT NOT NULL,
    id_Enseignant INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    sujet TEXT,
    lieu_soutenance VARCHAR(255),
    date_soutenance DATE,
    FOREIGN KEY (id_Etudiant) REFERENCES Etudiant(id_Etudiant),
    FOREIGN KEY (id_TuteurEntreprise) REFERENCES Tuteur_Entreprise(id_TuteurEntreprise),
    FOREIGN KEY (id_Enseignant) REFERENCES Enseignant(id_Enseignant)
);

-- Table TypeAction
CREATE TABLE TypeAction (
    id_TypeAction SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    description TEXT
);

-- Table Action
CREATE TABLE Action (
    id_Action SERIAL PRIMARY KEY,
    id_TypeAction INT NOT NULL,
    date_realisation DATE NOT NULL,
    lienDocument VARCHAR(255),
    FOREIGN KEY (id_TypeAction) REFERENCES TypeAction(id_TypeAction)
);

-- Table Inscription
CREATE TABLE Inscription (
    id_Etudiant INT NOT NULL,
    id_Departement INT NOT NULL,
    numSemestre INT NOT NULL,
    PRIMARY KEY (id_Etudiant, id_Departement, numSemestre),
    FOREIGN KEY (id_Etudiant) REFERENCES Etudiant(id_Etudiant),
    FOREIGN KEY (id_Departement) REFERENCES Departement(id_Departement),
    FOREIGN KEY (numSemestre) REFERENCES Semestre(numSemestre)
);

