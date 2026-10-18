<?php
include("functions.php");

Session::Start();

abstract class Action
{
  const None = 0;
  const LogIn = 1;
  const LogOut = 2;
}

function AddHiddenAction($action)
{
  Form::AddHidden("action", $action);
}

$action = Data::Post('action', Action::None);
$failed = false;

if (!Session::Logged() && $action == Action::LogIn)
{
  $failed = !Session::LogIn(Data::Post('pw'));
}

$logged = Session::Logged();

if ($logged)
{
  if ($action == Action::LogOut)
  {
    Session::LogOut();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        PrintCommonHeadProperties();
    ?>
    <title>Helbreath Fury - Admin</title>
</head>
<body>
    <?php
        RenderCommonBody();
    ?>
<div class="card">
<?php
if ($logged)
{
    ?>
    <p>Logged in: the news on <a href="index.php">Home</a> can be added, modified and deleted.</p>
    <form method="post">
    <?php AddHiddenAction(Action::LogOut); ?>
      <input type="submit" value="Log Out">
    </form>
<?php
}
else
{
?>
    <form method="post">
    Password: <input type="password" name="pw" value="" required>
    <?php AddHiddenAction(Action::LogIn); ?>
    <input type="submit" value="Log In">
  </form>
<?php
    if ($failed)
    {
        echo '<p>Wrong password.</p>';
    }
}
?>
</div>
</div>
</section>
</section>
</body>
</html>
