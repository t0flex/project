function hideBtn() {
    document.getElementById('upload').style.display = 'none';
    document.getElementById('res').innerHTML = "Идет загрузка файла";
}

function handleResponse(mes) {
    console.log(mes);
    document.getElementById('upload').style.display = 'block';
    if (mes['errors'] != null) {
        document.getElementById('res').innerHTML = "Возникли ошибки во время загрузки файла";
    }
    else {
        mes.forEach(function (value) {
            var img = "<img src='/images/" + value + " ' width='100px' height='100px'>";
            document.getElementById("res").innerHTML += img;
        });

    }
}


function add_more() {
    var txt = "<br><input type=\"file\" name=\"userfile[]\">";
    document.getElementById("dvFile").innerHTML += txt;
}