
<?php if ($kind != 'forgot_password'): ?>
  <div class="nk-block-head">
      <div class="nk-block-head-content">
          <h4 class="nk-block-title text-center">New password login has been sent to the email. Please check your email!</h4>
      </div>
  </div>
  <div class="message text-center" style="display: none; background-color: #cc0000; color: white; padding: 5px; margin-bottom: 10px;">
              
  </div>
  <div class="form-group">
      <button style="background-color: #cc0000;" class="btn btn-lg btn-danger btn-block" onclick="loginPage()">LOGIN</button>
  </div>
<?php else: ?>  
  <div class="nk-block-head">
      <div class="nk-block-head-content">
          <h4 class="nk-block-title text-center">FORGOT PASSWORD ?</h4>
          <div class="nk-block-des">
              <p>We get it, stuff happens. Just enter your email address below and we'll send you a new password to your email.</p>
          </div>
      </div>
  </div>
  <div class="message text-center" style="display: none; background-color: #cc0000; color: white; padding: 5px; margin-bottom: 10px;">
    <b>Email not registered!</b>            
  </div>

      <div class="form-group">        
          <div class="form-control-wrap">
              <input autocomplete="email" type="email" class="form-control form-control-lg" required id="email" name="email" placeholder="Enter your email address">
          </div>
      </div>
      <div class="form-group">
          <button style="background-color: #cc0000;" class="btn btn-lg btn-danger btn-block reset_btn" onclick="resetPass()">RESET PASSWORD</button>
      </div>
      <div class="form-group">
        <a href="<?=base_url();?>" class="auth-link text-black"><b>Already have an account? Login Here!</b></a>
      </div>
<?php endif ?>
