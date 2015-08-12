var http = require('http');
var express = require('express');
var oio = require('orchestrate');
var token = 'Your-Token-Here';
var db = oio(token, 'api.ctl-uc1-a.orchestrate.io');
console.log("Connecting to orchestrate.io...");
db.ping()
.then(function () {
    console.log("Valid orchestrate.io key detected.");
    runWebServer();
})
.fail(function (err) {
    console.log('Invalid orchestrate.io API key! Check your token => ' + token);
    process.exit(1);
});

function runWebServer(){
    var app = express();
    app.use(express.static(__dirname + '/www'));
    app.get('/', function(req, res) {
        res.sendFile('www/index.html', {root: __dirname })
    });
    var port = process.env.port || 1337;
    var server = app.listen(port);
    console.log("Listening on port " + port);
};
