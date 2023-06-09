import pymysql
import datetime
import torch
import cv2
import os

# Cargando el modelo entrenado
model = torch.hub.load('ultralytics/yolov5', 'custom', path=r'C:\Users\morkm\OneDrive - Universidad de Colima\Escritorio\detector PY\yolo\bestS.pt')
# Configuración del modelo
model.conf = 0.5  # Umbral de confianza
model.iou = 0.5 # Umbral de IOU


# Capturando el video en tiempo real desde la cámara
cap = cv2.VideoCapture(0)

#conectar a base de datos
connection = pymysql.connect(
            host = "localhost",
            user = "root",
            password = "",
            db="visiomex")

cursor = connection.cursor()

# Inicializar variables de seguimiento de persona
conta_c = 0
conta_s = 0
persona_detectada = False
carpeta_destino = r"C:\Users\morkm\OneDrive - Universidad de Colima\Escritorio\detector PY\fotos"


while True:
    ret, frame = cap.read()
    if not ret:
        break


    # Haciendo la predicción del modelo en el fotograma actual
    results = model(frame)

    # Verificar si se detectó una persona y su máscara está correctamente puesta
    for pred in results.pred:
        if pred.shape[0] > 0 and pred[0, 5] in [0, 1]:
            if pred[0, 5] == 0:
                if not persona_detectada:
                    conta_c += 1
                    persona_detectada = True
                    print("detecte a un pendejo con cubrebocas")
            else:
                if not persona_detectada:
                    conta_s += 1
                    persona_detectada = True
                    print("Detecté a una persona sin cubrebocas")
                    fecha = datetime.datetime.now()
                    fecha_str = fecha.strftime("%Y%m%d%H%M%S")  # Convertir la fecha a formato de cadena
                    ruta_captura = os.path.join(carpeta_destino, 'captura' + fecha_str + '.png')
                    cv2.imwrite(ruta_captura, frame)
                    print("Se tomó una captura de pantalla en:", ruta_captura)

            # Obtener la fecha y hora actual
            fecha = datetime.datetime.now()

    for pred in results.pred:
        if pred.shape[0] == 0:
            persona_detectada = False

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

query = "INSERT INTO registro (con_cc, con_sc, fecha) VALUES (%s, %s, %s)"
values = (conta_c, conta_s, fecha)
cursor.execute(query, values)
connection.commit()

cursor.close()
connection.close()

print("cc =", conta_c, "cs =", conta_s)