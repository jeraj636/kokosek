DROP DATABASE kokosek;
CREATE DATABASE kokosek CHARACTER SET utf8mb4;
USE kokosek;
CREATE OR REPLACE TABLE status(
        id_statusa INT PRIMARY KEY AUTO_INCREMENT,
        naziv VARCHAR(100) NOT NULL UNIQUE
    );
CREATE OR REPLACE TABLE uporabnik(
        id_uporabnika INT PRIMARY KEY AUTO_INCREMENT,
        up_ime VARCHAR(200) NOT NULL UNIQUE,
        up_geslo VARCHAR(255) NOT NULL
    );
CREATE OR REPLACE TABLE uporabnik_status(
        id_uporabnika INT,
        id_statusa INT,
        PRIMARY KEY(id_uporabnika, id_statusa),
        CONSTRAINT uporabnik_status_uporabnik FOREIGN KEY (id_uporabnika) REFERENCES uporabnik(id_uporabnika),
        CONSTRAINT uporabnik_status_status FOREIGN KEY (id_statusa) REFERENCES status(id_statusa)
    );
CREATE OR REPLACE TABLE kazino(
        id_denarnice INT PRIMARY KEY AUTO_INCREMENT,
        id_uporabnika INT UNIQUE,
        st_jajc INT NOT NULL,
        CONSTRAINT kazino_uporabnik FOREIGN KEY (id_uporabnika) REFERENCES uporabnik(id_uporabnika)
    );
CREATE OR REPLACE TABLE tip_misli(
        id_tipa_misli INT PRIMARY KEY AUTO_INCREMENT,
        naziv_tipa_misli VARCHAR(100) NOT NULL
    );
CREATE OR REPLACE TABLE misel(
        id_misli INT PRIMARY KEY AUTO_INCREMENT,
        id_tipa_misli INT NOT NULL,
        datum_objave DATE NOT NULL,
        naslov VARCHAR(400) NOT NULL,
        pot_do_misli VARCHAR(500) NOT NULL,
        CONSTRAINT misel_tip_misli FOREIGN KEY (id_tipa_misli) REFERENCES tip_misli(id_tipa_misli)
    );
CREATE OR REPLACE TABLE avtor(
        id_avtorja INT PRIMARY KEY AUTO_INCREMENT,
        ime VARCHAR(100) NOT NULL,
        priimek VARCHAR(100) NOT NULL
    );
CREATE OR REPLACE TABLE pesem(
        id_pesmi INT PRIMARY KEY AUTO_INCREMENT,
        naslov VARCHAR(100) NOT NULL,
        pot VARCHAR(200) NOT NULL
    );
CREATE OR REPLACE TABLE pesem_avtor (
        id_pesmi INT NOT NULL,
        id_avtorja INT NOT NULL,
        CONSTRAINT pesem_avtor_pesem FOREIGN KEY (id_pesmi) REFERENCES pesem(id_pesmi),
        CONSTRAINT pesem_avtor_avtor FOREIGN KEY (id_avtorja) REFERENCES avtor(id_avtorja)
    );
CREATE OR REPLACE TABLE kategorija(
        id_kategorije INT PRIMARY KEY AUTO_INCREMENT,
        naziv_kategorije VARCHAR(100) NOT NULL,
        id_nad_kategorije INT,
        CONSTRAINT kategorija_kategorija FOREIGN KEY(id_nad_kategorije) REFERENCES kategorija(id_kategorije)
    );
CREATE OR REPLACE TABLE pesem_kategorija(
        id_pesmi INT NOT NULL,
        id_kategorije INT NOT NULL,
        CONSTRAINT pesem_kategorija_kategorija FOREIGN KEY(id_kategorije) REFERENCES kategorija(id_kategorije),
        CONSTRAINT pesem_kategorija_pesem FOREIGN KEY(id_pesmi) REFERENCES pesem(id_pesmi)
    );
INSERT INTO status(naziv)
VALUES('admin'),
    ('blokiran'),
    ('kockar');
INSERT INTO tip_misli(naziv_tipa_misli)
VALUES('jakob_thout'),
    ('kroky_review');
--selewcti
SELECT COUNT(*)
FROM uporabnik
    INNER JOIN uporabnik_status USING(id_uporabnika)
WHERE up_ime = 'Jakob'
    AND id_statusa IN (
        SELECT id_statusa
        FROM status
        WHERE naziv = 'admin'
    );
SELECT id_uporabnika,
    up_ime,
    st_jajc,
    GROUP_CONCAT(naziv SEPARATOR ', ') AS nazivi
FROM uporabnik
    INNER JOIN kazino USING (id_uporabnika)
    LEFT JOIN uporabnik_status USING (id_uporabnika)
    LEFT JOIN status USING (id_statusa)
GROUP BY id_uporabnika;
INSERT INTO uporabnik_status
VALUES(
        (
            SELECT id_uporabnika
            FROM uporabnik
            WHERE up_ime = ?
        ),
        (
            SELECT id_statusa
            FROM status
            WHERE naziv = ?
        )
    )
DELETE FROM uporabnik_status
WHERE id_uporabnika = (
        SELECT id_uporabnika
        FROM uporabnik
        WHERE up_ime = 'Jakob2'
    )
    AND id_statusa = (
        SELECT id_statusa
        FROM status
        WHERE naziv = 'admin'
    );
INSERT INTO misel(
        id_tipa_misli,
        datum_objave,
        naslov,
        pot_do_misli
    )
VALUES(
        (
            SELECT id_tipa_misli
            FROM tip_misli
            WHERE naziv_tipa_misli = ?
        ),
        ?,
        ?,
        ?
    );
)
SELECT id_misli,
    naslov,
    pot_do_misli,
    datum_objave,
    naziv_tipa_misli
FROM misel
    INNER JOIN tip_misli USING(id_tipa_misli);
-----
-----
WITH RECURSIVE category_path AS (
    SELECT id_kategorije,
        naziv_kategorije,
        id_nad_kategorije,
        naziv_kategorije AS path
    FROM kategorija
    WHERE id_nad_kategorije IS NULL
    UNION ALL
    SELECT k.id_kategorije,
        k.naziv_kategorije,
        k.id_nad_kategorije,
        CONCAT(cp.path, '/', k.naziv_kategorije) AS path
    FROM kategorija k
        INNER JOIN category_path cp ON k.id_nad_kategorije = cp.id_kategorije
)
SELECT cp.id_kategorije AS id_kategorije,
    cp.path AS hierarhija
FROM category_path cp;