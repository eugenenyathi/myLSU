<?php 

echo '
  <div class="reminder" id="ctr-password-reminder">
      <p class="reminder-text" id="ctr-password-notif-text">You are required to change your default password to a custom password.</p>
  </div>
  <div class="ctr-password-container" >
    <form action="" class="ctr-password-content">
      <p class="ctr-password-heading">Please change your default password below.</p>
      <div class="ctr-pwd-input-wrapper">
        <label for="nationalId">National ID</label>
        <input
          type="text"
          class="ctr-password-input"
          placeholder="e.g. 79-0011W2233"
          id="ctr-nationalId"
          value="08-503726D19"
        />
      </div>
      <div class="ctr-pwd-input-wrapper">
        <label for="password">New Password</label>
        <input
          type="password"
          class="ctr-password-input"
          placeholder="Pick a new password"
          id="ctr-new-password"
          value="password123#"
        />
        <button class="ctr-eye-icon ctr-eye-clear">
          <i class="fas fa-eye"></i>
        </button>
        <button class="ctr-eye-icon ctr-eye-slash">
          <i class="fas fa-eye-slash"></i>
        </a>
      </div>
      <div class="ctr-pwd-input-wrapper">
        <label for="confirm-password">Confirm Password</label>
        <input
          type="password"
          class="ctr-password-input"
          placeholder="Confirm password"
          id="ctr-confirm-password"
          value="password123#"
        />
        <button class="ctr-eye-icon ctr-eye-clear">
          <i class="fas fa-eye"></i>
        </button>
        <button class="ctr-eye-icon ctr-eye-slash">
          <i class="fas fa-eye-slash"></i>
        </a>
      </div>
      <p class="ctr-msg">
        *Password should not have a length less than 8.
      </p>
      <button class="ctr-password-btn">Save changes</button>
    </form>
</div>
';

?>