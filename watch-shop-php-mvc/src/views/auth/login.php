    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('assets/images/auth_bg.jpg')"></div>
        <div class="contents order-2 order-md-1">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">
                        <h3>Login to <strong>Colorlib</strong></h3>
                        <?php
                            if(isset($_SESSION["errors"])) {
                                $errorMessage = join(", ", $_SESSION["errors"]);
                                echo "<p class='mb-4 text-danger'>
                                * $errorMessage
                                </p>";
                                unset($_SESSION["errors"]);
                            }
                            
                        ?>
                        <form method="POST">
                            <div class="form-group first">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" required placeholder="your-email@gmail.com" id="username" />
                            </div>
                            <div class="form-group last mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" minlength="6" required name="password" placeholder="Your Password" id="password" />
                            </div>
                            <div class="d-flex mb-5 align-items-center">
                                <!-- <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                                    <input type="checkbox" checked="checked" />
                                    <div class="control__indicator"></div>
                                </label> -->
                                <!-- <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> -->
                            </div>
                            <input type="submit" value="Log In" class="btn btn-block btn-primary" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>