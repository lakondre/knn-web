<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
</head>
<body>
    <h1>Upload Image</h1>
    <form action="/predict" method="post" enctype="multipart/form-data">
        <input type="file" name="file" accept="image/*" required>
        <button type="submit">Predict</button>
    </form>
    <div id="result"></div>

    <!-- Jika Anda ingin menampilkan hasil prediksi -->
    <h2>Result: <span id="prediction"></span></h2>
    
    <script>
        // Jika Anda ingin menampilkan hasil prediksi
        const resultDiv = document.getElementById('result');
        const predictionSpan = document.getElementById('prediction');

        document.querySelector('form').addEventListener('submit', async (e) => {
             e.preventDefault();
             const formData = new FormData();
             formData.append('file', e.target.file.files[0]);

             const response = await fetch('/predict', {
                 method: 'POST',
                 body: formData
             });

             const data = await response.json();
             predictionSpan.textContent = data.prediction;
             resultDiv.style.display = 'block';
         });
    </script>
</body>
</html>
