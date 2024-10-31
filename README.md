Schneider PM530 teljesítménymérőhöz készített szoftver.

Egy Python program kiolvassa az adatokat az eszközöböl MODBUS TCP/IP-n keresztül, majd feltölti őket elsődleges verizóban
egy AWS S3-ban lévő CSV fájlba. Később pedig egy helyben futó MySQL adatbázisba.

A mért adatokat egy weblapon jelenítjük meg aminek a backendje JavaScriptben, a frontendje pedig HTML-ben íródott.
Jelenleg az adatok bárhonnan elérhetjük domain névnek köszönhetően. (iotmero.com)
Később lehetséges hogy ez egy helyi weblap lesz.

kiolvaso_szoftver_0.1
-Képest az adatok kiolvasására
-Képes az adatok feltöltésére AWS S3 felhőbe
-Az adatokat CSV fájlban tárolja

kiolvaso_szoftver_0.2
-Bekerült a logging
-Schedule hiba kijavítva



