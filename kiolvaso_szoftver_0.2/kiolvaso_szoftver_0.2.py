import csv
import logging.handlers
import boto3 #aws hez való csatlakozás
import schedule
import time #időzétés scheduleval együtt
import logging
import asyncio
import sys
from pymodbus.client import ModbusTcpClient #modbus csatlakozás
from datetime import datetime #időbélyeg 




logger=logging.getLogger(__name__)
logger.addHandler(logging.StreamHandler(sys.stdout))
logging.basicConfig(filename='szoftver.log', level=logging.INFO)


host = 'DESKTOP-651THDM' 
port = '502'

client = ModbusTcpClient(host, port=port) #constructor ModbusTcpClient osztályra, 
client.connect()


felho = 'iotmero.com'
adatbazis = 'adatbazis.csv' 
s3=boto3.client('s3') #aws s3 kliens letrehozasa, ezen kivül meg kell adni cmdbe- aws configure acces keyt és jelszó illetve régió



Regiszterek = [3028,3032,3034,   3000,3002,3004,       3076,3060,3068,   3110,      3196,               3240,3208,3224         ]
                #L1,L2,L3 fesz   L1,L2,L3 áramerősség                   frekvencia,  IEc,           kumulált látsz,hat,meddő energiamenny
                #(3070,3072,3074)látszólagos telj,       (3054,3056,3058, )hatásos teljesitmeny    (3062,3064,3066,)meddő teljesitmeny


def olvas():

    olvasott = [] #üres lista
    n=0
    for beolvasott in Regiszterek:
        x=client.read_holding_registers(beolvasott, 2) #valtozóba beolvassa az adott registert, illetve hányszor olvassa ki, visszatérési értéke a registers lista

        olvasott.append(x.registers[0])
        logger.info(str(Regiszterek[n])+'A register olvasasa sikeres, Erteke:'+str(x.registers[0]))
        n=n+1
        continue

    return olvasott



def iras(adat):
    
    datum = datetime.now().strftime('%Y-%m-%d %H:%M:%S') #időbélyeg    
    sor=[datum] + adat  #adatok

    with open(adatbazis, 'a', newline='') as file:
        
        csv.writer(file).writerow(sor)

    s3.upload_file(adatbazis,felho,adatbazis)

    logger.info(str(sor)+'FELToLTVE')

async def main():

    logger.info('A program elkezdodott')

    adat = olvas()

    iras(adat)

    logger.info('1 perc varakozas!')
    await asyncio.sleep(60)


try:

    while True:
        asyncio.run(main())

except KeyboardInterrupt:
    logger.info('LEALLITVA')





