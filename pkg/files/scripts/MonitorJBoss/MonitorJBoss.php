<?php

/*
Author: Kenneth Cheung
Date: 09.10.2008
Description: This is a plug-in monitor that interacts with the web console of JBOSS 4.0.5 through the machine readable interface on JBOSS Servers. 
Usage: Install appropriate files in scripts and xml folder then use erdcloader to load this into the core
*/

$configJBossPort="8080";

$virtual_host = getenv('UPTIME_VIRTUAL_HOST');
$port = getenv('UPTIME_PORT');
$uri = getenv('UPTIME_URI');

//** TEST CODE REMOVE/COMMENT FOR DELIVERY ****
//echo "args ".$argv[1]." ".$argv[2];

//$statusURL = "http://".$argv[1]."/.perf";
//$statusURL = "http://".$argv[1].":".$configJBossPort."/web-console/status?full=true"."\n";
//$statusURL = "http://".$argv[1].":".$configJBossPort."/status?full=true"."\n";

//Status URL; Check if uses Virtual Hostname
if($virtual_host == ''){
      $statusURL = "http://".$argv[1].":".$port.$uri."\n";
} else {
      $statusURL = "http://".$virtual_host.":".$port.$uri."\n";
}

echo "URL=".$statusURL;

//** TEST CODE REMOVE/COMMENT FOR DELIVERY ****
//$statusURL = "http://192.168.77.129:8080/web-console/status?full=true";

//echo $statusURL."<-\n\n";

//Grab the .perf output
$status_output = file( $statusURL );

if($status_output){   //check if we have a connection if not output error message to up.time, if we do have a connection and get the stats lets parse it.


// DEBUGGING CODE COMMENT BEFORE DISTRO
/*
foreach ($status_output as $line_num => $line) {
		
    echo "Line #".($line_num).": " .($line)."\n";
}*/


//START Declare Variables
$freeMemory=null;
$totalMemory=null;
$maxMemory=null;
$maxThreads=null;
$minSpareThreads=null;
$maxSpareThreads=null;
$currentThreadCount=null;
$currentThreadBusy=null;
$maxProcessingTime=null;
$processingTime=null;
$requestCount=null;
$errorCount=null;
$bytesReceived=null;
$bytesSent=null;

//END Declare Variables

//TEST CODE REMOVE OR COMMENT THIS
//echo "\n\n";

//START - STATS COLLECTION



//let's split everything up on the semicolons - trust me it works and it's 1 line of code
//$stats_raw = split('[: ]',$status_output[0]);
$stats_raw = preg_split('/[: ]/',$status_output[0]);

/*
//Let's test this comment out on distro
foreach ($stats_raw as $line_num => $line) {
		
    echo "Line #".($line_num).": " .($line)."\n";
}*/

//free memory
$freeMemory=$stats_raw[40];
echoVar ("freeMemory",$freeMemory);

//total memory
$totalMemory=$stats_raw[45];
echoVar ("totalMemory",$totalMemory);

//max memory
$maxMemory=$stats_raw[50];
echoVar ("maxMemory",$maxMemory);

//max threads
$maxThreads=$stats_raw[55];
echoVar ("maxThreads",$maxThreads);

//min spare threads
$minSpareThreads=$stats_raw[60];
echoVar ("minSpareThreads",$minSpareThreads);

//max spare threads
$maxSpareThreads=$stats_raw[65];
echoVar ("maxSpareThreads",$maxSpareThreads);

//current thread count
$currentThreadCount=$stats_raw[70];
echoVar ("currentThreadCount",$currentThreadCount);

//$currentThreadBusy
$currentThreadBusy=$stats_raw[75];
//$currentThreadBusy = split('<',$currentThreadBusy);
$currentThreadBusy = preg_split('/</',$currentThreadBusy);
$currentThreadBusy = $currentThreadBusy[0];
echoVar ("currentThreadBusy",$currentThreadBusy);


//$maxProcessingTime
$maxProcessingTime=$stats_raw[80]; //this one still keeps the <br> so we need to strip it using split as per below.
//$maxProcessingTime = split('<',$maxProcessingTime);
$maxProcessingTime = preg_split('/</',$maxProcessingTime);
$maxProcessingTime = $maxProcessingTime[0];
echoVar ("maxProcessingTime",$maxProcessingTime);

//$processingTime
$processingTime=$stats_raw[85]; //this one still keeps the <br> so we need to strip it using split as per below.
echoVar ("processingTime",$processingTime);

//$requestCount
$requestCount=$stats_raw[90];
echoVar ("requestCount",$requestCount);

//$errorCount
$errorCount=$stats_raw[94];
echoVar ("errorCount",$errorCount);

//$bytesReceived
$bytesReceived=$stats_raw[98];
echoVar ("bytesReceived",$bytesReceived);

//bytesSent
$bytesSent=$stats_raw[103];
echoVar ("bytesSent",$bytesSent);


//END - PERFORMANCE STATS

}else{
	
	echo "An error has occurred connecting to the jboss webserver status module. Please verify that the server is running by referring to the documentation for this plug-in";
	
}

function echoVar($var,$value){
	
	//This function formats the stdout properly and cleans up the code.
	//ken.cheung@uptimesoftware.com 07.18.2008
	
	echo $var." ".$value."\n";
	
	
}
