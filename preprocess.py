from datetime import datetime
from os import error
from urllib import request

import subprocess

import csv

import time

# import the PostgreSQL adapter for Python

import psycopg2

from psycopg2 import sql




start_time = time.time()


# Section 1
# Downloading the latest weather file from https://dd.weather.gc.ca/nowcasting/matrices


now = str(datetime.utcnow())

month = now[5:7]
day = now[8:10]
hour = now[11:13]

url = str('https://dd.weather.gc.ca/nowcasting/matrices/SCRIBE.NWCSTG.' + month + '.' + day + '.' + hour + 'Z.n.Z')

local_file = url[45:]

try:
    request.urlretrieve(url, local_file)

except error:
    if int(hour) > 1 and int(hour) <= 23:
        
        hour = str("0" + str(int(hour) - 1))
        if len(hour) == 3:
            hour = hour[1:]
        url = str('https://dd.weather.gc.ca/nowcasting/matrices/SCRIBE.NWCSTG.' + month + '.' + day + '.' + hour + 'Z.n.Z')
        local_file = url[45:]
        request.urlretrieve(url, local_file)
        
            
    elif int(hour) == 0:
            hour = "23"
            url = str('https://dd.weather.gc.ca/nowcasting/matrices/SCRIBE.NWCSTG.' + month + '.' + day + '.' + hour + 'Z.n.Z')
            local_file = url[45:]
            request.urlretrieve(url, local_file)


# Section 2
# Unzipping and renaming the weather file into a txt file

# creating variables to add into the command line code using string manipulation
unzipped = str('"' + local_file.replace(".Z", "") + '"')
txt_file = str('"' + local_file.replace("n.Z", "txt") + '"')

# setting up a command line code to unzip files using 7zip
# the output file path will need to be congifured
one = str('7z e ' + local_file + ' -oC:\CollaborativeProject\output')

# setting up a command line code to rename the unzipped file into a txt file
two = str('rename ' + unzipped + " " + txt_file)

subprocess.run(one, shell=True)
subprocess.run(two, shell=True)

# example of what the above command line code would look like
# subprocess.run('7z e C:\CollaborativeProject\output\SCRIBE.NWCSTG.05.22.03Z.n.Z  -oC:\CollaborativeProject\output', shell=True)
# subprocess.run('rename "C:\CollaborativeProject\output\SCRIBE.NWCSTG.05.22.03Z.n" "SCRIBE.NWCSTG.05.22.03Z.txt"', shell=True)

# Section 3
# Reading the text file and writing the contents to a new file

# csv to list: https://www.codespeedy.com/csv-to-list-in-python/



with open('on_stn_codes.csv') as stn:
    reader = csv.reader(stn)
    my_list = list(reader)


my_list[0] = ['CYAM']

list2 = str(my_list).replace("[",'').replace("'",'').replace("]",'')


list3 = [i[0] for i in my_list]

list4 = [" " + i for i in list3 if len(i) == 3]
list5 = [i for i in list3 if len(i) == 4]    

list4.extend(list5)

count = 0

weather_file = txt_file.replace(".txt", ".csv")

txt_file2 = txt_file.replace('"',"")
weather_file = weather_file.replace('"',"")

# Connect to the PostgreSQL database server

postgresConnection = psycopg2.connect("dbname=ontario_weather user=postgres password='postgres'")

# Get cursor object from the database connection

cursor = postgresConnection.cursor()

name_Table = txt_file.replace(".txt", "")

# Create table statement

sqlCreateTable = "create table "+name_Table+" (STN VARCHAR(4), DATE VARCHAR(8), HOUR VARCHAR(4), TEMP FLOAT, WIND FLOAT);"

# Create a table in PostgreSQL database

cursor.execute(sqlCreateTable)


with open(txt_file2, "r") as file:  
    
    for line in file:

        try:
            if line[5:9] in list4:
                count += 1
                for x in range(26):
                    next(file)
                current = file.readline()
                sqlInsert = sql.SQL("INSERT INTO {name} (STN, DATE, HOUR, TEMP, WIND) VALUES({one}, {two}, {three}, {four}, {five})".format(
                    name = name_Table, one = ("'"+(line[5:9])+"'"), 
                two = (current[0:8]), three = (current[9:13]), four = (current[65:70].replace(" ", "")), 
                five= (current[81:84].replace(" ", ""))))

                cursor.execute(sqlInsert)
                
        except IndexError:
            for x in range(30):
                next(file)

postgresConnection.commit()


print("--- %s seconds ---" % (time.time() - start_time))