<?php

use yii\helpers\Html;

$fullname = Yii::$app->user->isGuest ? 'User' : Yii::$app->user->identity->userProfile->firstname . ' ' . Yii::$app->user->identity->userProfile->lastname;
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= \yii\helpers\Url::home() ?>" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <?= $fullname ?>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user-cog mr-2"></i> My Account
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-bell mr-2"></i> Notifications
                </a>
                <div class="dropdown-divider"></div>
                <?= Html::a('<i class="fas fa-sign-out-alt mr-2"></i> Sign Out', ['/auth/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
            </div>
        </li>
        <!-- <li class="nav-item dropdown">
            <a id="userAccountDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Danimar</a>
            <ul aria-labelledby="userAccountDropdown" class="dropdown-menu border-0 shadow">
                <li><a href="#" class="dropdown-item">My Account</a></li>
                <li><a href="#" class="dropdown-item">Notifications</a></li>
                <li class="dropdown-divider"></li>
                <li><?= Html::a('Sign out', ['auth/logout'], ['data-method' => 'post', 'class' => 'dropdown-item']) ?></li>
            </ul>
        </li>
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/auth/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li> -->

        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->