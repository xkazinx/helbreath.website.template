<?php

function RenderNavbar()
{
    echo '<nav>
        <ul>
            <li><a href="./index.php">Home</a></li>
            <li><a href="./register.php">Register</a></li>
            <li><a href="#">Download</a></li>
            <li><a href="./cash_shop.php">Cash Shop</a></li>
        </ul>
        <div class="divider"></div>
    </nav>';
}

function PrintCommonHeadProperties()
{
    echo '
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    ';
}

function RenderCard($title, $description)
{
    echo '
    <div class="card">
        <h3>'.$title.'</h3>
        <p>'.$description.'</p>
    </div>';
}


class Page
{
  public static function GetCurrentLink()
  {
    return $_SERVER["SCRIPT_FILENAME"];
  }

  public static function GetCurrentFile()
  {
    return basename(Page::GetCurrentLink(), '.php');
  }

  public static function FileIs($name)
  {
    return Page::GetCurrentFile() == $name;
  }

  public static function GetClientIP()
  {
    return $_SERVER['REMOTE_ADDR'];
  }
};

class DB
{
  public $host;
  public $port;
  public $user;
  public $pass;
  public $db;

  function __construct($port, $host, $user, $pass, $db)
  {
    $this->host = $host;
    $this->port = $port;
    $this->user = $user;
    $this->pass = $pass;
    $this->db = $db;
  }

  public static function Local()
  {
    return file_exists("localdb.php");
  }

  public static function Auth($gamedb = false)
  {
    $auth = null;

    if (DB::Local())
    {
      if ($gamedb)
      {
        $auth = new DB("3307", "localhost", "root", "root", "hbsite");
      }
      else
      {
        $auth = new DB("3307", "localhost", "root", "root", "hbsite");
      }
    }
    else
    {
      if ($gamedb)
      {
        $auth = new DB("3307", "localhost", "root", "root", "hbsite");
      }
      else
      {
        $auth = new DB("3307", "localhost", "root", "root", "hbsite");
      }
    }

    return $auth;
  }

  public static function Init($gamedb = false)
  {
    $auth = DB::Auth($gamedb);
    return new PDO('mysql:host='.$auth->host.';port='.$auth->port.';dbname='.$auth->db.'', $auth->user, $auth->pass);
  }
};

class Session
{
  public static function Start()
  {
    if (!headers_sent())
    {
      header('cache:private');
      
    }
    if (!Session::Is())
      {
        session_start();
      }
  }

  public static function Is()
  {
    return session_status() != PHP_SESSION_NONE;
  }

  public static function Logged()
  {
    return isset($_SESSION['user']) && $_SESSION['user'] == "kjASJHKgsaduiSDASAYT";
  }

  public static function LogIn()
  {
    $_SESSION['user'] = "kjASJHKgsaduiSDASAYT";
  }

  public static function LogOut($url = "")
  {
    if ($url == "")
    {
      $url = Page::GetCurrentFile().".php";
    }

    session_destroy();
    header('location:'.$url);
  }
};

class Form
{
  public static function AddHidden($name, $value)
  {
    echo '<input type="hidden" name="'.$name.'" value="'.$value.'">';
  }
};


class Data
{
  public static function IsGet($str = "")
  {
    if ($str == "")
    {
      return $_GET;
    }

    return isset($_GET[$str]);
  }

  public static function Get($str, $default = "")
  {
    if (Data::IsGet($str))
    {
      return $_GET[$str];
    }

    return $default;
  }

  public static function IsPost($str = "")
  {
    if ($str == "")
    {
      return $_POST;
    }

    return isset($_POST[$str]);
  }

  public static function Post($str, $default = "")
  {
    if (Data::IsPost($str))
    {
      return $_POST[$str];
    }

    return $default;
  }
};

function RenderCommonBody()
{
    RenderNavbar();
    
    echo '<section class="main">
        <h1>Helbreath Fury</h1>
        
        <section class="news">
            <div class="news-cards">';
}
?>