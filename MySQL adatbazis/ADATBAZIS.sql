CREATE DATABASE  adatbazis;
USE adatbazis;

CREATE TABLE tulajdonsagok (
    register_id INT(32) PRIMARY KEY,  
    mertekegyseg VARCHAR(50),           
    megnevezes VARCHAR(255)                     
);


CREATE TABLE  eszkozok (
    eszkoz_id INT(32) PRIMARY KEY,      
    helye VARCHAR(255),                   
    tipus VARCHAR(255),                 
    gyarto VARCHAR(255)                   
);


CREATE TABLE  hisztorikus (
    datum DATETIME,                       
    register_id INT(32),               
    meres FLOAT(32,5),                 
    eszkoz_id INT(32),                  
    FOREIGN KEY (register_id) REFERENCES tulajdonsagok(register_id),  
    FOREIGN KEY (eszkoz_id) REFERENCES eszkozok(eszkoz_id)   
);

CREATE TABLE  pillanatnyi (
    datum DATETIME,                       
    register_id INT(32),               
    meres FLOAT(32,5),                 
    eszkoz_id INT(32),                  
    FOREIGN KEY (register_id) REFERENCES tulajdonsagok(register_id),  
    FOREIGN KEY (eszkoz_id) REFERENCES eszkozok(eszkoz_id)   
);


INSERT INTO eszkozok(eszkoz_id,helye,tipus,gyarto)
VALUES(1,'home','PM5340','Schneider');

INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3028,'V','U1');
INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3030,'V','U2');
INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3032,'V','U3');


INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3000,'A','I1');
INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3002,'A','I2');
INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3004,'A','I3');

INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3060,'kW','P');
INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3068,'kVAR','Q');
INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3076,'kVA','S');



INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3110,'Hz','f');

INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3196,0,'IEC');

INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3208,'Wh','P');
INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3241,'kVARh','Q');
INSERT INTO tulajdonsagok(register_id,mertekegyseg,megnevezes)
VALUES(3240,'kVAh','S');











