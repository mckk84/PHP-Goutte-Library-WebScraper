<?php
require 'vendor/autoload.php';
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

$GLOBALS['env'] = "production"; // development

if( $GLOBALS['env'] !== "development" )
{
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	@ini_set("display_errors", 1);
}
else
{
	error_reporting(E_ALL);
	@ini_set("display_errors", 0);	
}

function get_env()
{
	return ($GLOBALS['env'] == 'development') ? true : false;
}

function _is_goutte_installed()
{
	try{
		$client = new Client();
	}
	catch(Exception $e)
	{
		if( get_env() )
		{
			echo "\n Goutte Library is not installed.\n";
		}
		return false;
	}
	return true;
}

function goutte_request($url)
{
	$response = new stdClass();
	$response->status = 400; // Set Status to Client Error.
	$response->error_message = '';
	$response->output = '';

	// check curl extension is enabled or not
	if( _is_goutte_installed() )
	{
		$url_valid = filter_var($url, FILTER_VALIDATE_URL);
		if( $url_valid )
		{
			if( get_env() )
			{
				echo "\n URL ".$url." is valid \n";
			}
		}
		else
		{
			$response->error_message = $url. " is not a valid url.";
			$response->output = '';
			return $response;
		}

		// Initialize Client
		$client = new Client(HttpClient::create(['timeout' => 60]));
		 
		try{
			$client->request('GET', $url);
			$responseObject = $client->getResponse();
			$http_status = $responseObject->getStatusCode();

			if( is_object($responseObject) )
			{
				$output = $responseObject->getContent();
			}
			else
			{
				$output = '';
			}
			$response->status = $http_status;
			$response->error_message = '';
			$response->output = $output;

			return $response;
		}
		catch(Exception $e)
		{
			$response->error_message = $e->getMessage();
			$response->output = '';
		}
		return $response;
	}
	else
	{
		if( get_env() )
		{
			echo "\nGoutte\Client Library not found.\n";
		}
		$response->error_message = "Goutte library not found.";
		$response->output = '';
		return $response;
	}
}


// Start

// check arguments
if( $argc == 2 )
{
	$url = $argv[1];
}
else
{
	echo "Error Occured\n";
	echo "Could not get URL from command line option\n";
	echo "Usage: php php_goutte.php http://www.example.com\n";
	die();
}

// call request request
$response = goutte_request($url);

// check response for errors.
if( $response->status == 200 )
{
	// output the response
	echo $response->output;
}
else
{
	if( $response->status != 0 )
	{
		echo "Server HTTP Status : ".$response->status." \n";
	}

	if( $response->output != "" )
	{
		echo $response->output;	
	}
	if( $response->error_message != "" )
	{
		echo "Server Response : ".$response->error_message;
	}
}

die();
?>

?>