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
                                <h4 class="title">Cari Nomor Induk Kependudukan</h4>
                            </div>
                            <div class="content">
                                <form method="get" action="data.php">
                                    <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Nomor Induk Kependudukan" name="nik">
                                          </div>
                                        </div>
                                    </div>
                                    <input type="submit" name="s" class="btn btn-primary btn-fill pull-right" value="Cari">
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <br><br><br><br><br><br><br><br><br>
    <?php include '../footer.html'; ?>
</body>

<?php include '../script.html'; ?>
</html>
