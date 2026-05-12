from flask import Flask, request, jsonify
import tensorflow as tf
import numpy as np
import cv2
import json

app = Flask(__name__)

# LOAD MODEL
model = tf.keras.models.load_model(
    "pyton/model_daun12.h5",
    compile=False
)

# LOAD LABEL
with open(
    "pyton/class_indices.json",
    "r"
) as f:

    class_indices = json.load(f)

class_labels = {
    v: k for k, v in class_indices.items()
}

# API PREDICT
@app.route("/predict", methods=["POST"])
def predict():

    file = request.files["image"]

    img = cv2.imdecode(
        np.frombuffer(file.read(), np.uint8),
        cv2.IMREAD_COLOR
    )

    img = cv2.resize(img, (224, 224))

    img = cv2.cvtColor(
        img,
        cv2.COLOR_BGR2RGB
    )

    img = img / 255.0

    img = np.expand_dims(
        img,
        axis=0
    )

    prediction = model.predict(img)

    predicted_index = np.argmax(prediction)

    confidence = float(
        np.max(prediction)
    )

    hasil = class_labels[predicted_index]

    return jsonify({
        "hasil": hasil,
        "confidence": round(confidence * 100, 2)
    })

# HOME
@app.route("/")
def home():
    return "AI Daun Aktif"

# RUN
if __name__ == "__main__":
    app.run(
        host="0.0.0.0",
        port=10000
    )