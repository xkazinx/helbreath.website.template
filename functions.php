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
        <h3>'.Html::Escape($title).'</h3>
        <p>'.Html::Escape($description).'</p>
    </div>';
}

class Html
{
  // Text from the database or the request, made safe to print inside HTML.
  public static function Escape($str)
  {
    return htmlspecialchars((string)$str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
  }

  // Escaped, with its line breaks kept.
  public static function Paragraph($str)
  {
    return nl2br(Html::Escape($str));
  }
};

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

  public static function Redirect($url)
  {
    header('location:'.$url);
    exit;
  }
};

// The site's settings: config.php (git-ignored, made from config.sample.php).
class Config
{
  private static $cfg = null;

  public static function Get($key)
  {
    if (Config::$cfg === null)
    {
      $file = __DIR__.'/config.php';

      if (!file_exists($file))
      {
        http_response_code(500);
        exit('config.php is missing: copy config.sample.php to config.php and fill it in.');
      }

      Config::$cfg = require $file;
    }

    return Config::$cfg[$key] ?? null;
  }
};

class DB
{
  public static function Init()
  {
    $db = Config::Get('db');
    $dsn = 'mysql:host='.$db['host'].';port='.$db['port'].';dbname='.$db['name'].';charset=utf8mb4';
    return new PDO($dsn, $db['user'], $db['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
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
      // SameSite=Lax: another site's form posts arrive without the admin's session
      session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']) || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') == 'https',
      ]);
      session_start();
    }
  }

  public static function Is()
  {
    return session_status() == PHP_SESSION_ACTIVE;
  }

  public static function Logged()
  {
    return !empty($_SESSION['admin']);
  }

  // The admin password is checked against config.php's admin_hash (password_hash).
  public static function LogIn($pw)
  {
    $hash = Config::Get('admin_hash');

    if (!$hash || !password_verify($pw, $hash))
    {
      return false;
    }

    session_regenerate_id(true);
    $_SESSION['admin'] = true;
    return true;
  }

  public static function LogOut($url = "")
  {
    if ($url == "")
    {
      $url = Page::GetCurrentFile().".php";
    }

    $_SESSION = [];
    session_destroy();
    Page::Redirect($url);
  }
};

class Form
{
  public static function AddHidden($name, $value)
  {
    echo '<input type="hidden" name="'.Html::Escape($name).'" value="'.Html::Escape($value).'">';
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
