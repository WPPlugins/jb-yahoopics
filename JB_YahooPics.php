<?php
/**
 * @package JB_YahooPics
 * @author Jimmy Burnett
 * @version 1.0
 */
/*
Plugin Name: JB_YahooPics
Plugin URI: http://www.jimmyburnett.com/jb_yahoopics
Description: This plugin will allow you to easily include images into any of your posts and sidebar. With just a few lines of code you can show pictures related to your blog posts or any keyword you provide. For instructions ow to use this plugin please goto here: <a target="_new" href="http://www.jimmyburnett.com/jb_yahoopics">http://www.jimmyburnett.com/jb_yahoopics</a>
Author: Jimmy Burnett
Version: 1.0
Author URI: http://www.jimmyburnett.com
*/

function yahooPics_getPics($kw,$picount)
{
 $kw = str_replace(" " ,"+" , $kw);
 $request =  'http://search.yahooapis.com/ImageSearchService/V1/imageSearch?appid=YahooDemo&query=' . $kw . '&results=' . $picount . '&output=php';
 $response = file_get_contents($request);
 $phpobj = unserialize($response);
 return $phpobj;

}


function yahooPicsShow($kw,$style, $picount=1)
{
  

  if ($style =="1")
  {
     $phpobj = yahooPics_getPics($kw,$picount);
     return yahooPicsShow1x1($kw,$phpobj);
  }else{
     $phpobj = yahooPics_getPics($kw,$picount);
     return yahooPicsShow4xN($kw,$phpobj);
  }
}



function yahooPicsShow1x1($kw,$phpobj)
{
  $camUrl = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . 'img/camera_icon.gif';
  foreach($phpobj['ResultSet']['Result'] as $imgobj){
     $str .= '<div style="border:1px solid; width:120px; height:80px; background-repeat: repeat-x; background-image:url(' . 
     $imgobj['Thumbnail']['Url'] . ')"><a href="' .    
     $imgobj['ClickUrl'] . '" border="0"><img src="' . $camUrl . '" border="0" alt="' . $kw . '" /></a></div>';     
  }
  return $str;
}

function yahooPicsShow4xN($kw,$phpobj){
$camUrl = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . 'img/camera_icon.gif';
$count=0;
$str .= '<table>';
foreach($phpobj['ResultSet']['Result'] as $imgobj){  
  //$showsize = $imgobj['Width'] . " x " . $imgobj['Height'] . ' - <a href="' . $imgobj['RefererUrl'] . '" title="' . $imgobj['Title'] . '">Ref..</a>'; 
   if ( $count == 0 )  {    
     $str .= '<tr><td><div style="border:1px solid; width:120px; height:80px; background-repeat: repeat-x; background-image:url(' . $imgobj['Thumbnail']['Url'] . ')"><a href="' . 
     $imgobj['ClickUrl'] . '" border="0"><img src="' . $camUrl . '" border="0" alt="' . $kw . '" /></a></div>' . $showsize . '</td>';     
     $count++;  
    }elseif ( $count == 1 )  { 
     $str .= '<td><div style="border:1px solid; width:120px; height:80px; background-repeat: repeat-x; background-image:url(' . $imgobj['Thumbnail']['Url'] . ')"><a href="' . 
     $imgobj['ClickUrl'] . '" border="0"><img src="' . $camUrl . '" border="0" alt="' . $kw . '" /></a></div>' .  $showsize . '</td>';    
     $count++; 
    }elseif ( $count == 2 )  { 
     $str .= '<td><div style="border:1px solid; width:120px; height:80px; background-repeat: repeat-x; background-image:url(' . $imgobj['Thumbnail']['Url'] . ')"><a href="' . 
     $imgobj['ClickUrl'] . '" border="0"><img src="' . $camUrl . '" border="0" alt="' . $kw . '" /></a></div>' . $showsize . '</td></tr>';     $count++;      
     $count=0; 
    }   
 }
$str .= '</table>';
  return $str;
}


function testPic()
{
return WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . 'img/camera_icon.gif';
}
