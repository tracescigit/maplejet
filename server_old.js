const net = require("net");
const WebSocket = require("ws");

const tcpHost = "127.0.0.5"; // replace with the target IP address
const tcpPort = 2000; // replace with the target port
const wsPort = 6001; // WebSocket server port

const wss = new WebSocket.Server({ port: wsPort });

wss.on("connection", (ws) => {
    console.log("WebSocket client connected");
});

const client = new net.Socket();

client.connect(tcpPort, tcpHost, () => {
    console.log(`Connected to ${tcpHost}:${tcpPort}`);
    client.on("data", (data) => {
        console.log("Received from TCP server: " + data);

        // Send data to all connected WebSocket clients
        wss.clients.forEach((ws) => {
            if (ws.readyState === WebSocket.OPEN) {
                ws.send(data.toString());
            }
        });
    });
});

client.on("data", (data) => {
    console.log("Received: " + data);

    // Send data to all connected WebSocket clients
    wss.clients.forEach((ws) => {
        if (ws.readyState === WebSocket.OPEN) {
            ws.send(data.toString());
        }
    });
});

client.on("close", () => {
    console.log("Connection closed");
});

client.on("error", (err) => {
    console.error("Error: " + err.message);
});
