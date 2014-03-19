<?php

$virtual_host = getenv('UPTIME_VIRTUAL_HOST');
$port = getenv('UPTIME_PORT');
$uri = getenv('UPTIME_URI');

$freeMemory=null;
$totalMemory=null;
$maxMemory=null;
$maxThreads=null;
$currentThreadCount=null;
$currentThreadBusy=null;
$maxProcessingTime=null;
$processingTime=null;
$requestCount=null;
$errorCount=null;
$bytesReceived=null;
$bytesSent=null;

//Status URL; Check if uses Virtual Hostname
if($virtual_host == ''){
      $statusURL = "http://".$argv[1].":".$port.$uri."\n";
} else {
      $statusURL = "http://".$virtual_host.":".$port.$uri."\n";
}

//echo "URL=".$statusURL;

//Grab the perf output
$status_output = file( $statusURL );

//check if we have a connection if not output error message to up.time, if we do have a connection and get the stats lets parse it.
if($status_output)
{   
	//let's split everything up on the semicolons
	$stats_raw = preg_split('/[: ]/',$status_output[0]);

	/*
	// output the split array
	for($i = 0; $i < count($stats_raw); ++$i) {
		echo "i = " . $i . "     value = " . $stats_raw[$i] . "\n";
	}
	*/

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
	$maxThreads=$stats_raw[124];
	echoVar ("maxThreads",$maxThreads);

	//current thread count
	$currentThreadCount=$stats_raw[129];
	echoVar ("currentThreadCount",$currentThreadCount);

	//$currentThreadBusy
	$currentThreadBusy=$stats_raw[134];
	echoVar ("currentThreadBusy",$currentThreadBusy);


	//$maxProcessingTime
	$maxProcessingTime=$stats_raw[139];
	echoVar ("maxProcessingTime",$maxProcessingTime);

	//$processingTime
	$processingTime=$stats_raw[144];
	echoVar ("processingTime",$processingTime);

	//$requestCount
	$requestCount=$stats_raw[149];
	echoVar ("requestCount",$requestCount);

	//$errorCount
	$errorCount=$stats_raw[153];
	echoVar ("errorCount",$errorCount);

	//$bytesReceived
	$bytesReceived=$stats_raw[157];
	echoVar ("bytesReceived",$bytesReceived);

	//bytesSent
	$bytesSent=$stats_raw[162];
	echoVar ("bytesSent",$bytesSent);
}
else
{
	echo "An error has occurred connecting to the jboss webserver status module. Please verify that the server is running by referring to the documentation for this plug-in";
}

function echoVar($var,$value)
{
	echo $var." ".$value."\n";
}