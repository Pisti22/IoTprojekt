INSERT INTO eszkozok (eszkoz_id) VALUES (2);
INSERT INTO eszkozok (eszkoz_id) VALUES (3);
INSERT INTO eszkozok (eszkoz_id) VALUES (4);
INSERT INTO eszkozok (eszkoz_id) VALUES (5);
INSERT INTO eszkozok (eszkoz_id) VALUES (6);
UPDATE pillanatnyi SET eszkoz_id=1 WHERE register_id=3028;
UPDATE pillanatnyi SET eszkoz_id=2 WHERE register_id=3030;
UPDATE pillanatnyi SET eszkoz_id=3 WHERE register_id=3032;
UPDATE pillanatnyi SET eszkoz_id=4 WHERE register_id=3000;
UPDATE pillanatnyi SET eszkoz_id=5 WHERE register_id=3002;
UPDATE pillanatnyi SET eszkoz_id=6 WHERE register_id=3004;


UPDATE pillanatnyi SET register_id=3000,eszkoz_id=1 WHERE eszkoz_id=1;
UPDATE pillanatnyi SET register_id=3002,eszkoz_id=1 WHERE eszkoz_id=2;
UPDATE pillanatnyi SET register_id=3004,eszkoz_id=1 WHERE eszkoz_id=3;
UPDATE pillanatnyi SET register_id=3028,eszkoz_id=1 WHERE eszkoz_id=4;
UPDATE pillanatnyi SET register_id=3030,eszkoz_id=1 WHERE eszkoz_id=5;
UPDATE pillanatnyi SET register_id=3032,eszkoz_id=1 WHERE eszkoz_id=6;

DELETE FROM eszkozok WHERE eszkoz_id=2;
DELETE FROM eszkozok WHERE eszkoz_id=3;
DELETE FROM eszkozok WHERE eszkoz_id=4;
DELETE FROM eszkozok WHERE eszkoz_id=5;
DELETE FROM eszkozok WHERE eszkoz_id=6;
