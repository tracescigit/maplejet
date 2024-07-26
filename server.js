// server.js
const net = require("net");
const WebSocket = require("ws");

const tcpHost = "127.0.0.5"; // Replace with the IP address of your camera
const tcpPort = 2000; // Replace with the port of your camera
const wsPort = 6001; // WebSocket server port

const wss = new WebSocket.Server({ port: wsPort });

let isCameraConnected = false;
let checkInterval;

// Function to check camera connection
function checkCameraConnection() {
    const client = new net.Socket();

    client.connect(tcpPort, tcpHost, () => {
        console.log(`Connected to camera at ${tcpHost}:${tcpPort}`);
        isCameraConnected = true;
        broadcastCameraStatus();
        client.destroy(); // Close the connection immediately after checking
    });

    client.on("error", (err) => {
        console.error("Camera connection error: " + err.message);
        isCameraConnected = false;
        broadcastCameraStatus();
    });
}

function broadcastCameraStatus() {
    const message = JSON.stringify({ isCameraConnected });
    wss.clients.forEach((client) => {
        if (client.readyState === WebSocket.OPEN) {
            client.send(message);
        }
    });
}

wss.on("connection", (ws) => {
    console.log("WebSocket client connected");

    // Send initial camera connection status
    ws.send(JSON.stringify({ isCameraConnected }));

    // Start periodic check
    checkInterval = setInterval(() => {
        checkCameraConnection();
        ws.send(JSON.stringify({ isCameraConnected }));
    }, 5000); // Check every 1 second

    ws.on("close", () => {
        console.log("WebSocket client disconnected");
        clearInterval(checkInterval); // Stop the interval when client disconnects
    });
});

// Initial check when server starts
checkCameraConnection();

// Handle Node.js process exit
process.on("exit", () => {
    clearInterval(checkInterval); // Clear interval on process exit
});

process.on("SIGINT", () => {
    clearInterval(checkInterval); // Clear interval on process exit from SIGINT (Ctrl+C)
    process.exit(0);
});

console.log(`WebSocket server running on port ${wsPort}`);
