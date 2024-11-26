
import logging.handlers
import schedule
import time 
import logging
import asyncio
import sys
import mysql.connector
from pymodbus.client import ModbusTcpClient 
from pymodbus.payload import BinaryPayloadDecoder
from pymodbus.constants import Endian
from datetime import datetime 

#/opt/lampp/htdocs/iot_projekt/.venv/bin/python -m pip install pymodbus

logger=logging.getLogger(__name__)
logger.addHandler(logging.StreamHandler(sys.stdout))
logging.basicConfig(filename='szoftver.log', level=logging.INFO)


host = '192.168.1.32' 
port = '502'

client = ModbusTcpClient(host, port=port) 


if not  client.connect():
    logger.error("Nem sikerült csatlakozni!")
    sys.exit(1)
else:
    logger.info("Sikerült csatlakozni!")


reg = [3027,3029,3031,2999,3001,3003,3075,3059,3067,3109,3195,3239,3207,3223] 


Regiszterek = [3028,3030,3032,3000,3002,3004,3076,3060,3068,3110,3196,3240,3208,3224]
                #u1,u2,u3 fesz   i1,i2,i3 áramerősség                   frekvencia,  IEc,           kumulált látsz,hat,meddő energiamenny
                #(3070,3072,3074)látszólagos telj,       (3054,3056,3058, )hatásos teljesitmeny    (3062,3064,3066,)meddő teljesitmeny

#i1,i2,i3,u1,u2,u3,hat,medd,látsz,frek,iec,kumhat,med,látsz

def olvas():

    olvasott = [] 
    n=0
    
    for beolvasott in reg:

        if beolvasott == 3239 or beolvasott == 3207 or beolvasott == 3223:

            x = client.read_holding_registers(beolvasott, 4, 255) 

            decoder=BinaryPayloadDecoder.fromRegisters(x.registers,byteorder=Endian.BIG, wordorder=Endian.BIG)
            y=decoder.decode_64bit_int() 


        else:

            x = client.read_holding_registers(beolvasott, 2, 255) 
        
            decoder=BinaryPayloadDecoder.fromRegisters(x.registers,byteorder=Endian.BIG, wordorder=Endian.BIG)
            y=decoder.decode_32bit_float() 

        

        if y == 'nan':
            y=0
            olvasott.append(y)
            logger.info(str(Regiszterek[n])+'A register olvasasa sikeres, Erteke:'+str(y))
            n=n+1
            continue
        
        else:
            olvasott.append(y)
            logger.info(str(Regiszterek[n])+'A register olvasasa sikeres, Erteke:'+str(y))
            n=n+1
            continue

    
    return olvasott



def iras(adat):

    mydb=mysql.connector.connect(
    host="localhost",     
    user="root", 
    port='3307',
    password="", 
    database="adatbazis"   
    )

    mycursor = mydb.cursor()

    
        
    for n in range(14):

        datum = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

        sql= "UPDATE pillanatnyi SET meres = %s,datum = %s WHERE register_id = %s"
        val=(adat[n],datum,Regiszterek[n])

        mycursor.execute(sql,val)
        mydb.commit()


        sql = "INSERT INTO hisztorikus (datum,register_id,meres,eszkoz_id) VALUES (%s,%s,%s,%s)"
        val=(datum,Regiszterek[n],adat[n],1)

        mycursor.execute(sql,val)
        mydb.commit()

        logger.info(str(adat[n])+ ' Feltoltve az adatbazisba!')

    sql="SELECT * FROM pillanatnyi ORDER BY register_id ASC"

    mycursor.execute(sql)
    mydb.commit()


    logger.info('-------------------------------------------------')



async def main():

    logger.info('Az olvasas megkezdodott!')

    logger.info('-------------------------------------------------')

    adat = olvas()

    logger.info('-------------------------------------------------')

    iras(adat)

    logger.info('-------------------------------------------------')
    logger.info('Az olvasas es feltoltes befejezodott, 1 perc varakozas!')

    await asyncio.sleep(60)


try:

    while True:
        asyncio.run(main())

except KeyboardInterrupt:
    client.close()
    logger.info('Kapcsolat bontva és adatkiolvasas LEALLITVA')





