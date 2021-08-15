if (document.addEventListener) {
    document.addEventListener("DOMContentLoaded", function() {
        loaded();
    });
} else if (document.attachEvent) {
    document.attachEvent("onreadystatechange", function() {
        loaded();
    });
}

function loaded() {

    setInterval(loop, 300);

}

var x = 0;

var titlestart = ["H","Ho","Hom","Home","Home |"
    ,"Home | H","Home | Ho","Home | Hor","Home | Hors","Home | Horst","Home | HorstB","Home | HorstBl","Home | HorstBlo"
    ,"Home | HorstBloc","Home | HorstBlock","Home | HorstBlocks","Home | HorstBlock","Home | HorstBloc","Home | HorstBlo"
    ,"Home | HorstBl","Home | HorstB","Home | Horst","Home | Hors","Home | Hor","Home | Ho","Home | H","Home |","Home","Hom","Ho","H"];
function loop() {
    document.getElementsByTagName("title")[0].innerHTML = titlestart[x++%titlestart.length];

}
