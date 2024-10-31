
import csv
import boto3
import schedule
import time
from random import randint
from datetime import datetime

HOST = 'xxx'
PORT = 'xxx'

# Szimulált Modbus Client helyettesítés
class FakeModbusClient:
    def read_holding_registers(self, register, count):
        # Szimulálunk egy választ, ami nem hiba, és véletlenszerű értékeket ad
        class Response:
            def __init__(self, registers):
                self.registers = registers

            def isError(self):
                return False

        # Véletlenszerű adatokat ad vissza, mintha az eszközről jöttek volna
        return Response([randint(0, 1000)])

# A valós client helyett a szimuláltat használjuk
client = FakeModbusClient()

#MODBUS CSATLAKOZÁS

felho = 'iotmero.com'
adatbazis = 'adatbazis.csv'
s3 = boto3.client('s3')

#AWS S3

Regiszterek = [3028, 3032, 3034, 3000, 3002, 3004, 3076, 3060, 3068, 3110, 3196, 3240, 3208, 3224]
#L1,L2,L3 fesz   L1,L2,L3 áramerősség                   frekvencia,  IEc, kumulált látsz,hat,meddő energiamenny

def olvas():
    olvasott = []  # üres lista
    n=0
    for beolvasott in Regiszterek:
        x = client.read_holding_registers(beolvasott, 1)
        
        olvasott.append(x.registers[0])
        print(str(Regiszterek[n])+"A register olvasasa sikeres, Erteke:"+str(x.registers[0]))
        n=n+1
        continue
    


        

    return olvasott

def iras(adat):
    datum = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    sor = [datum] + adat

    with open(adatbazis, 'a', newline='') as file:
        
        csv.writer(file).writerow(sor)

    s3.upload_file(adatbazis, felho, adatbazis)
    print(str(sor)+ "FELTÖLTVE")
    

def main():
    
    print("Olvasas megkezdese")
    adat = olvas()
    print("-----------------------")
    iras(adat)
    print("1 perc varakozas")

schedule.every(1).minutes.do(main)

try:
    while True:
        
        schedule.run_pending()
        time.sleep(1)
        
except KeyboardInterrupt:
    print("LEALLITVA")

