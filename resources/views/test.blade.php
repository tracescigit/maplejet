<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-time Updates</title>
</head>
<body>
    <h1>Real-time Updates</h1>
    <div id="responseContainer"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ws = new WebSocket('ws://localhost:6001');  // WebSocket server URL
            const responseContainer = document.getElementById('responseContainer');

            ws.onopen = function() {
                console.log('WebSocket connection established');
            };

            ws.onmessage = function(event) {
                const message = event.data;
                const responseElement = document.createElement('div');
                responseElement.textContent = message;
                responseContainer.appendChild(responseElement);
            };

            ws.onerror = function(error) {
                console.error('WebSocket error:', error);
            };

            ws.onclose = function() {
                console.log('WebSocket connection closed');
            };
        });
    </script>
</body>
</html>
