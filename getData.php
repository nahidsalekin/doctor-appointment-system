<?php
include('connection.php');

$keyword = trim(file_get_contents("php://input"));
$keyword = json_decode($keyword, true);
$keyword = $keyword['data'];

$doctors=array();
$sql = "SELECT * FROM doctor WHERE name LIKE '%$keyword%' OR email LIKE '%$keyword%' OR
        qualification LIKE '%$keyword%' OR specialty LIKE '%$keyword%'";
$result = mysqli_query($connDB,$sql);

function formatTime($time){
    $date = new DateTime("2020-09-27 ".$time);
    return $date->format('h:ia') ;
}

while($row = $result->fetch_assoc()) {
    $startTime = formatTime($row['startTime']);
    $endTime = formatTime($row['endTime']);
    $doctor = array(
        "id" => $row['id'],
        "name" => $row['name'],
        "email" => $row['email'],
        "qualification" => $row['qualification'],
        "specialty" => $row['specialty'],
        "startTime" => $startTime,
        "endTime" => $endTime
    );
    array_push($doctors,$doctor);
}
echo json_encode($doctors);

?>
