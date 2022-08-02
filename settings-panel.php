<div class="settings-container">
  <div class="settings-content">
    <h2 class="settings-heading">Change Your Password</h2>
     <form id="settings-form">
      <div class="settings-pwd-input-wrapper">
        <label for="current-password">Current Password</label>
        <input
          data-id="password-1"
          type="password"
          class="settings-password-input"
          placeholder="Current password"
          id="st-current-password"
          value="password123#"

        />
        <button class="settings-eye-icon settings-eye-clear">
          <i class="fas fa-eye"></i>
        </button>
        <button class="settings-eye-icon settings-eye-slash">
          <i class="fas fa-eye-slash"></i>
        </a>
      </div>
      <div class="settings-pwd-input-wrapper">
        <label for="password">New Password</label>
        <input
          data-id="password-2"
          type="password"
          class="settings-password-input"
          placeholder="Pick a new password"
          id="st-new-password"
          value="password$123"

        />
        <button class="settings-eye-icon settings-eye-clear">
          <i class="fas fa-eye"></i>
        </button>
        <button class="settings-eye-icon settings-eye-slash">
          <i class="fas fa-eye-slash"></i>
        </a>
      </div>
      <div class="settings-pwd-input-wrapper">
        <label for="confirm-password">Confirm Password</label>
        <input
          data-id="password-3"
          type="password"
          class="settings-password-input"
          placeholder="Confirm password"
          id="st-confirm-password"
          value="password$123"

        />
        <button class="settings-eye-icon settings-eye-clear">
          <i class="fas fa-eye"></i>
        </button>
        <button class="settings-eye-icon settings-eye-slash">
          <i class="fas fa-eye-slash"></i>
        </a>
      </div>
      <p class="settings-msg">
        *Password should not have a length less than 8, it must have a mix
        of letters, numbers and symbols.
      </p>
      <button class="settings-password-btn" type="submit">Save changes</button>
    </form>

    <div class="close-settings-btn-wrapper">
      <button class="close-settings-btn">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
</div>

<script src="./js/settings.js" type="module" charset="utf-8"></script>
