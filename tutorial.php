<!DOCTYPE HTML>
<html>
    <head>
        <script src="https://data.psc.ac.uk/js/psc.js"></script>

        <script type="text/javascript">
            var clientId = '[YOUR-CLIENT-ID]';
            var scope = 'timetable';

            // Check for access token
            function checkAuth() {
                psc.auth.authorise({clientId:clientId, scope:scope}, 'handleAuthResult');
            }

            function handleAuthResult(authResult) {
                var authorizeButton = document.getElementById('authorize-button');
                if (authResult && !authResult.error) {
                  authorizeButton.style.visibility = 'hidden';
                  readTimetable();
                } else {
                  console.log(authResult.message);
                  authorizeButton.style.visibility = '';
                  authorizeButton.onclick = checkAuth;
                }
            }

            function readTimetable() {
                // Load the timetable for the current week
                psc.api.call("timetable").then(function(data) {
                    var HTML = '';
                    for (var key in data.timetable) {
                        if (data.timetable.hasOwnProperty(key)) {

                            HTML += "<li>"+data.timetable[key].Title+" : "+data.timetable[key].Start+"</li>";
                        }
                    }
                    document.getElementById('load').innerHTML = HTML;
                }, function(error) {
                    console.log(error);
                });
            }
        </script>
    </head>
    <body onload="checkAuth()">
        <button id="authorize-button" style="visibility: hidden">Log in</button>
        <h1>Timetable</h1>
        <ul id="load"><li>loading</li></ul>
    </body>
</html>

