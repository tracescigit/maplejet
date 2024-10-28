const net = require('net');
const WebSocket = require('ws');

// Use command-line arguments for TCP host and port
const tcpHost = process.argv[2] || '192.168.0.10'; // Default TCP host
const tcpPort = process.argv[3] || 2000; // Default TCP server port
const wsUrl = 'ws://0.0.0.0:6001'; // Update to listen on all interfaces

// Create a new TCP client
const client = new net.Socket();
let wsClient;

// Function to connect to the WebSocket server
const connectWebSocket = () => {
    wsClient = new WebSocket(wsUrl);

    wsClient.on('open', () => {
        console.log('WebSocket connection established');
    });

    wsClient.on('message', (message) => {
        console.log('Received from WebSocket server: ' + message);
    });

    wsClient.on('close', () => {
        console.log('WebSocket connection closed. Attempting to reconnect...');
        setTimeout(connectWebSocket, 5000); // Reconnect after 5 seconds
    });

    wsClient.on('error', (err) => {
        console.error('WebSocket Error: ' + err.message);
    });
};

// Connect to the TCP server
client.connect(tcpPort, tcpHost, () => {
    console.log(`Connected to TCP server at ${tcpHost}:${tcpPort}`);
    connectWebSocket(); // Initiate WebSocket connection
});

// Listen for data from the TCP server
client.on('data', (data) => {
    const message = data.toString(); // Convert Buffer to string
    console.log('Received from TCP server: ' + message);
    
    // Send the received data to the WebSocket server
    if (wsClient && wsClient.readyState === WebSocket.OPEN) {
        wsClient.send(message); // Send as a string
        console.log('Data sent to WebSocket server');
    } else {
        console.error('WebSocket is not open. Data not sent.');
    }
});

// Handle TCP client connection closure
client.on('close', () => {
    console.log('TCP connection closed');
});

// Handle TCP client errors
client.on('error', (err) => {
    console.error('TCP Client Error: ' + err.message);
});

// Graceful shutdown
process.on('SIGINT', () => {
    console.log('Shutting down...');
    client.destroy(); // Close TCP connection
    if (wsClient) {
        wsClient.close(); // Close WebSocket connection
    }
    process.exit();
});
