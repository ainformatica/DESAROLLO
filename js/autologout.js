//Inactividad sesion


$(function() {

    function timeChecker() {
        setInterval(function() {
            var storedTimeStamp = sessionStorage.getItem("lastTimeStamp");
            timeCompare(storedTimeStamp);
        }, 45000);
    }


    function timeCompare(timeString) {
        var maxMinutes = 10; //GREATER THEN 1 MIN.
        var currentTime = new Date();
        var pastTime = new Date(timeString);
        var timeDiff = currentTime - pastTime;
        var minPast = Math.floor(timeDiff / 600000);
       
        if (minPast > maxMinutes) {
            sessionStorage.removeItem("lastTimeStamp");
            window.location = "../vistas/cerrar_sesion.php";
            return false;
        } else {
            
        }
    }

    if (typeof(Storage) !== "undefined") {
        $(document).mousemove(function() {
            var timeStamp = new Date();
            sessionStorage.setItem("lastTimeStamp", timeStamp);
        });

        timeChecker();
    }
}); //END JQUERY