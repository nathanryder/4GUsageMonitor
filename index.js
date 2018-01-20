/*
npm install dialog-router-api --save
npm install mysql -y
All data stored in MB
Database called 4GUsage
*/

const mysql = require('mysql');
const con = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'user',
  database: '4GUsage'
});

var date = new Date();
var day = date.getDate();
var month = date.getMonth() + 1;
var year = date.getFullYear();
var dayNo = 0;

if (day > 22) {
  dayNo = day % 22;
} else {
  var fakeYear = year;
  var fakeMonth = month-1;
  if (fakeMonth == 0) {
    month = 12;
    fakeMonth = 12;
    --fakeYear;
    --year;
  }

  var fakeDate = new Date(fakeYear, fakeMonth, 0);
  var last = fakeDate.getDate() % 22;
  dayNo = last+day;
}

function getMainData(callback) {
    con.query('SELECT * FROM mainData', function(err, result) {
        if (err)
            callback(err,null);
        else
            callback(null,result[0]);
    });
}

con.connect((err) => {
  if (err) throw err;
  console.log('Connected!');
});
con.query("CREATE TABLE IF NOT EXISTS `" + year + "_" + month + "`(dayNo VARCHAR(20), day VARCHAR(20), upload VARCHAR(128), download VARCHAR(128), total VARCHAR(128))", (err,rows) => {
  if(err) throw err;
});
con.query("CREATE TABLE IF NOT EXISTS mainData(upload VARCHAR(128), download VARCHAR(128), total VARCHAR(128))", (err,rows) => {
  if(err) throw err;
});

var router = require('dialog-router-api').create({ gateway: '192.168.8.1' });

router.getToken(function(error, token) {
  router.getTrafficStatistics(token, function(error, response) {

    var newUpload = ((response['TotalUpload']/1024)/1024);
    var newDownload = ((response['TotalDownload']/1024)/1024);
    var newTotal = newUpload+newDownload;
    console.log(newTotal);

    var oldUpload = 0;
    var oldDownload = 0;
    var oldTotal = 0;

    con.query('SELECT * FROM mainData', (err,rows) => {
      if(err) throw err;

      if (rows[0]) {
        oldUpload = rows[0]['upload']
        oldDownload = rows[0]['download']
        oldTotal = rows[0]['total']

        con.query("DELETE FROM mainData", (err,rows) => {
          if(err) throw err;
        });
      }
    });

    setTimeout(function() {
      con.query("INSERT INTO mainData (upload, download, total) VALUES (" + newUpload + ", " + newDownload + ", " + newTotal + ")", (err,rows) => {
          if(err) throw err;
        });

        var dayUpload = newUpload-oldUpload;
        var dayDownload = newDownload-oldDownload;
        var dayTotal = newTotal-oldTotal;
        console.log(newTotal + " " + oldTotal);
        console.log(dayTotal);

        console.log("        DAY VALUES");
        console.log(" ");
        console.log("Upload: " + dayUpload);
        console.log("Download: " + dayDownload);
        console.log("Total: " + dayTotal);


        con.query("SELECT * FROM `"+year+"_"+month+"` WHERE day='" + day + "'", (err,rows) => {
            if(err) throw err;
            if (rows[0] != undefined) {

              var addUpload = parseInt(rows[0]['upload']);
              var addDownload = parseInt(rows[0]['download']);
              var addTotal = parseInt(rows[0]['total']);

              if (dayUpload > addUpload) {
                dayUpload = dayUpload+(dayUpload-addUpload);
                dayDownload = dayDownload+(dayDownload-addDownload);
                dayTotal = dayTotal+(dayTotal-addTotal);
              } else {
                dayUpload = dayUpload+addUpload;
                dayDownload = dayDownload+addDownload;
                dayTotal = dayTotal+addTotal;
              }

              con.query("DELETE FROM `"+year+"_"+month+"` WHERE day='" + day + "'", (err,rows) => {
                  if(err) throw err;
              });
            }

            setTimeout(function() {
              con.query("INSERT INTO `"+year+"_"+month+"` (dayNo,day,upload,download,total) VALUES ('"+dayNo+"', '"+day+"', '"+dayUpload+"', '"+dayDownload+"', '"+dayTotal+"')", (err,rows) => {
                  if(err) throw err;
              });
            }, 500);
          });
    }, 500);
  });
});




setTimeout(function() {
  con.end((err) => {});
}, 2000);
