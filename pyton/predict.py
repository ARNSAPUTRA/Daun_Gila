import os
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'

import warnings
warnings.filterwarnings('ignore')

import sys
import json
import numpy as np
import tensorflow as tf
import cv2

tf.get_logger().setLevel('ERROR')

from tensorflow.keras.models import load_model

# =========================================
# LOAD MODEL
# =========================================
model = load_model(
    r"C:\xampp3\htdocs\projec_daun\pyton\model_daun12_final.h5",
    compile=False
)

# =========================================
# LOAD CLASS INDICES
# =========================================
with open(
    r"C:\xampp3\htdocs\projec_daun\pyton\class_indices.json",
    "r"
) as f:
    class_indices = json.load(f)

# =========================================
# BALIK INDEX -> LABEL
# =========================================
class_labels = {
    v: k for k, v in class_indices.items()
}

# =========================================
# AMBIL PATH GAMBAR
# =========================================
img_path = sys.argv[1]

# =========================================
# CEK FILE GAMBAR
# =========================================
if not os.path.exists(img_path):
    print("Gambar tidak ditemukan")
    sys.exit()

# =========================================
# LOAD GAMBAR DENGAN OPENCV
# =========================================
IMG_SIZE = (224, 224)

img_cv = cv2.imread(img_path)

if img_cv is None:
    print("Gagal membaca gambar")
    sys.exit()

# =========================================
# RESIZE GAMBAR
# =========================================
img_cv = cv2.resize(
    img_cv,
    IMG_SIZE
)

# =========================================
# BGR -> RGB
# =========================================
img_rgb = cv2.cvtColor(
    img_cv,
    cv2.COLOR_BGR2RGB
)

# =========================================
# NORMALISASI
# =========================================
img_array = img_rgb / 255.0

# =========================================
# TAMBAH DIMENSI BATCH
# =========================================
img_array = np.expand_dims(
    img_array,
    axis=0
)

# =========================================
# PREDIKSI
# =========================================
prediction = model.predict(
    img_array,
    verbose=0
)

# =========================================
# AMBIL HASIL
# =========================================
predicted_index = np.argmax(prediction)

confidence = float(
    np.max(prediction)
)

hasil = class_labels[predicted_index]

# =========================================
# OUTPUT KE PHP
# =========================================
print("HASIL PREDIKSI")
print("========================")
print("Nama Daun :", hasil)
print("Akurasi   :", f"{confidence*100:.2f}%")

# =========================================
# DEBUG SEMUA KELAS
# =========================================
print()
print("SKOR SEMUA KELAS")
print("========================")

for i, score in enumerate(prediction[0]):

    nama_kelas = class_labels[i]

    print(
        f"{nama_kelas} : {score*100:.2f}%"
    )