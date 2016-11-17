<?
include($_SERVER['DOCUMENT_ROOT']."/inc/php-reverse-proxy.php");
$proxy=new PhpReverseProxy();
$proxy->port="";
$proxy->host="cloudgen.brinkster.net";
$proxy->forward_path="";
$proxy->connect();
$proxy->output();
?>