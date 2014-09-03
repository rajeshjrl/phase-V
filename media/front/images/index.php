<?php
include_once("pi-classes/global-functions.php");
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Bootbusiness | Short description about company">
        <meta name="author" content="Your name">        
        <title><?php echo SITE_TITLE; ?></title>    
        <?php include("includes/header.php"); ?>
    </head>
    <body>
        <?php include("includes/top-nav.php"); ?>
        <div class="container">
            <div class="bs-docs-section">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 id="buttons">Home</h1>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($_SESSION['msg']['logout_message'] != '') { ?>
                <div class="alert alert-success">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                    <strong></strong> <?php echo $_SESSION['msg']['logout_message']; ?>
                </div>
                <?php
                unset($_SESSION['msg']['logout_message']);
            }
            ?>
            <section>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="well">
                            Welcome page content Welcome page content Welcome page content Welcome page content Welcome page content Welcome page content Welcome page content Welcome page content 
                            Welcome page content Welcome page content Welcome page content Welcome page content Welcome page content Welcome page content Welcome page content Welcome page content 
                        </div>
                    </div>
            </section>
            <br>
        </div>
        <?php include("includes/footer.php"); ?>
    </body>
</html>