<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<title>Facebook events</title>
<head> 
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=en"></script> 
	<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="map_script.js"></script>
	
<?php
/*******************Get the events objects (JSON) by facebook graph api*********************************/
if($_POST)
	$events_id=$_POST["event_id"];
	
else	
	$events_id="events";

$events_id=str_replace(" ","%20","$events_id");
$url="https://graph.facebook.com/search?q=".$events_id."&type=event&limit=10";
$output=file_get_contents($url);
?>

<head>
<script>
/**********************Generated through facebook **************************/
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=385690498127260";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
/***************************************************************************/
var i;
var map;
var geocoder;
var json_facebook1=<?php echo $output;?>;

/********************initialize the google map**************************************************/
function initialize() {
  var myLatlng = new google.maps.LatLng(60.11, 24.50);
    var myOptions = {
      zoom:2,
	  center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
	
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	geocoder = new google.maps.Geocoder();
}
</script>

	

</head>

<body onload="check_address()">
	<div id="search">
		<form  action="index.php" method="post" >
			Events key word: <input type="text" name="event_id" />
			<input type="submit" value="Search" />
		</form>
	</div>
<script>
    var fbuserid, fbtoken;
    var appid = "119717234756798";
    var loggedin = false;
    function loginFB() {
        FB.login(function(response) {
            if (response.session) {
                var session = FB.getSession();
                fbtoken = session.access_token;
                fbuserid = session.uid;
            }
        }, {scopes:'create_event'});
		loggedin=true;
    }
	
      FB.init({appId: appid, status: true, cookie: true,xfbml: true});
	  FB.Event.subscribe('auth.sessionChange', function(response) {
            if (response.session) {
                var session = FB.getSession();
                fbtoken = session.access_token;
                fbuserid = session.uid;
            }
    });
	    FB.getLoginStatus(function(response) {
        if (response.session) {
            var session = FB.getSession();
            fbtoken = session.access_token;
            fbuserid = session.uid;
        }
        else{
            loginFB();
        }
    });
 /**********************Generated through facebook **************************/   
      (function() {
        var e = document.createElement('script');
        e.type = 'text/javascript';
        e.src = document.location.protocol +'//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
/**************************************************************************/	  
	function createEvent(name, startTime, endTime, location, description) {
    var eventData = {
        "access_token": fbtoken,
        "start_time" : startTime,
        "end_time":endTime,
        "location" : location,
        "name" : name,
        "description":description,
        "privacy":"OPEN"
    }
    FB.api("/me/events",'post',eventData,function(response){
		if(response.id){
            alert("We have successfully created a Facebook event with ID: "+response.id);
        }
    })
}

function createMyEvent(){

			var name = $('#event_name').val();
			var startTime = $('#start_time').val();//"10/29/2012 06:00 PM";
			var endTime = $('#end_time').val();
			var location = $('#location').val();
			var description = $('#description').val();
            createEvent(name, startTime,endTime, location, description);
 
}  
</script>
	<div id="session"></div>
<script>
var
  div = document.getElementById('session'),
  showSession = function(response) {
    if (!response.session) {
      div.innerHTML = '<em>Not Connected</em>';
    } else {
      var html = '<table>';
      for (var key in response.session) {
        html += (
          '<tr>' +
            '<th>' + key + '</th>' +
            '<td>' + response.session[key] + '</td>' +
          '</tr>'
        );
      }
      div.innerHTML = html;
	  var session = FB.getSession();
      fbtoken = session.access_token;
      fbuserid = session.uid;
    }
  };
FB.getLoginStatus(function(response) { 
  showSession(response);
  FB.Event.subscribe('auth.sessionChange', showSession);
});
</script>
<div id="create_event_div">
	<p class="create_head">Create an Event</p>
	<div id="create_event">
	<p>Event Name:<input type="text" id="event_name" name="event_name"/></p>
	<p>Start Time:<input type="text" id="start_time" value="03/29/2012 06:00 PM" name="start_time"/></p>
	<p>End Time&nbsp;&nbsp;:<input type="text" value="04/15/2012 06:00 PM" id="end_time" name="end_time"/></p>
	<p>Location&nbsp;&nbsp;:<input type="text" id="location" name="location"/></p>
	<p>Description:<input type="text" id="description" name="description"/></p>
	<p><button onclick="loginFB();createMyEvent()">Add a Event</button><p>
	</div>
</div>
<div id="map_canvas"></div>
<div id="fb-root"></div>
<div class="fb-live-stream" data-event-app-id="385690498127260" data-width="300" data-height="420" data-always-post-to-friends="false"></div>
<iframe src="http://www.facebook.com/plugins/like.php?href=
<?php echo rawurlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&send=true&layout=standard&width=450
&show_faces=true&action=like&colorscheme=light&height=80" scrolling="no" frameborder="0"
style="border:none; overflow:hidden; width:450px;height:80px;" allowTransparency="true">
</iframe>


</body>
</html>
