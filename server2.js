const net = require('net');
const WebSocket = require('ws');

const tcpHost = 'localhost'; // Change to the server's IP if not local
const tcpPort = 3000;        // TCP server port
const wsUrl = 'ws://localhost:6001'; // WebSocket server URL

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
        // Attempt to reconnect after 5 seconds
        setTimeout(connectWebSocket, 5000);
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
