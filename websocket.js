const WebSocket = require('ws');

// Create a new WebSocket server on port 6001
const wss = new WebSocket.Server({ port: 6001 });

wss.on('connection', (ws) => {
    console.log('WebSocket client connected');

    // Handle incoming messages from the client
    ws.on('message', (data) => {
        const message = data.toString(); // Convert Buffer to string if needed
        console.log('Received message from client:', message);

        // Optionally send a response back to the client
        ws.send(`Server received: ${message}`);

        // Broadcast the received message to all connected clients
        wss.clients.forEach(client => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(`${message}`);
            }
        });
    });

    // Handle the event when the connection is closed
    ws.on('close', () => {
        console.log('WebSocket client disconnected');
    });

    // Handle errors
    ws.on('error', (error) => {
        console.error('WebSocket error:', error);
    });
});

// Log that the WebSocket server is running
console.log('WebSocket server is listening on ws://localhost:6001');
