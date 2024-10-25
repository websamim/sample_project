<?php
/*
########################################################################################################
Name  : PHP & Mysql Object Oriented Programming with PDO                                                                  
Author  : Sadirul Islam
E-mail  : sadirul.islam786@gmail.com
License : *******
Description :   This a PHP class to Which help you create a dynamic website with MySQL and PDO. 
  You can Login, Register & SELECT, INSERT, UPDATE, DELETE MySQL data by very secure way. 
  You can also generate user real IP address and location. This is a very secure php class 
  to make professional web application.
########################################################################################################
*/

//DATABASE CONNECTION
require_once('dbconfig.php');

//SET TIME ZONE
date_default_timezone_set('Asia/Kolkata');
//CREATE USER CLASS
class USER
{
  //CONNECTION VARIABLE
  private $conn;

  //SESSION VARIABLE
  private $sessionName;

  // SMTP USEERNAME
  public $smtpUsername;
  public $smtpPassword;
  public $companyName;

  public function __construct() {
    $database = new Database();
    $this->conn = $database->dbConnection();
    $this->sessionName = $database->session_name();
    $this->smtpUsername = $database->smtpUsername;
    $this->smtpPassword = $database->smtpPassword;
    $this->companyName = $database->companyName;

  }

  //MySQL QUERY TO LOGIN
  public function login($uname, $pass, $tbl = "user") {
    try {
      $stmt = $this->conn->prepare("SELECT * FROM $tbl WHERE MD5(username) = :uname AND MD5(password) = :pass");
      $stmt->execute(array('uname' => md5($uname),'pass' => md5($pass)));
      $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
      if($stmt->rowCount() > 0) {
        if($pass == $userRow['password']) {
          $_SESSION[$this->sessionName] = $userRow['id'];
          return true;
        } else {
          return false;
        }
      }
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }


  //CHANGE PASSWORD
  public function change_password($cur_pass, $new_pass, $tbl = 'user'){
    $this->query("SELECT password FROM $tbl WHERE id = :id");
    $this->bind("id", $this->sessionID());
    $row = $this->fetchOne();
    if($row['password'] == $cur_pass){
      $this->query("UPDATE $tbl SET password = :password WHERE id = :id");
      $this->bind("password",$new_pass);
      $this->bind("id",$this->sessionID());
      if($this->execute()){
        return true;
      }
    }else{
      return false;
    }
  }


  //USER EXISTS OR NOT
  public function isExists($tbl, $col, $val) {
    $this->query("SELECT * FROM $tbl WHERE $col = :val");
    $this->bind('val', $val);
    $this->execute();
    if($this->rowCount() > 0) {
        return true;
    }else{
        return false;
    }
  }


  //LOGOUT
  public function logout($redirect = '') {
    session_destroy();
    unset($_SESSION[$this->sessionName]);
    if(!empty($redirect)){
      $this->redirect($redirect);
    }
    return true;
  }


  //GET SESSION ID
  public function sessionID() {
    if(isset($_SESSION[$this->sessionName])){
      return $_SESSION[$this->sessionName];
    }
  }


  //USER IS LOGEDIN OR NOT
  public function isLogedin() {
  if(isset($_SESSION[$this->sessionName]) && !empty($_SESSION[$this->sessionName])){
    return true;
  }
  }

     
  //LAST INSERT ID
  public function insertID(){
   return $this->conn->lastInsertId();
  }


  private $stmt;
  private $res;

  // MYSQL QUERY FUNCTION WITH prepare STATEMENT
  public function query($sql) {
    return $this->stmt = $this->conn->prepare($sql);
  }



  //MYSQL EXECUTE FUNCTION
  public function execute() {
   return $this->stmt->execute();
  }


  //DELETE MYSQL ROW
  public function delete_row($table, $id) {
    $this->query("DELETE FROM $table WHERE id = :id");
    $this->bind("id", $id);
    if($this->execute()){
      return true;
    }
  }


  //MYSQLI FETCH ASSOC
  public function fetchOne() {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
  }


  //MYSQLI FETCH ALL
  public function fetchAll() {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC); 
  }


  //ROW COUNT
  public function rowCount() {
    $this->execute();
    return $this->stmt->rowCount();
  }

  //CHECK EMAIL IS TRUE OR NOT
  public function isEmail($email){
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
         return true;
    }
  }

  //CHECK IS NAME OR NOT
  public function isName($name){
    if (preg_match("/^[a-zA-Z ]*$/",$name)) {
       return true; 
     }
  }


  //IS USERNAME
  public function isUsername($username){
    if (preg_match("/^[a-zA-Z0-9]*$/",$username)) {
       return true; 
     }
  }


  //INTEGER VAL IS ODD
  public function isEven($int){
    $int = $this->int($int);
    if(is_integer($int)){
      if($int % 2 === 0){
        return true;
      }
    }else{
      return "is_even() function take only integer value.";
    }
  }


  //IS MOBILE
  function isMobile($mobile){
    if (preg_match("/^[0-9]*$/",$mobile)) {
       return true; 
     }
  }


  //HIDE CARD AND MOBILE NO
  public function hide_number($number, $show, $hidden_with = "X"){
     $no = $this->str($number);
     return str_repeat($hidden_with, $this->len($no) - $show) . substr($no, -$show);
  }


  //REPEAT TEXT
  public function repeat($text, $num){
    return str_repeat($text, $num);
  }


  //CLOSE CONNECTION
  public function connClose() {
    return $this->conn = null;
  }


  //DINAMICALLY BIND DATA
  public function bind($param, $value, $type = null) {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    return $this->stmt->bindValue($param, $value, $type);
  }   


  //ENCRYPT DATA
  public function encrypt($value){
    return md5(sha1($value));
  }


  //CREATE COOKIE
  public function setcookie($cookie_name, $cookie_value, $time_in_hour = 1){
    if(!empty($cookie_name)){
      if(!empty($cookie_value)){
        return setcookie($this->encrypt($cookie_name),$cookie_value,time() + 3600 * $time_in_hour, "/");
      }else{
       echo "Missing cookie value.";
      }
    }else{
      echo "Missing cookie name!";
    }
    
  }


  //GET COOKIE
  public function getcookie($cookie_name){
    if(!empty($cookie_name)){
      if(isset($_COOKIE[$this->encrypt($cookie_name)])){
        return $_COOKIE[$this->encrypt($cookie_name)];
      }
    }else{
      echo "Missing cookie name.";
    }
  }


  //SLEEP FUNCTION
  public function pause($second) {
    return sleep($second);
  }


  //STRING LOWER CASE
  public function lower($str) {
    if(is_string($str)){
      return strtolower($str);
    }else{
      return "lower() function is for String.";
    }
  }


  //STRING IN CAMELCASE
  public function camelcase($str){
    if(is_string($str)){
      return ucwords($this->lower($str));
    }else{
      return "camelcase() function is for String.";
    }
  }


  //STRING UPPER CASE 
  public function upper($str) {
    if(is_string($str)){
      return strtoupper($str);
    }else{
      return "upper() function is for String.";
    }
  }


  //RANDOM NUMBER
  public function random($start, $end) {
    if(is_integer($start) && is_integer($end) && $start < $end){
      return mt_rand($start,$end);
    }else{
      return "random() function take two param as integer and start value must be less than end value.";
    }
  }


  //RANDOM STRING
  public function str_random($str) {
    if(is_string($str)){
      return str_shuffle($str);
    }else{
      return "str_random() function is only for String.";
    }
  }

   
  //DELETE LAST ELEMRNT FORM AN ARRAY
  public function pop($array){
    if(is_array($array)){
       array_pop($array);
       return $array;
    }else{
      return "pop() function is only for Array.";
    }
  }


  //WHICH ELEMRNT IS APPEND IN AN ARRAY
  public function popped($array){
    if(is_array($array)){
       return array_pop($array);
    }else{
      return "popped() function is only for Array.";
    }
  }


  //APPEND ELEMRNT IN AN ARRAY
  public function append($array, $val){
    if(is_array($array)){
      array_push($array, $val);
      return $array;
    }else{
      echo "append() function is for array.";
    }
  }


  //SPLIT TEXT TO ARRAY
  public function split($text, $where = ''){
    if(is_string($text)){
      if(empty($where)){
        return str_split($text);
      }else{
      return explode($where, $text);
    }
    }else{
      return "split() function is only for String.";
    }
  }

   
  //JOIN AN ARRAY TO STRING
  public function makejoin($array, $option = ""){
    if(is_array($array)){
     return implode($option, $array);
    }else{
      return "makejoin() function is used only for array.";
    }
  }


  //TRIM STRING
  public function strip($str){
    if(is_string($str)){
      return trim($str);
    }
  }


  //LTRIM STRING
  public function lstrip($str){
    if(is_string($str)){
      return ltrim($str);
    }
  }


  //RTRIM STRING
    public function rstrip($str){
    if(is_string($str)){
      return rtrim($str);
    }
  }


  //GET 1ST ELEMENT OF AN ARRAY
  public function first($arr){
    if(is_array($arr)){
     return current($arr);
    }else{
      echo "first() function is only for array.";
    }
  }


  //GET LAST ELEMENT OF AN ARRAY
  public function last($arr){
    if(is_array($arr)){
     return end($arr);
    }else{
      echo "last() function is only for array.";
    }
  }


  //GET SECONDLAST ELEMENT OF AN ARRAY
  public function secondlast($arr){
    if(is_array($arr)){
     return $arr[$this->len($arr) - 2];
    }else{
      echo "secondlast() function is only for array.";
    }
   }


  //JSON ENCODE AND DECODE
  public function json($arr){
    if(is_array($arr) || is_object($arr)){
      return json_encode($arr);
    }elseif(is_string($arr)){
      return json_decode($arr);
    }
  }


  //REVERSE ARRAY AND STRING
  public function reverse($arr_or_str){
    if(is_string($arr_or_str)){
      return strrev($arr_or_str);
    }elseif(is_array($arr_or_str)){
      return array_reverse($arr_or_str);
    }else{
      return "reverse() function is for array and string.";
    }
  }


  //UNIQUE FROM ARRAY
  public function unique_array($arr){
    if(is_array($arr)){
      return array_unique($arr);
    }else{
      return "unique() function is only for array.";
    }
  }


  //GET ALL KEYS OF AN ARRAY
  public function all_keys($arr){
    if(is_array($arr)){
      return array_keys($arr);
    }else{
      return "all_keys() function only for array.";
    }
   }


  //VIEW SOURCE CODE OF THE FILE
  public function view_source($file){
    if(is_file($file)){
      return show_source($file);
    }else{
      return "$file not exists!";
    }
  }


  //AUTH KEY
  public function auth_key($length = 20) {
    return substr(str_shuffle("AbCdEfGhIjKlMnOpQrStUvWxYz".sha1(time()).md5(date('Y/m/d h:i:s'))), 0, $length);
  }

  //SUM OF ARRAY
  public function sum($array){
    if(is_array($array)){
      return array_sum($array);
    }else{
      return "sum() function is only for array.";
    }
  }


  //MULTIPLY EACH VALUE OF AN ARRAY
  public function multiply($arr){
    if(is_array($arr)){
      $ans = 1;
      foreach($arr as $val){
        if(is_integer($val)){
          $ans *= $val;
        }
      }
      return $ans;
    }
  }


  //CHECKING VALUE IN ARRAY OR NOT
  public function in($key, $arr){
    if(is_array($arr) && !empty($key)){
      if(in_array($key, $arr)){
        return true;
      }
    }else{
      echo "In in() function second param must be an not empty array.";
    }
  }


  //GET DATA TYPE
  public function type($var){
    return gettype($var);
  }


  //GET DATA FROM WEB BY GET REQUESTS
  public function requests($url, $data = array(), $method = 'get'){
      if($this->is_url($url) && !empty($url)){
        if(is_array($data)){
          if($method === "get"){
            $ch = curl_init();  
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $output=curl_exec($ch);
            curl_close($ch);
            return $output;
          }else if($method === "post"){
            $ch = curl_init($url);
            $param = http_build_query($data);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            return curl_exec($ch);
            curl_close($ch);
          }
        }else{
          return "Data must be an array.";
        }
      }else{
        return "Unknown URL!";
      }
  }


  //DOWNLOAD FILES FROM WEB
  public function download($url, $dir, $filename){
    if(!is_dir($dir)){
      mkdir($dir);
    }
    if($this->is_url($url)){
      $content = file_get_contents($url);
      return $this->file($dir.'/'.$filename, "w", $content);
    }else{
      echo "Wrong download URL!";
    }
  }


  //CHECk REAL URL OR NOT
  public function is_url($url) {
    if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)){
      return true;
    }
  }


  //REDIRECT 
  public function redirect($url) {
    header("Location: $url");
  }


  //READ TEXT FILE
  public function file($filename, $mode = "r", $text = '') {
    if($mode == "r" || $mode == "r+"){
      if(file_exists($filename)){
        $fp = fopen($filename, $mode);
        return fread($fp, filesize($filename));
        fclose($fp);
      }else{
        echo "$filename not exists to read!";
      }
    }elseif($mode == "a" || $mode == "a+" || $mode == "w" || $mode == "w+"){
      $fp = fopen($filename, $mode);
      fwrite($fp, $text);
      fclose($fp);
    }else{
      echo "Wrong file mode.";
    }
  }


  // DELETE FILE
  public function file_delete($filename){
    if(file_exists($filename)){
      unlink($filename);
      return true;
    }
  }



  //READ FILE LINE B LINE
  public function readlines($filename){
    if(file_exists($filename)){
      $fp = fopen($filename, "r");
      $arr = array();
      while (($line = fgets($fp)) !== false){
        array_push($arr, $line);
      }
      return $arr;
      fclose($fp);
    }else{
      echo "$filename file not exists!";
    }
  }



  //GET EMAIL FROM TEXT
  public function mail_from_text($text) {
    if (!empty($text)) {
      $res = preg_match_all(
      "/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i",
      $text,
      $matches
      );
      if ($res) {
      foreach(array_unique($matches[0]) as $email) {
        echo $email . "<br />";
      }
      }
      else {
      echo "No emails found.";
      }
    }
  }


  //URL DIR WITH FILE NAME
  public function dir_and_file() {
    return $_SERVER['PHP_SELF'];
  }


  //URL FILE NAME
  public function url_file_name() {
    return basename($_SERVER['PHP_SELF']);
  }


  //FULL URL
  public function full_url() {
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    return $actual_link;
  }


  //GET FULL DOMAIN
  public function get_domain(){
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    return $actual_link;
  }


  //STRING TO INTEGER
  public function strtoint($str) {
    $intValue = intval(preg_replace('/[^0-9]+/', '', $str));
    return $intValue;
  }


  //GET QUERY VARIABLE FROM COSTUME URL
  public function get_url_var($url) {
    $parts = parse_url($url);
    if(isset($parts['query'])){
    parse_str($parts['query'], $query);
    return $query;
   }
  }


  public function YouTubeID($url){
    $video_id = false;
    $url = parse_url($url);
    if (strcasecmp($url['host'], 'youtu.be') === 0) {
        $video_id = substr($url['path'], 1);
    } elseif (strcasecmp($url['host'], 'www.youtube.com') === 0) {
        if (isset($url['query'])) {
            parse_str($url['query'], $url['query']);
            if (isset($url['query']['v'])) {
                $video_id = $url['query']['v'];
            }
        }
        if ($video_id == false) {
            $url['path'] = explode('/', substr($url['path'], 1));
            if (in_array($url['path'][0], array('e', 'embed', 'v'))) {
                $video_id = $url['path'][1];
            }
        }
    }
    return $video_id;
  }


  //GET DATE FUNCTION
  public function get_date($type) {
    if($type == 'first') {
      return date('Y-m-01 H:i:s');
    }elseif($type== 'last') {
      return date('Y-m-t H:i:s');
    }elseif($type == 'today'){
      return date('Y-m-d H:i:s');
    }elseif($type == 'next'){
      return date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') .' +1 day'));
    }elseif($type == 'prev'){
      return date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') .' -1 day'));
    }elseif($type == 'time'){
      return date('Y-m-d H:i:s');
    }
  }


  // DATE FORMAT
    public function dateFormat($format, $date){
      $new_date = date($format, strtotime($date));
      return $new_date;
    }



  //EXPIRY DATE
  public function expiry_date($expiry = "+28 days", $date = ""){
   if(empty($date)){
    $date = date("Y-m-d H:i:s");
   }
    return date('Y-m-d H:i:s', strtotime($date . $expiry));
  }


  //DATE IS EXPIRED OR NOT
  public function is_expired($date){
    $today = date("Y-m-d h:i:s");
    if($date < $today){
      return true;
    }
  }


  //GE DAY BETWEEN TWO DATE
  public function total_day($date2, $date1 = ''){
    if(empty($date1)){
      $date1 = date_create(date("Y-m-d h:i:s"));
    }else{
      $date1 = date_create($date1);
    }
    $date2 = date_create($date2);
    $diff = date_diff($date1, $date2);
    return $diff->format("%R%a");
  }
    


  //pagination
  public function pagination($row_per_page, $total_row) {
    if(!isset($_GET['page']) || empty($_GET['page'])) {
        $page = 1;
      } else {
          $page= $this->escape($_GET['page']);
      }
      $next_page = $page + 1;
      $previous_page = $page - 1;
      $offset = $previous_page * $row_per_page;
      $total_pages = ceil($total_row/$row_per_page);
      $pagination_data = array('page'=>$page, 'next_page'=>$next_page, 'previous_page'=>$previous_page, 'offset'=>$offset, 'limit'=>$row_per_page, 'total_page'=>$total_pages);
      return (object)$pagination_data;
  }


  //CHECKING WHO LOGGEDIN
  public function isAdmin($tbl = 'user') {
    $stmt = $this->query("SELECT type FROM $tbl WHERE id = :uid");
    $stmt->execute(array('uid' => $_SESSION[$this->sessionName]));
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $type = $userRow['type'];
    if($type == 'admin') {
      return true;
    } else {
      return false;
    }
  }


  //GET USER DATA BY ID
  public function user_data($tbl = 'user', $id) {
    $this->query("SELECT * FROM $tbl WHERE id = :uid");
    $this->bind('uid', $id);
    if($this->rowCount() > 0){
      $userRow = $this->fetchOne();
      return (array) $userRow; 
    }else{
      return false;
    }
  }


  //GET USER IP ADDRESS
  public function userIP() {
    $clint = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR']; 
    $remote = $_SERVER['REMOTE_ADDR'];
    if(filter_var($clint,FILTER_VALIDATE_IP)){
      $ip = $clint;
    }elseif (filter_var($forward,FILTER_VALIDATE_IP)) {
      $ip = $forward;
    }else{
      $ip = $remote;
    }
    return $ip;
  }


  //ESCAPE SPECIAL CHAR
  public function escape($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars_decode($data);
    $data = strip_tags($data);
    return $data;
    }


  //BREAK
  public function br($str){
    return nl2br($str);
  }


  //REPLACE TEXT IN TEXT
  public function replace($from, $to, $text){
    return str_replace($from, $to, $text);
  }


  //ENCODE STRING
  public function hash_text($text){
    if(is_string($text)){
        return str_rot13($text);
    }else{
      echo "hash_text() function param must be string.";
    }
  }


  //ADD KEY INTO ARRAY
  public function add_keys($keys, $arr_val){
    if(is_array($keys) && is_array($arr_val)){
      return array_combine($keys, $arr_val);
    }
  }


  //MERGE TOW ARRAY
  public function add_array($arr1, $arr2){
    if(is_array($arr1) && is_array($arr2)){
      return array_merge($arr1,$arr2);
    }else{
      echo "add_array() function take two array.";
    }
  }


   //ADD PAGE VISITOR
  public function visitor($type = "set") {
   switch ($type) {
     case 'set':
        $date = date('Y-m-d');
        $ip = $this->userIP();
        $this->query("SELECT * FROM visitor WHERE date = :date AND ip = :ip");
        $this->bind("date",$date);
        $this->bind("ip",$ip);
        $this->execute();
        $row = $this->fetchOne();
        $incr = $row['count'] + 1;
        $count = 1;

        if($this->rowCount() > 0) {
             $sql = $this->query("UPDATE visitor SET count = :count WHERE date = :date AND ip = :ip");
             $this->bind("count",$incr);
             $this->bind("date",$date);
             $this->bind("ip",$ip);
             $this->execute(); 
        }else{
           $sql = $this->query("INSERT INTO visitor(ip, date, count) VALUES(:ip, :date, :count)");
             $this->bind("ip", $ip);
             $this->bind("date", $date);
             $this->bind("count", $count);
             $this->execute();
        }
       break;

       case 'today_unique':
          $date = date('Y-m-d');
          $this->query("SELECT id FROM visitor WHERE date = :date");
          $this->bind("date", $date);
          $this->execute();
          return $this->rowCount();
          break;

       case 'today_total':
          $date = date('Y-m-d');
          $this->query("SELECT sum(count) AS count FROM visitor WHERE date = :date");
          $this->bind("date", $date);
          $this->execute();
          $count = $this->fetchOne();
          return $count['count'];
          break;

       case 'monthly_unique':
          $start = date("Y-m-01");
          $endd = date("Y-m-t");
          $this->query("SELECT id FROM visitor WHERE date BETWEEN :start AND :endd");
          $this->bind("start", $start);
          $this->bind("endd", $endd);
          return $this->rowCount();
          break;

       case 'monthly_total':
          $start = date("Y-m-01");
          $end = date("Y-m-t");
          $this->query("SELECT sum(count) AS count FROM visitor WHERE date BETWEEN :start AND :endd");
          $this->bind("start", $start);
          $this->bind("endd", $end);
          return $this->fetchOne()['count'];
          break;

       case 'yearly_total':
          $start = date("Y-01-01");
          $end = date("Y-12-31");
          $this->query("SELECT sum(count) AS count FROM visitor WHERE date BETWEEN :start AND :endd");
          $this->bind("start", $start);
          $this->bind("endd", $end);
          return $this->fetchOne()['count'];
          break;
     }
  }


  //GENERATE CSRF TOKEN
  public function csrf_token($type = "set"){
    if($type === 'set'){
      $tkn = $this->str_random(md5(sha1(time()."ABCDEFGIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789")));
      $csrf_tkn = $this->create_session('csrf_token', $tkn);
      return '<input class="csrf_token" type="hidden" name="csrf_token" value="'.$csrf_tkn.'" id="csrf_token">';
    }elseif ($type === 'get'){
     if(isset($_POST['csrf_token']) && !empty($_POST['csrf_token']) && !empty($this->get_session('csrf_token'))){
       if($_POST['csrf_token'] == $this->get_session('csrf_token')){
         return true;
       }
      }
    }
  }

  // GET CSRF TOKEN
  public function inline_csrf($type = "set"){
    if($type == "set"){
      $tkn = $this->str_random(md5(sha1(time()."ABCDEFGIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789")));
      $csrf_tkn = $this->create_session('csrf_token', $tkn);
      return $tkn;
    }elseif($type === 'get'){
      if(isset($_GET['csrf_token']) && !empty($_GET['csrf_token']) && !empty($this->get_session('csrf_token'))){
       if($_GET['csrf_token'] == $this->get_session('csrf_token')){
         return true;
       }
      }
    }
  }


  //GET LENGTH OF ARRAY AND STRING
  public function len($val){
     if(is_string($val)){
          return strlen($val);
     }elseif(is_array($val)){
          return count($val);
     }else{
          echo "len() function in only for string and array.";
    }
  }


  //FILE EXISTS OR NOT
  public function file_exists($file){
    if(file_exists($file)){
      return true;
    }
  }


  //DIRECTORY
  public function directory($dir, $mode = "create"){
   if($mode == "create"){
      return mkdir($dir);
   }elseif($mode == "delete"){
      if(is_dir($dir)){
        return rmdir($dir);
      }else{
        return $dir." directory not exists!";
      }
    }
  }


  //WORD COUNT FUNCTION 
  public function word_count($str) {
    return str_word_count($str);
  }


  //MOVE UPLOADED FILE
  public function upload_to($file, $destination){
    return move_uploaded_file($file, $destination);
  }

  //CREATE SESSION
  public function create_session($session_name, $session_value = ''){
    return $_SESSION[$session_name] = $session_value;
  }


  //GET SESSION
  public function get_session($session_name){
    if(isset($_SESSION[$session_name])){
        return $_SESSION[$session_name];
      }
  }


  //CONVERT TO INTEGER
  public function int($val){
    return intval($val);
  }


  //CONVERT TO STRING
  public function str($val){
    return strval($val);
  }


  //UPLOAD FILES
  public function file_upload($file, $type, $up_path, $size=52428800) {
    $filename = $file['name'];                    //Name of the file
    $filesize = $file['size'];                    //Size of the file
    $file_tmp_name = $file['tmp_name'];           //TEMP name of the file
    $file_error = $file['error'];                 //File error
    $expld = explode('.', $filename);             //EXPLODE FILE EXTENSION
    $file_ext = strtolower(end($expld));          //GOT THE FILE EXTENSION  
    $up_name = $this->str_random( time().uniqid()).'.'.$file_ext; 
    $upload_to = $up_path.basename($up_name);          
    
    //SET WHAT TYPE OF FILE YOU WANT TO UPLOAD
    if($type == 'image'){
      $ext_arr = ['png', 'jpg', 'jpeg', 'ico'];
    }elseif($type == 'audio'){
      $ext_arr = ['mp3', 'wav', 'ogg', 'mpeg'];
    }elseif($type == 'video'){
      $ext_arr = ['mp4', 'mov', 'wmv', 'flv'];
    }elseif($type == 'pdf' || $type == 'docx'){
      $ext_arr = ['pdf', 'docx'];
    }elseif($type == 'txt'){
      $ext_arr = ['txt'];
    }elseif($type == 'xlsx'){
      $ext_arr = ['xlsx'];
    }elseif($type == "manual"){
      $ext_arr = ['png', 'jpg', 'jpeg', 'ico', 'pdf', 'docx'];
    }
    
    //CHECKING AND UPLOAD
    if(!empty($file_tmp_name)) {
      if(in_array($file_ext, $ext_arr)) {
        if($filesize <= $size) {
         if($file_error == 0) {
          if(move_uploaded_file($file_tmp_name, $upload_to)){
            $details = array('status' => 'success', 'file_name'=>$up_name,'file_size'=>$filesize,'temp_name'=>$file_tmp_name,'file_ext'=>$file_ext);
            return $details;
          }
         } else {
          return ['status' => 'error', 'msg' => 'Something went wrong!'];
         }
        } else {
          return ['status' => 'error', 'msg' => 'File size is too large!'];
        }                 
      } else {
        return ['status' => 'error', 'msg' => 'Not allowed!'];
      }
    } else {
      return ['status' => 'error', 'msg' => 'Please choose a file!'];
    }
  }


  //FILE INFO
  public function fileInfo($file) {
    $file_name = $file['name'];
    $expld = explode(".", $file_name);
    $file_ext = end($expld);
    $file_type = $file['type'];
    $file_size = $file['size'];
    $file_tmp_name = $file['tmp_name'];
    $file_error = $file['error'];

    $file_data = array('name'=>$file_name, 'ext'=>$file_ext, 'type'=>$file_type, 'size'=>$file_size, 'tmp_name'=>$file_tmp_name, 'file_error'=>$file_error);
    return (object) $file_data;
  }


  //CHECK REQUEST IS SAME SERVER OR NOT
  public function isServer(){
   if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){
    $curl = parse_url($_SERVER['HTTP_REFERER']);
    $get_url = $curl['host'];
    $own_url = $_SERVER['HTTP_HOST'];
    if($get_url == $own_url){
       return true;
     }
   }
  }


  //CREATE CAPTCH
  public function captcha($sess = "captcha"){
    $image = @imagecreatetruecolor(120, 30) or die("Cannot Initialize new GD image stream");
    $background = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
    imagefill($image, 0, 0, $background);
    $linecolor = imagecolorallocate($image, 0xCC, 0xCC, 0xCC);
    $textcolor = imagecolorallocate($image, 0x33, 0x33, 0x33);

    for($i=0; $i < 6; $i++) {
      imagesetthickness($image, 1);
      imageline($image, 0, rand(0,30), 120, rand(0,30), $linecolor);
    }

    $digit = '';
    for($x = 15; $x <= 95; $x += 20) {
      $digit .= ($num = rand(0, 9));
      imagechar($image, rand(3, 5), $x, rand(2, 14), $num, $textcolor);
    }

    $this->create_session($sess, $digit);

    header('Content-type: image/png');
    imagepng($image);
    imagedestroy($image);
  }


  //CHECK CAPTCHA
  public function is_captcha($sess = "captcha"){
    if(isset($_POST['captcha_val']) && !empty($_POST['captcha_val'])){
      if($_POST['captcha_val'] === $this->get_session($sess)){
        return true;
      }
    }
  }


  //CAPTCHA REFRESH
  public function captcha_script(){
    echo '<script>
          function captcha_refresh() {
          document.getElementById("captcha_img").src = "captcha.php?" + new Date().getTime();
         }
      </script>';
  }


  //SHOW CAPTHCA IMAGE
  public function captcha_image($file = 'captcha.php', $height = '', $width = ''){
    echo '<img src="'.$file.'?'.rand().'" onclick="captcha_refresh()" id="captcha_img" height="'.$height.'" width="'.$width.'">';
  }


  //CAPTTCH FORM
  public function captcha_form(){
    echo '<input type="text" name="captcha_val" placeholder="Enter captcha" id="captcha_val" class="captcha_val" required>';
  }


  //GET A TO Z IN A STRING
  public function lower_string($start = 0, $end = 26){
      return substr('abcdefghijklmnopqrstuvwxyz', $start, $end);
  }

  //GET A TO Z IN UPPER
  public function upper_string($start = 0, $end = 26){
        return substr('ABCDEFGIJKLMNOPQRSTUVWXYZ', $start, $end);
  }


  //CREATE OTP
  public function otp($len = 6,$session_name = "otp"){
    $start = $this->int(str_repeat("1", $len));
    $end = $this->int(str_repeat("9", $len));
    $otp = $this->random($start, $end);
    $this->create_session($session_name, $otp);
    return $otp;
  }


  //VALIDATE OTP
  public function is_otp($otp, $session_name = "otp"){
    if(isset($otp) && !empty($otp)){
      if($otp == $this->get_session($session_name)){
        return true;
      }
    }
  }

  //CREATE ERROR
  public function show_error($err_msg, $type = E_USER_ERROR){
    return trigger_error($err_msg, $type);
  }


  //SET ALERT
  public function set_alert($msg, $type){
    if($type == "error"){
      $_SESSION['alert'] = '<div class="alert alert-danger alert-dismissible" role="alert">
       <button type="button" class="close" data-dismiss="alert">×</button>
      <div class="alert-icon">
       <i class="fa fa-times"></i>
      </div>
      <div class="alert-message">
        <span>'.$msg.'</span>
      </div>
      </div>';
    }else{
      $_SESSION['alert'] = '<div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <div class="alert-icon">
       <i class="fa fa-check"></i>
      </div>
      <div class="alert-message">
        <span>'.$msg.'</span>
      </div>
      </div>';
    }
  }

  // GET ALERT
  public function get_alert(){
    if(isset($_SESSION['alert'])){
      echo $_SESSION['alert'];
      unset($_SESSION['alert']);
    }
  }

  // PAGE BACK
  public function back(){
    echo "<script>window.history.back()</script>";
  }
  
  // SET WORD
  public function get_words($sentence, $count = 10) {
      preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
      return $matches[0];
  }


  // CURRENCY NAME
  public function currency(){
    $this->query("SELECT currency_name FROM settings LIMIT 1");
    return $this->fetchOne()['currency_name'];
  }

  // GET USER WALLET
  public function user_wallet($id){
    $this->query("SELECT wallet FROM users WHERE id = :id LIMIT 1");
    $this->bind("id", $id);
    return $this->fetchOne()['wallet'];
  }


  // GET PRICE RATE
  public function price_rate(){
    $this->query("SELECT conversion_rate FROM settings LIMIT 1");
    return $this->fetchOne()['conversion_rate'];
  }

  // GET PRICE RATE
  public function wtv(){
    $this->query("SELECT wtv FROM settings LIMIT 1");
    if($this->fetchOne()['wtv'] == "true"){
      return true;
    }else{
      return false;
    }
  }

  // GET PRICE RATE
  public function to_wallet($email){
    $this->query("SELECT wallet FROM users WHERE email = :email LIMIT 1");
    $this->bind("email", $email);
      return $this->fetchOne()['wallet'];
  }

  // GET PRICE RATE
  public function commision_percentage(){
    $this->query("SELECT commotion_percentage FROM settings LIMIT 1");
      return $this->fetchOne()['commotion_percentage'];
  }

  // GET RFERAL AMOUNT
  public function referal_amount(){
    $this->query("SELECT referal_amount FROM settings LIMIT 1");
    return $this->fetchOne()['referal_amount'];
  }

  } //END USER CLASS
?>