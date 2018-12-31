#!/usr/bin/python
# -*- coding: utf-8 -*-
import RPi.GPIO as GPIO 
import time
import MySQLdb
import serial
import binascii
import netifaces
from datetime import datetime
from datetime import date
import os,sys
from initialisation import GPIO, main as init_main

#redirect stdout & stderr to files
base_dir="/home/pi/"
sys.stdout = open(base_dir+'stdout.log', 'aw', 0)
sys.stderr = open(base_dir+'stderr.log', 'aw', 0)

# Initialisation de l'etat a init
state = "init"
IPaddr = "xxx.xxx.xxx.xxx"
localdoor = "L2"
while True:
	 
	if state == "init":
		
		
	 # Initialisation des entrees sorties de la raspberry et de la liaison serie
		init_main()
		ser = serial.Serial()
		ser.baudrate = 9600
		ser.port = "/dev/ttyAMA0"
		ser.open()
		GPIO.output(16,False)
		GPIO.output(18,False)
		GPIO.output(22,False)
		GPIO.output(11,False)
		IPaddr = netifaces.ifaddresses('eth0')[netifaces.AF_INET][0]['addr']
		if IPaddr == "xxx.xxx.xxx.xxx":
			localdoor = "UA2"
		elif IPaddr == "xxx.xxx.xxx.xxx":
			localdoor = "UA5"
		elif IPaddr == "xxx.xxx.xxx.xxx":
			localdoor = "UB3"
		elif IPaddr == "xxx.xxx.xxx.xxx":
			localdoor = "L2"
		print (localdoor)
		print (IPaddr)
		state = "LireBadges"
		   
	if state == "LireBadges":
		# Connection a la base de donnee et creation du curseur
		try:
		#db = MySQLdb.connect("DBSERVERADDRESS","LOGIN","PASSWORD","DBNAME")
			db = MySQLdb.connect("xxx.xxx.xxx.xxx","xxx","yyy","zzz")
			
		except:
			while True:
				time.sleep(1)
				try:
					db = MySQLdb.connect("xxx.xxx.xxx.xxx","xxx","yyy","zzz")
					break
				except: 
					pass
		cursor = db.cursor()		
		i = GPIO.input(15)
		GPIO.output(16,True)
		GPIO.output(18,False)
		GPIO.output(22,False)

		# Si la porte est ouverte:        
		if i == True:
			time.sleep(0.1)
			state = "LireReed"

		# Si la porte est fermee alors lire le badge
		if i == False:
			ser.timeout = 3
			x = ser.read(12)
			a = binascii.hexlify(x)
			# ici sa sert a extraire l'id de l'encapsulation(start byte et stop byte)
			if len(a) ==24:
				y = [a[20],a[21],a[18],a[19],a[16],a[17],a[14],a[15],a[12],a[13],a[10],a[11],a[8],a[9],a[6],a[7]]
				z = ''.join(y).upper()
				
		 
				if len(z) == 16 and i == False:
					state = "BD"
			else:
				state = "LireBadges"
		time.sleep(0.1)				
	if state == "BD":
				
		# Condition pour voir si le badges figure dans la base de donnee et a l'autorisation pour cette porte
		rep = cursor.execute("SELECT Nom,Prenom,ID,Fonction,Portes FROM Entrees_Sorties WHERE ID=%s AND FIND_IN_SET(%s,Portes) AND FIND_IN_SET(%s,Statut)",(z, localdoor, "Actif"))
		rep2 = cursor.fetchall()
		# Dans le cas ou le badge existe mais n'est pas autorisee il faut tout de meme recup les donnees
		reponse = cursor.execute("SELECT Nom,Prenom,ID,Fonction,Portes FROM Entrees_Sorties WHERE ID=%s",(z))
		reponse2 = cursor.fetchall()
		# reponse2 = [ split(row, ',') for row in cursor.fetchall()]
		# Retourner valeur Prenom pour speaks
		if reponse != 0:
			# Le badge est dans la base
			for row in reponse2:
				lname = row[0]
				fname = row[1]
				id = row[2]
				function = row[3]
				doors = row[4]
		else:
			# Le badge n'est pas dans la base
			state = "LedRouge"
			lname = "Inconnu"
			fname = ""
			id = ""
			function = ""
			doors = ""
			print lname
		if rep != 0:
			# le badge est dans la base et ok pour actif et localdoor
			reponse3 = cursor.execute("SELECT Date_Fin_Validite FROM Entrees_Sorties WHERE ID=%s",(z))
			date_fin = cursor.fetchall()[0]
			date_now = date.today()
			print date_fin
			print date_now
			if date_fin >= date_now.isoformat():
				state = "LedVerte"
			else:
				state = "LedRouge"
		else: 
			state = "LedRouge"
	
	if state == "LedVerte":
		GPIO.output(16,False)
		GPIO.output(22,False)
		GPIO.output(18,True)
		# Ecriture dans le fichier log
		# read the current contents of the file 
		fichier = open("/var/www/PageWeb/log.txt")
		text = fichier.read()
		fichier.close
		# open a different file for writing 
		fichier = open("/var/www/PageWeb/log.txt~","w")
		#fichier.seek(0,0)
		#fichier.write(z+"\t"+datetime.now().strftime("%d/%m/%y %H:%M")+"\t"+ str(localdoor)+"\t"+str(reponse2)+"\n")
		fichier.write(z+"\t"+datetime.now().strftime("%d/%m/%y %H:%M")+"\t"+ str(localdoor)+"\t"+str(lname)+"\t"+ str(fname)+"\t"+ str(function)+"\t"+ str(doors)+"\t"+"Granted"+"\n")
		fichier.write(text)
		fichier.close()
		os.rename("/var/www/PageWeb/log.txt~","/var/www/PageWeb/log.txt")
		state = "OuverturePorte"
	
	if state == "LedRouge":
		GPIO.output(16,False)
		GPIO.output(18,False)
		GPIO.output(22,True)
		os.system("aplay /home/pi/sounds/w3/PeasantWhat4.wav")
		time.sleep(2)
		GPIO.output(22,False)
		# Ecriture dans le fichier log
		# read the current contents of the file 
		fichier = open("/var/www/PageWeb/log.txt")
		text = fichier.read()
		fichier.close
		# open a different file for writing 
		fichier = open("/var/www/PageWeb/log.txt~","w")
		#fichier.seek(0,0)
		#fichier.write(z+"\t"+datetime.now().strftime("%d/%m/%y %H:%M")+"\t"+ str(localdoor)+"\t"+str(reponse2)+"\n")
		fichier.write(z+"\t"+datetime.now().strftime("%d/%m/%y %H:%M")+"\t"+ str(localdoor)+"\t"+str(lname)+"\t"+ str(fname)+"\t"+ str(function)+"\t"+ str(doors)+"\t"+"Denied"+"\n")
		fichier.write(text)
		fichier.close()
		os.rename("/var/www/PageWeb/log.txt~","/var/www/PageWeb/log.txt")
		state = "LireBadges"
	
	if state == "OuverturePorte":
		GPIO.output(11,True)
		time.sleep(1)
		GPIO.output(11,False)
		k = datetime.now()
		m = k.hour
		l = k.minute
		# tous les sons en fontion de l'heure se reglent ici
		if m < 8:
			os.system("aplay /home/pi/sounds/w3/FootmanPissed2.wav")
		elif m == 8 or (m==9 and l<15):
			os.system("aplay /home/pi/sounds/w3/PeasantReady1.wav")
		elif (m==9 and l>15) or m<11:
			os.system("aplay /home/pi/sounds/w3/JainaWhat3.wav")
		elif m == 11:
			os.system("aplay /home/pi/sounds/w3/JainaPissed2.wav")
		elif m == 12:
			os.system("aplay /home/pi/sounds/w3/GhoulPiseed3.wav")
		elif m==13 :
			os.system("aplay /home/pi/sounds/w3/PeonYes3.wav")
		#elif m > 13 and m < 17:
			#os.system("aplay /home/pi/sounds/w3/JainaPissed2.wav")
			#Happy Hour
		else:
			os.system("aplay /home/pi/sounds/w3/PeasantWhat3.wav")
		GPIO.output(18,False)
		state = "LireReed"
		
	if state == "LireReed":
		GPIO.output(16,False)
		# cas ou la porte est ouverte
		if GPIO.input(15):
			time.sleep(5) #c'est ici qu'on regle le timer de controle "porte restee ouverte"
			state = "Bip"
		# cas ou la porte est fermee
		else:
			state = "ViderBuffer"
			
	if state == "Bip":
		# Le temps entre lequel la porte s'ouvre et l'alarme se declenche se regle a la ligne ci dessous
		
		# fichier audio d'alarme (audiodump)
		if GPIO.input(15):
			os.system("aplay /home/pi/sounds/audiodump.wav")
		state = "LireReed"
		
	if state == "ViderBuffer":
		# le ser.timeout sers a ce que le module n'attende pas pour lire un badge car la lecture est blocante si timeout!=0
		ser.timeout= 0
		f = ser.read(12)
		if len(f) > 0:
			state = "ViderBuffer"
		else:
			y = ''
			ser.timeout = None
			state = "LireBadges"
