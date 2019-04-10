<?php
session_start();
require_once '../../controller/connection.php';
require_once '../../model/users.php';
if(isset($_POST['login'])){
  $admin = new User();
  $admin->login($_POST['username'],$_POST['password']);
}

if(isset($_SESSION['data'])){
  header('Location:dashboard.php');
}

?>
<!doctype html>
<html lang="en">
<?php include '../head.html'; ?>

<body>
  <br><br><br><br><br><br><br><br><br><br><br>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Login Admin</h4>
                            </div>
                            <div class="content">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Username</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                          <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Username" name="username">
                                          </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                          <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password" name="password">
                                          </div>
                                        </div>
                                    </div>

                                    <input type="submit" name="login" class="btn btn-primary btn-fill pull-right" value="Login">
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <br><br><br><br><br><br>
    <?php include '../footer.html'; ?>
</body>

<?php include '../script.html'; ?>
</html>
