<script>
  import { _ } from "svelte-i18n";
  import SvelteRouter, { Link } from "svelte-router";
</script>

<nav class="navbar is-transparent">
  <div class="navbar-brand">
    <Link to="/">
      <span class="navbar-item">WP Elementor Studio</span>
    </Link>

    <div
      class="navbar-burger burger"
      data-target="navbarExampleTransparentExample">
      <span />
      <span />
      <span />
    </div>
  </div>

  <div id="navbarExampleTransparentExample" class="navbar-menu">
    <div class="navbar-start">
      <Link to="/themes">
        <span class="navbar-item">Themes</span>
      </Link>
      <!-- <a class="navbar-item" href="/themes" use:link>Themes</a> -->
      <!-- <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="#">About Us</a>
        <div class="navbar-dropdown is-boxed">
          <a class="navbar-item" href="#">Our Team</a>
          <a class="navbar-item" href="#">Our Story</a>
          <a class="navbar-item" href="#">Locations</a>
        </div>
      </div> -->
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="field is-grouped">
          <p class="control">
            <a class="button is-primary" href="#">
              <span class="icon">
                <i class="far fa-envelope-open" />
              </span>
              <span>Contact</span>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</nav>
