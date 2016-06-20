#!/bin/bash

# takes one argument - the ams.assets.asset_id - and returns an xml string for use by the AMS php application
# exits when no arg is given or when fails to authenticate with sony or when media item is not found
# requires data in ./config/ci.yml
# requires write access to /tmp/

if [ "$#" -ne 1 ];
	then echo; #exit;
fi;

config_file_path=/var/www/html/application/config/ci.yml;

media_item_id=`mysql ams -u amsread --skip-column-names -B -e "select identifier from identifiers where identifier_source = 'Sony Ci' and assets_id=$1 LIMIT 1"`;

credString=`grep '^cred_string:' "$config_file_path"  | awk '{print $2}'`;
client_id=`grep '^client_id:' "$config_file_path"  | awk '{print $2}'`;

client_secret=`grep '^client_secret:' "$config_file_path"  | awk '{print $2}'`;
workspace_id=`grep '^workspace_id:' "$config_file_path"  | awk '{print $2}'`;

access_token_filepath="/tmp/$workspace_id";
touch "$access_token_filepath";
access_token=`cat "$access_token_filepath"`;
refresh_token='';
media_getString='';
media_getResponseCode='';
mediaDataString='';

function initAuth 
{
	curl -s -S -XPOST -i "https://api.cimediacloud.com/oauth2/token" -H "Authorization: Basic $credString" -H "Content-Type: application/x-www-form-urlencoded" -d "grant_type=password&client_id=$client_id&client_secret=$client_secret";
}


function renewAuth
{
	curl -s -S -XPOST -i "https://api.cimediacloud.com/oauth2/token" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -d "grant_type=refresh_token&refresh_token=$refresh_token&client_id=$client_id&client_secret=$client_secret"
}

function getKeyedValue
{
	#	 arg1 is a JSON string, arg2 is keyName string
	echo "$1" | /var/www/html/application/JSON.sh -b | grep "$2" | cut -f2- | sed -e 's#^"##1' -e 's#".*$##1';
	#	strings returned will NOT be quoted
}


function getResponseCode
{
	echo "$1" | head -1 | awk '{print $2}'
}

function getHTTPBody
{
	
	firstEmptyLineNum=`echo "$1" | grep -vn '[[:alnum:]]' | head -1 | awk -F: '{print $1}'`;
	if [ "$firstEmptyLineNum" ];
	then
		echo "$1" | tail -$(expr $(echo "$1" | wc -l | awk '{print $1}') - "$firstEmptyLineNum" );
	else
		echo -en '';
	fi
	
}

function new_access_token
{
	echo -en > "$access_token_filepath";
	authString=`initAuth`;
	authResponseCode=`getResponseCode "$authString"`;
	authDataString=`getHTTPBody "$authString"`;

	if [ "$authResponseCode" -ne 200 ];
	then 
		errString=`getKeyedValue "$authDataString" '^\["error_description"\]'`;
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		echo '<error>'`echo "$errString" | tr '[[:punct:]]' ' ' `'</error>';
		exit 1;
	fi;
	access_token=`getKeyedValue "$authDataString" '^\["access_token"\]'`;
	refresh_token=`getKeyedValue "$authDataString" '^\["refresh_token"\]'`;
	echo "$access_token" > "$access_token_filepath"; # store it for persistent re-use
}

function get_media_data
{
	media_getString=`curl -s -S -XGET -i "https://api.cimediacloud.com/assets/$media_item_id/download" \
    -H "Authorization: Bearer $access_token"`
	media_getResponseCode=`getResponseCode "$media_getString"`;
	mediaDataString=`getHTTPBody "$media_getString"`;
}


if [ -z "$access_token" ];
then 
	new_access_token;
fi;


# NOW GO GET THAT MEDIA ITEM
get_media_data;

if [ "$media_getResponseCode" -ne 200 ];
then
	new_access_token;
	get_media_data;
fi;

if [ "$media_getResponseCode" -ne 200 ];
then 
	errString=`getKeyedValue "$mediaDataString" '^\["error_description"\]`;
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
	echo '<error>'`echo "$errString" | tr '[[:punct:]]' ' ' `'</error>';
	exit 1;
fi;

media_URL=$(getKeyedValue "$mediaDataString" '^\["location"\]' );

media_format=`echo "$media_URL" | tr '?' '\n' | head -1 | tr '.' '\n' | tail -1`;

echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo "<data>";
echo "   <format>$media_format</format>";
echo '   <mediaurl>'`echo "$media_URL" | sed -e 's#&#&amp;#g'`'</mediaurl>';
echo "</data>"; 
exit;








