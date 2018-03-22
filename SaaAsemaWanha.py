#WANAHA
import serial
import MySQLdb as mdb
import math
import cmath
from math import log
	
ser = serial.Serial(
	port = '/dev/ttyUSB0', 
	baudrate = 9600,
	parity = serial.PARITY_NONE,
	stopbits = serial.STOPBITS_ONE, 
	bytesize=serial.EIGHTBITS, 
	timeout = 60
	)
ser.flush()
ser.flushInput()
ser.flushOutput()

def kastePiste(lampotila, kosteus):#kastepiste kaava
	return (237.7*(((17.27*float(lampotila))/(237.7+float(lampotila)))+(log(float(kosteus)/100))))/(17.27-((((17.27*float(lampotila))/(237.7+float(lampotila)))+(log(float(kosteus)/100)))))

while True:
	
	
	stringi = ser.readline()

	if(stringi.__len__() > 0):#vastaus valmiina lukuun
			

		mittaukset = stringi.split('\t', 15)
		
		stationID = mittaukset[0]
		paivaysTurha = mittaukset[1]
		ilmanpaine = mittaukset[2]
		lampotila =  mittaukset[3]
		lisaAntC = mittaukset[4]
		lisaAntD = mittaukset[5]
		lisaAntE = mittaukset[6]
		valoisuus = mittaukset[7]
		kosteus = mittaukset[8]
		lampotila2 = mittaukset[9]
		sademaara = mittaukset[10]
		tuulenSuunta = mittaukset[11]
		tuulenNopeus = mittaukset[12]
		tuulenPuuska = mittaukset[13]
		akku = mittaukset[14]
		
		akku2 = akku[:-6]

		kaste = kastePiste(lampotila,kosteus)
		print kaste
		
		db = mdb.connect("195.148.67.136", "asema", "******", "*****db")
		curs = db.cursor()

		try:
			curs.execute("""INSERT INTO SaaAsema (Paivays, Paine, Lampotila, Valoisuus, Kosteus, Lampotila2, Sademaara, Suunta, Nopeus, Puuska, Akku)VALUES (
			now(),%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)""",
			(ilmanpaine, lampotila, valoisuus, kosteus, lampotila2, sademaara, tuulenSuunta, tuulenNopeus, tuulenPuuska, akku2))
			db.commit()

		except mdb.Error, e:

			print "Error  %d:" % (e.args[0], e.args[1])
			db.rollback()
			sys.exit(1)

		finally:

			if db:
				db.close()	
				curs.close()
		
		ser.close()
		break

	else:

		ser.close()
		break
