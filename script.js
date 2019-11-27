var editor = CodeMirror.fromTextArea(document.getElementById("textarea"), {
  lineNumbers: true,
  mode: "text/html",
  matchBrackets: true

});

function addTable() {
  var myTableDiv = document.getElementById("myHistoryTable");
  if (localStorage.length == 0) {
    let elem = document.getElementById("history_label");
    elem.parentNode.removeChild(elem);
  }
  var table = document.createElement('TABLE');
  table.border = '1';
  table.style = "overflow-x:auto";
  table.style = "border-collapse: collapse;width: 100%;";
  var tableBody = document.createElement('TBODY');
  table.appendChild(tableBody);
  table.id = "myHistoryTablet";
  for (var i = 0, len = localStorage.length; i < len; ++i) {

    var tr = document.createElement('TR');
    tableBody.appendChild(tr);

    for (var j = 0; j < 2; j++) {
      var td = document.createElement('TD');
      td.style = 'padding: 8px;text-align: left;border-bottom: 1px solid #ddd;'
        // td.width = '900';
      if (j == 0) {
        const as = document.createElement('a');
        as.href = "https://" + localStorage.key(i) + ".htmlshare.cloud";
        as.innerHTML = "https://" + localStorage.key(i) + ".htmlshare.cloud";
        as.target = "_blanc";

        td.appendChild(as);

      } else {
        td.appendChild(document.createTextNode(localStorage.getItem(localStorage.key(i))));

      }

      tr.appendChild(td);
    }
  }
  myTableDiv.appendChild(table);
}
addTable();


var viewHeight = "90%";
var viewWidth = "80%";
var button = document.querySelector('.button');
var layout = document.querySelector('.layout');
var toolbar = document.querySelector('.toolbar');
var textarea = document.querySelector('.editor__textarea');
button.addEventListener('click', function() {
  layout.classList.add('layout--writing');
  button.style.width = viewWidth;
  setTimeout(function() {
    button.style.height = viewHeight;
  }, 350);
});

var imNotARobot = function(token) {
  console.info("Verification successfull");
  setCookie("captcha_token", token, 1);


  document.getElementById("confirmationForm").submit()


}

function goHistory() {
  let myHistoryTable = document.getElementById("myHistoryTable");
  myHistoryTable.style.display = "block";
  swal("UPLOADS HISTORY", "", "", {
    content: myHistoryTable
  });
}

function go() {
  if (editor.getValue() == "") {
    swal("The code is empty", "Please write some code.", "warning");
    return;
  } else if (editor.getValue().length > 1024 * 1024 * 1) {
    swal("ERROR", "Your HTML code is too large. Max 1MB.", "warning");
    return;
  } else {
    let googlever = document.getElementById("google-ver");
    googlever.style.display = "block";


    swal("Verify that you are not a robot", "Upload will start when verification is successful", "info", {
      content: googlever,
      buttons: false
    });
  }


}

function setCookie(name, value, days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    var expires = "; expires=" + date.toGMTString();
  } else var expires = "";
  document.cookie = name + "=" + value + expires + ";";
}
