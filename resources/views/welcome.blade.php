<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON Viewer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        pre {
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            overflow: auto;
        }
    </style>
</head>
<body>
    <h1>Sports Data Viewer</h1>
    <p>Fetching data from <code>http://127.0.0.1:8000/api/sports</code>...</p>
    <div id="output">
        <pre>Loading data...</pre>
    </div>

    <script>
        const apiUrl = "/api/sports";
        const outputDiv = document.getElementById('output');

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                outputDiv.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            })
            .catch(error => {
                outputDiv.innerHTML = `<pre>Error: ${error.message}</pre>`;
            });
    </script>
</body>
</html>

