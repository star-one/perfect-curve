<header>
<!-- Navbar - Luxbar by https://balzss.github.io/luxbar/ -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/luxbar/0.1.0/luxbar.css">
<div class="luxbar luxbar-fixed">
    <input type="checkbox" id="luxbar-checkbox">
    <div class="luxbar-menu luxbar-menu-material-brown">
        <ul class="luxbar-navigation">
            <li class="luxbar-header">
                <a href="/"><?= $Logo; ?></a>
                <label class="luxbar-hamburger luxbar-hamburger-spin"
                        for="luxbar-checkbox"> <span></span> </label>
            </li>
<li class="luxbar-item"><a href="/" title="Home">Home</a></li>
<li class="luxbar-item"><a href="/groups" title="Groups">Groups</a></li>
<li class="luxbar-item"><a href="/members" title="Members">Members</a></li>
<?php if ($_SESSION['LoggedIn']) { ?>
<li class="luxbar-item"><a href="/dashboard" title="Dashboard">My dashboard</a></li>
<li class="luxbar-item"><a href="/invite" title="Invite new member">Invite</a></li>
<li class="luxbar-item"><a href="/change-password" title="Change password">Change password</a></li> <?php // make that link to be the edit-profile when you've done that page ?>
<li class="luxbar-item"><a href="/logout" title="Logout">Logout</a></li>
<?php } else { ?>
<li class="luxbar-item"><a href="/login" title="Login / register">Login / register</a></li>
<?php
}
?>
        </ul>
    </div>
</div>
</header>
<div id="main">