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

if (!Session::Logged() && $action == Action::LogIn)
{
  $pw = Data::Post('pw');

  if ($pw == "aKfasd6Ws412afashg")
  {
    Session::LogIn();
    $pw = "__valid_token__";
  }
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
    <title>Helbreath Fury - Cash Shop</title>
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
    Password: <input type="password" name="pw" value="">
    <?php AddHiddenAction(Action::LogIn); ?>
    <input type="submit" value="Log In">
  </form>
</div>
<?php
}
?>
</div>
</section>
</section>
</body>
</html>