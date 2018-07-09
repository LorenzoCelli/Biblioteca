Quagga.init({
  inputStream : {
    name : "Live",
    type : "LiveStream",
    target: document.querySelector('#scanner-container')    // Or '#yourElement' (optional)
  },
  decoder : {
    readers : ["code_128_reader"]
  }
  }, function(err) {
    if (err) {
        console.log(err);
        return
    }
    console.log("Initialization finished. Ready to start");
    Quagga.start();
  });

    var resultCollector = Quagga.ResultCollector.create({
    capture: true,
    capacity: 20,
    blacklist: [{code: "3574660239843", format: "ean_13"}],
    filter: function(codeResult) {
        return true;
    }
});
console.log(Quagga.registerResultCollector(resultCollector));
