import csv
import logging.handlers
import boto3 #aws hez való csatlakozás
import schedule
import time #időzétés scheduleval együtt
import logging
import asyncio
import sys
import mysql.connector
from pymodbus.client import ModbusTcpClient #modbus csatlakozás
from pymodbus.payload import BinaryPayloadDecoder
from pymodbus.constants import Endian
from datetime import datetime #időbélyeg 


logger=logging.getLogger(__name__)
logger.addHandler(logging.StreamHandler(sys.stdout))
logging.basicConfig(filename='szoftver.log', level=logging.INFO)


host = '127.0.0.1' 
port = '502'

client = ModbusTcpClient(host, port=port) #constructor ModbusTcpClient osztályra, 


if not  client.connect():
    logger.error("Nem sikerült csatlakozni!")
    sys.exit(1)
else:
    logger.info("Sikerült csatlakozni!")



Regiszterek = [3028,3030,3032,   3000,3002,3004,       3076,3060,3068,   3110,      3196,               3240,3208,3224         ]
                #L1,L2,L3 fesz   L1,L2,L3 áramerősség                   frekvencia,  IEc,           kumulált látsz,hat,meddő energiamenny
                #(3070,3072,3074)látszólagos telj,       (3054,3056,3058, )hatásos teljesitmeny    (3062,3064,3066,)meddő teljesitmeny


def olvas():

    olvasott = [] #üres lista
    n=0
    for beolvasott in Regiszterek:

        if beolvasott == 3240 or beolvasott == 3208 or beolvasott == 3224:

            x = client.read_holding_registers(beolvasott, 4) #4 olvasas kell mert int 64

            decoder=BinaryPayloadDecoder.fromRegisters(x.registers,byteorder=Endian.BIG, wordorder=Endian.BIG)
            y=decoder.decode_64bit_int() #int64 kiolvasas


        else:

            x = client.read_holding_registers(beolvasott, 2) #2 olvasas kell mert float32
        
            decoder=BinaryPayloadDecoder.fromRegisters(x.registers,byteorder=Endian.BIG, wordorder=Endian.BIG)
            y=decoder.decode_32bit_float() #float32 kiolvasas


        olvasott.append(y)
        logger.info(str(Regiszterek[n])+'A register olvasasa sikeres, Erteke:'+str(y))
        n=n+1
        continue

    return olvasott



def iras(adat):

    mydb=mysql.connector.connect(
    host="localhost",     
    user="root", 
    password="iot123", 
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

    logger.info('-------------------------------------------------')

    """for n in range(14):

        datum = datetime.now().strftime('%Y-%m-%d %H:%M:%S')   

        sql = "INSERT INTO hisztorikus (datum,register_id,meres,eszkoz_id) VALUES (%s,%s,%s,%s)"
        val=(datum,Regiszterek[n],adat[n],1)

        mycursor.execute(sql,val)
        mydb.commit()

        logger.info(str(adat[n])+ ' Feltoltve a hisztorikus adatbazisba!')"""

    
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





