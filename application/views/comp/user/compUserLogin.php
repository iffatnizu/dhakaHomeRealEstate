
<div class="container">

    <?php
    if ($this->session->userdata('_errorlUserLogin')) {
        ?>
        <div class="alert alert-danger"><i class="glyphicon glyphicon-remove-circle"></i> Incorrect username or password</div>
        <?php
    }
    $session['_errorlUserLogin'] = FALSE;
    $this->session->unset_userdata($session);
    ?>
    <section id="content">
        <form action="<?php echo site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX); ?>" method="POST">
            <h1><i class="glyphicon glyphicon-home"></i> DhakaHome</h1>

            <div>
                <input type="text" required="" id="username" name="userUserName" />
            </div>
            <div>
                <input type="password" required="" id="password" name="userPassword" />
            </div>
            <div>
                <input type="submit" name="submit" value="Login"/>
                <a href="#">Lost your password?</a><!--
                <a href="#">Register</a>-->
            </div>
        </form><!-- form -->
    </section><!-- content -->
</div>