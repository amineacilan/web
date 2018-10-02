<?php
  $query = "SELECT event_date	FROM event_datetime WHERE event_name = 'LastRatioCalculation'";
  $result = mysql_query($query, $connection);    
  $lastRatioCalculationTime = '';
  
  if ($result != FALSE)
  {
    $row = mysql_fetch_assoc($result);   
      
    if ($row)
    {
      $lastRatioCalculationTime = dateConvert($row['event_date'], 'dbToPage', 1);
    }
  }
?>