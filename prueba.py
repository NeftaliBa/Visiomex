
import torch
import cv2

# Cargando el modelo entrenado
model = torch.hub.load('ultralytics/yolov5', 'custom', path='/home/neftali/Escritorio/programas/4to_semestre/pi4/best.pt')

# Configuración del modelo
model.conf = 0.3  # Umbral de confianza
model.iou = 0.3 # Umbral de IOU

# Capturando el video en tiempo real desde la cámara
cap = cv2.VideoCapture(0)

import pymysql
#obtener fecha
import datetime

#conectar a base de datos
connection = pymysql.connect(
            host = "localhost",
            user = "root",
            password = "Admin123?",
            db="visiomex"
        )

cursor = connection.cursor()

# Inicializar variables de seguimiento de persona
person_detected = False
person_masked = False


while True:
    ret, frame = cap.read()
    if not ret:
        break

    # Haciendo la predicción del modelo en el fotograma actual
    results = model(frame)

    for pred in results.pred:
        if pred.shape[0] > 0 and pred[0, 5] in [1, 2]:
            person_detected = True
            if pred[0, 5] == 1:
                person_masked = True
            else:
                person_masked = False

            # Obtener la fecha y hora actual
            fecha = datetime.now()


            if person_masked:
                #obtener el contador sin cubrebocas
                query = "SELECT con_sc FROM registro ORDER BY id DESC LIMIT 1"
                cursor.execute(query)
                result = cursor.fetchone()

                #actualizamos el contador cc
                sc = result 
                new_sc = int(result[0]) + 1 

                #obtener el contador sin cubrebocas
                query = "SELECT con_cc FROM registro ORDER BY id DESC LIMIT 1"
                cursor.execute(query)
                result = cursor.fetchone()

                #cuantos persona con cubrebocas se han detectado hasta ahora
                cc= result 
                new_cc = int(result[0]) + 1 #sumarle 1

                print("se detecto tonto con cubrebocas")

            else:
                #obtener el cobtador sin cubrebocas
                query = "SELECT con_sc FROM registro ORDER BY id DESC LIMIT 1"
                cursor.execute(query)
                result = cursor.fetchone()

                #cuantos personas sin cubrebocas se han detectado hasta ahora
                sc = result 
                new_sc = int(result[0]) + 1 #sumarle 1


                #obtener el cobtador sin cubrebocas
                query = "SELECT con_cc FROM registro ORDER BY id DESC LIMIT 1"
                cursor.execute(query)
                result = cursor.fetchone()

                #cuantos persona con cubrebocas se han detectado hasta ahora
                cc= result 
                new_cc = int(result[0]) + 1 #sumarle 1

                query = "INSERT INTO registro (con_cc, con_sc, fecha) VALUES ({}, {}, '{}')".format(cc[0], new_sc, fecha)
                cursor.execute(query)
                
                print("se detecto tonto sin cubrebocas")
      

    # Dibujando las detecciones en el fotograma actual
    results.render()


    # Mostrando el fotograma actual con las detecciones
    cv2.imshow('YOLOv5', results.ims[0])

    # Esperando 1 milisegundo y saliendo si se presiona 'q'
    if cv2.waitKey(1) == ord('q'):
        break

# Liberando los recursos
cap.release()
cv2.destroyAllWindows()