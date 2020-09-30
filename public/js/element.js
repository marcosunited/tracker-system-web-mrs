    function isMobile(){
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            return true;
        }
        return false;
    }

    function getLocation() {
        /*
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Please enable GPS / Location data");
        } */
    }

    //Because I am a lazy fuck I am popping the JS function into php, as we need to get the session user_id, for the moment this is in the header template,
    
    //get GPS location every 5 seconds
    setInterval(getLocation,5000);