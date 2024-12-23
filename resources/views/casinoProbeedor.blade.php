<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino Data Viewer</title>
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
        .section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Casino Data Viewer</h1>

    <div class="section">
        <h2>Providers</h2>
        <div id="providersOutput">
            <pre>Loading providers data...</pre>
        </div>
    </div>

    <div class="section">
        <h2>Game Details</h2>
        <input type="text" id="gameIdInput" placeholder="Enter providers{code}">
        <button onclick="fetchGameData()">Fetch Game Data</button>
        <div id="gameOutput">
            <pre>Enter a game ID and click "Fetch Game Data" to load game details.</pre>
        </div>
    </div>

    <script>
        const providersUrl = "api/casino/provider";
        const providersOutputDiv = document.getElementById('providersOutput');

        fetch(providersUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                providersOutputDiv.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            })
            .catch(error => {
                providersOutputDiv.innerHTML = `<pre>Error: ${error.message}</pre>`;
            });

        function fetchGameData() {
            const gameId = document.getElementById('gameIdInput').value;
            const gameUrl = `api/casino/game/${gameId}`;
            const gameOutputDiv = document.getElementById('gameOutput');

            fetch(gameUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    gameOutputDiv.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
                })
                .catch(error => {
                    gameOutputDiv.innerHTML = `<pre>Error: ${error.message}</pre>`;
                });
        }
    </script>
</body>
</html>