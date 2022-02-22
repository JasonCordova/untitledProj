const http = require("http");
const express = require("express");

const app = express();

const server = http.createServer(app);

server.on("error", (err) => {

    console.log("Error: " + err);

})

server.listen(8080, () => {

    console.log("Server started");

});