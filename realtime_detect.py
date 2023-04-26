import torch
import cv2

# Cargando el modelo entrenado
model = torch.hub.load('ultralytics/yolov5', 'custom', path='/home/neftali/Escritorio/programas/4to_semestre/pi4/best.pt')

# Configuración del modelo
model.conf = 0.3  # Umbral de confianza
model.iou = 0.3 # Umbral de IOU

# Capturando el video en tiempo real desde la cámara
cap = cv2.VideoCapture(0)


while True:
    ret, frame = cap.read()
    if not ret:
        break

    # Haciendo la predicción del modelo en el fotograma actual
    results = model(frame)

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
