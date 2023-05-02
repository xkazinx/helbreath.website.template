<?php
include("functions.php");
Session::Start();
$pdo = DB::Init();

abstract class Action
{
  const None = 0;
  const Add = 1;
  const Modify = 2;
  const Add_Confirm = 3;
  const Modify_Confirm = 4;
  const Modify_Delete = 5;
};

$action = Data::Post('action', Action::None);
if (!Session::Logged())
{
  $action = Action::None;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        PrintCommonHeadProperties();
    ?>
    <title>Helbreath Fury</title>
</head>
<body>
    <?php 
        RenderCommonBody();
        
        if (Session::Logged() && $action != Action::Add && $action != Action::Modify)
        {
        ?>
            <div class="card" style="width: 25%; margin: auto; padding: 0;">
                <form method="post">
                    <?php Form::AddHidden("action", Action::Add); ?>
                    <button type="submit">Add new entry</button>
                </form>
            </div>
        <?php
        }

        $title = Data::Post('title');
        $content = Data::Post('content');
        $id = Data::Post('id');
        
        if ($action == Action::Add || $action == Action::Modify)
        {
            $m = $id != 0;
            $title = $m ? "Modify entry" : "Add new entry";
        
            if ($m)
            {
                $stmt = $pdo->prepare("select * from `news` where `id` = :id limit 1");
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            
                foreach($stmt as $row)
                {
                    $title = $row['title'];
                    $content = $row['content'];
                }
            }
            ?>
            <div class="card">
                <form class="pure-form pure-form-aligned" method="post">
                    Input: <input style="width: 80%" maxlength="50" type="text" name="title" <?php echo $m ? 'value="'.$title.'"' : ''; ?> placeholder="Post title" required><br>
                    <fieldset>
                    <textarea name="content" rows="10" cols="80" placeholder="Post content"><?php echo $content; ?></textarea>
                    </fieldset>
                    <button type="submit" name="action" value="<?php echo $m ? Action::Modify_Confirm : Action::Add_Confirm; ?>" ><?php echo $m ? "Modify" : "Add"; ?></button>
                    <?php
                    if ($m)
                    {
                    Form::AddHidden("id", $id);
                    ?>
                    <button type="submit" name="action" value="<?php echo Action::Modify_Delete; ?>">Delete whole entry</button>
                    <?php
                    }
                    ?>
                    <a href="index.php">Cancel</a>
                </form>
                <br>
                </div>
                <?php
            }
            else if ($action == Action::Add_Confirm)
            {
                $stmt = $pdo->prepare("insert into `news` set `title` = :t, `content` = :c, `date` = NOW()");
                $stmt->bindParam(":t", $title, PDO::PARAM_STR);
                $stmt->bindParam(":c", $content, PDO::PARAM_STR);
                $stmt->execute();
            }
            else if ($action == Action::Modify_Confirm)
            {
                $stmt = $pdo->prepare("update `news` set `title` = :t, `content`= :c where `id` = :id limit 1");
                $stmt->bindParam(":t", $title, PDO::PARAM_STR);
                $stmt->bindParam(":c", $content, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            else if ($action == Action::Modify_Delete)
            {
                $stmt = $pdo->prepare("delete from `news` where `id` = :id limit 1");
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            
            $stmt = $pdo->prepare("select * from `news` order by `id` desc;");
            $stmt->execute();
            
            if ($stmt->rowCount() == 0)
            {
                echo '<br>';
            }
            
            foreach($stmt as $row)
            {
                echo '
                <div class="card">
                <h3>'.$row['title'].'</h3>
                <p>'.$row['content'].'</p>';
                
                if (Session::Logged())
                {
                ?>
                <form method="post" style="display: inline; float:right;">
                    <button type="submit" >Modify</button>
                    <?php
                    Form::AddHidden("action", Action::Modify);
                    Form::AddHidden("id", $row['id']);
                    ?>
                </form>
                <br>
                <?php
                } 
            echo '</div>'; 
            } 
            ?>
            </div>
        </section>
    </section>
</body>
</html>