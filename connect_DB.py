import pymysql
#obtener fecha
import datetime
fecha = datetime.datetime.now()

#conectar a base de datos
connection = pymysql.connect(
            host = "localhost",
            user = "root",
            password = "Admin123?",
            db="visiomex"
        )

cursor = connection.cursor()

#obtener el cobtador sin cubrebocas
query = "SELECT con_sc FROM registro ORDER BY id DESC LIMIT 1"
cursor.execute(query)
result = cursor.fetchone()

#cuantos ñersonas sin cubrebocas se han detectado hasta ahora
sc = result 
new_sc = int(result[0]) + 1 #sumarle 1


#obtener el cobtador sin cubrebocas
query = "SELECT con_cc FROM registro ORDER BY id DESC LIMIT 1"
cursor.execute(query)
result = cursor.fetchone()

#cuantos persona con cubrebocas se han detectado hasta ahora
cc= result 
new_cc = int(result[0]) + 1 #sumarle 1

#insertar nuevo registro de persona con cubrebocas
query = "INSERT INTO registro (con_cc, con_sc, fecha) VALUES ({}, {}, '{}')".format(new_cc, sc[0], fecha)
cursor.execute(query)

#insertar nuevo registro de persona sin cubrebocas
query = "INSERT INTO registro (con_cc, con_sc, fecha) VALUES ({}, {}, '{}')".format(cc[0], new_sc, fecha)
cursor.execute(query)



connection.commit()
cursor.close()
connection.close()





"""
class DataBase:
    def __init__(self):
        self.connection = pymysql.connect(
            host = "localhost",
            user = "root",
            password = "Admin123?",
            db="visiomex"
        )

        self.cursor = self.connection.cursor()

        print("conexion establecida")
    
    def insert_cc(self,cc,date):
        sql = 'INSERT INTO registro (con_cc,fecha) VALUES("%s","%s")'

        try:
            self.cursor.execute(sql,(cc,date))
            self.connection.commit()

        except Exception as e:
            raise
    

    def get_last_row(self):
        sql = 'SELECT con_sc FROM registro ORDER BY fecha DESC LIMIT 1'
        self.cursor.execute(sql)
        row = self.cursor.fetchone()
        return row

    def close(self):
        self.connection.close()

database = DataBase()
last_row = database.get_last_row() 
cc = last_row[last_row] + 10
print(cc)
#database.insert_cc(1,fecha)
database.close()
"""
