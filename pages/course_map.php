<?php
// Include your database connection file
include '../components/connect.php';

// Check if the user is authenticated
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
    exit();
}

// Fetch properties' addresses from the database
$sql = "SELECT address,course_name FROM course";
$stmt = $conn->prepare($sql);
$stmt->execute();

$properties = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $properties[] = [
        'address' => $row['address'],
        'course_name' => $row['course_name']
    ];
}

$conn = null; // Close the database connection

// Google API Key
$apiKey = "AIzaSyCzWK845lT1EQvUKg05tCUsvGojzUEqO7I";

// Function to get latitude and longitude
function getLatLong($address, $apiKey) {
    $address = urlencode($address);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$apiKey";
    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if ($json['status'] == 'OK') {
        $lat = $json['results'][0]['geometry']['location']['lat'];
        $lng = $json['results'][0]['geometry']['location']['lng'];
        return ['lat' => $lat, 'lng' => $lng];
    }
    return null;
}

$propertiesWithLatLng = [];
foreach ($properties as $property) {
    $latLng = getLatLong($property['address'], $apiKey);
    if ($latLng) {
        $propertiesWithLatLng[] = array_merge($latLng, ['course_name' => $property['course_name']]);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Courses Map</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlhWXc3HoufHZ2fo79d3SIHwMsr7l3uCk&libraries=places"></script>
    <link rel="stylesheet" href="../css/map.css">
</head>
<body>
    
    <div class="legend">
        <div><img src="http://maps.google.com/mapfiles/ms/icons/red-dot.png" alt="Property Icon"> Courses</div>
        <div><img src="http://maps.google.com/mapfiles/ms/icons/yellow-dot.png" alt="University Icon"> Universities </div>
        <!-- Add other icons and descriptions here -->
    </div>
    <div id="map"></div>
    <button id="backButton">Back</button>

    <script>
    window.onload = function() {
        initMap();
    };

    var properties = <?php echo json_encode($propertiesWithLatLng); ?>;

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: {lat: 7.8731, lng: 80.7718} // Center of Sri Lanka
        });

        var universities = [
            {lat: 6.90056118692669, lng: 79.85874977595309, name: "University of Colombo"}, 
            {lat: 6.8532806382215385, lng: 79.90345242301883, name: "University of Sri Jayewardenepura"},
            {lat: 7.2561024245764685, lng: 80.5974303940056, name: "University of Peradeniya"},
            {lat: 5.95475597516703, lng: 80.57491703081584, name: "University of Ruhuna"},
            {lat: 9.684074061981999, lng: 80.02303232511855, name: "University of Jaffna"},
            {lat: 6.795351316070711, lng: 79.90080262217833, name: "University of Moratuwa"}, 
            {lat: 7.794649186427269, lng: 81.57896345102085, name: "Eastern University"},
            {lat: 7.306921877249198, lng: 81.85127776231889, name: "South Eastern University"},
            {lat: 6.983292585495374, lng: 81.07937049519575, name: "Uva Wellassa University"}, 
            {lat: 6.714857574362131, lng: 80.78726141053845, name: "Sabaragamuwa University"},
            {lat: 8.361068761850731, lng: 80.50331543753336, name: "Rajarata University"},
            {lat: 7.090596769018995, lng: 80.03656922218003, name: "Gampaha Wickramarachchi University"},
            {lat: 6.910244515316396, lng: 79.86253011368899, name: "University of the Visual and Performing Arts"},, 
            {lat: 7.4647988024123535, lng: 80.02165005287094, name: "Wayamba University"},
            {lat: 9.684137517692644, lng: 80.02305378279067, name: "university of jaffna"},, 
            {lat: 8.764234025710142, lng: 80.4953545100352, name: "University of Vavuniya"},
            {lat: 6.975893376907745, lng: 79.91547730330142, name: "University of Kelaniya"}
        ];

        // Custom icon for universities
        var universityIcon = {
            url: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png', // URL of the university icon
            scaledSize: new google.maps.Size(36, 36) // Size of the icon
        };

        // Mark universities with custom icons
        universities.forEach(function(university) {
            new google.maps.Marker({
                position: {lat: university.lat, lng: university.lng},
                map: map,
                title: university.name,
                icon: universityIcon
            });
        });

        // Mark properties
        properties.forEach(function(property) {
            new google.maps.Marker({
                position: {lat: property.lat, lng: property.lng},
                map: map,
                title: property.course_name // Add title to the marker
            });
        });
    }
    document.getElementById('backButton').addEventListener('click', function() {
        window.location.href = '/Link2Serve/pages/all_courses.php'; // Navigate to listings.php
    });
    </script>
</body>
</html>
