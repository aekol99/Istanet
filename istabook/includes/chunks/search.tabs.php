<!-- Start Mobile Tabs -->
<ul class="nav justify-content-center d-flex d-lg-none">
    <li class="nav-item">
    <a class="nav-link <?php echo isActive($searchTarget, "persons"); echo empty($_GET['keyword']) ? ' empty-search': '';?>" href="search.php?starget=persons<?php echo isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword']: ''; ?>">
    <i class="fa fa-user"></i>
    Persons <?php echo $numbPersons !== 'none' ? '('. $numbPersons .')': '';?></a>
    </li>
    <li class="nav-item">
    <a class="nav-link <?php echo isActive($searchTarget, "posts"); echo empty($_GET['keyword']) ? ' empty-search': ''; ?>" href="search.php?starget=posts<?php echo isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword']: ''; ?>">
    <i class="fa fa-image"></i>
    Posts <?php echo $numbPosts !== 'none' ? '('. $numbPosts .')': '';?></a>
    </li>
    <li class="nav-item">
    <a class="nav-link <?php echo isActive($searchTarget, "forum-posts"); echo empty($_GET['keyword']) ? ' empty-search': ''; ?>" href="search.php?starget=forum-posts<?php echo isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword']: ''; ?>">
        <i class="fa fa-archive"></i>
    Archive <?php echo $numbForumPosts !== 'none' ? '('. $numbForumPosts .')': '';?></a>
    </li>
</ul>
<!-- End Mobile Tabs -->
<!-- Start Desktop Tabs -->
<ul class="nav flex-column d-none d-lg-flex">
    <li class="nav-item">
    <a class="nav-link <?php echo isActive($searchTarget, "persons");echo empty($_GET['keyword']) ? ' empty-search': ''; ?>" href="search.php?starget=persons<?php echo isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword']: ''; ?>">
    <i class="fa fa-user mr-1"></i>
    Persons <?php echo $numbPersons !== 'none' ? '('. $numbPersons .')': '';?></a>
    </li>
    <li class="nav-item">
    <a class="nav-link <?php echo isActive($searchTarget, "posts"); echo empty($_GET['keyword']) ? ' empty-search': ''; ?>" href="search.php?starget=posts<?php echo isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword']: ''; ?>">
    <i class="fa fa-image mr-1"></i>
    Posts <?php echo $numbPosts !== 'none' ? '('. $numbPosts .')': '';?></a>
    </li>
    <li class="nav-item">
    <a class="nav-link <?php echo isActive($searchTarget, "forum-posts"); echo empty($_GET['keyword']) ? ' empty-search': ''; ?>" href="search.php?starget=forum-posts<?php echo isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword']: ''; ?>">
        <i class="fa fa-archive mr-1"></i>
    Archive <?php echo $numbForumPosts !== 'none' ? '('. $numbForumPosts .')': '';?></a>
    </li>
</ul>
<!-- End Desktop Tabs -->