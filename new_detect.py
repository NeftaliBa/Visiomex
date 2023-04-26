cap = cv2.VideoCapture(0)
cap.set(cv2.CAP_PROP_FRAME_WIDTH, 1920)
cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 1080)

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
