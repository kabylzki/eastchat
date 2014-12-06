http.createServer(function (req, res) {
   // parse URL
   var url_parts = url.parse(req.url);
   console.log(url_parts);
   if(url_parts.pathname == '/') {
      // file serving
      fs.readFile('./index.html', function(err, data) {
         res.end(data);
      });
   } else if(url_parts.pathname.substr(0, 5) == '/poll') {
     // polling code here
  }
}).listen(8080, 'localhost');
console.log('Server running.');

