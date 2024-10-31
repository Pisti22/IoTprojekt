__Schneider PM530 teljesítménymérőhöz készített szoftver/adatbázis/weblap__

Egy Python program kiolvassa az adatokat az eszközöböl MODBUS TCP/IP-n keresztül, majd feltölti őket elsődleges verizóban
egy AWS S3-ban lévő CSV fájlba. Később pedig egy helyben futó MySQL adatbázisba.

A mért adatokat egy weblapon jelenítjük meg aminek a backendje JavaScriptben, a frontendje pedig HTML-ben íródott.
Jelenleg az adatok bárhonnan elérhetjük domain névnek köszönhetően. (iotmero.com)
Később lehetséges hogy ez egy helyi weblap lesz.

__kiolvaso_szoftver_0.1__

Képest az adatok kiolvasására
Képes az adatok feltöltésére AWS S3 felhőbe
Az adatokat CSV fájlban tárolja

__kiolvaso_szoftver_0.2__

Bekerült a logging
Schedule hiba kijavítva



