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

Összes jelenleg használt python modul: __boto3, pymodbus, AWS CLI!!!!__

---html_es_weblap_0.1---

Minden fájl AWS S3 bucketbe van feltöltve (iotmero.com) és az oldal elérhető az iotmero.com domainen.
Mindegyik oldal egy külön HTML, a főoldal (IoT_weblap.html) és a Hisztorikus adatok (page2.html) oldal kódjába van beleírva a JavaScript is.
Az adatbazis.csv állományból JavaScript olvassa be az adatokat az adott oldal betöltésekor.
Hogy az adatok frissülhessenek, az oldal 45 mp-ként automatikusan újratölt.

---linux_ubuntu---

A projekt teljesítéséhez a programnak linuxon kell futnia.
Virtualbox-ban Ubuntu 24.04 van telepítve.
Ehhez még a további szoftverek telepítésre várnak.



