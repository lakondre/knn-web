from flask import Flask, request, jsonify
from skimage.transform import resize
from skimage.io import imread
import numpy as np
import joblib

app = Flask(__name__)

# Load the model
model = joblib.load('knn_model.joblib')

# Define endpoint for image upload and prediction
@app.route('/predict', methods=['POST'])
def predict():
    # Cek apakah ada file gambar yang dikirimkan
    if 'image' not in request.files:
        return jsonify({'error': 'No image uploaded'}), 400
    
    file = request.files['image']
    
    # Cek apakah file yang dikirimkan adalah file gambar
    if file.filename == '':
        return jsonify({'error': 'No image selected'}), 400

    # Read the image and preprocess it
    img = imread(file)
    img_resized = resize(img, (150, 150, 3))
    img_flatten = img_resized.flatten()
    
    # Make prediction
    prediction = model.predict([img_flatten])
    
    # Map prediction to class label
    if prediction[0] == 0:
        result = 'Katarak'
    else:
        result = 'Normal'
    
    return jsonify({'prediction': result}), 200

if __name__ == '__main__':
    app.run(debug=True)
