<?php

use yii\helpers\Url;

$url = explode('/', substr(Url::current(), 1));

?>
<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>

    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>

    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <a href="<?= Url::to('/', true) ?>" class="<?= $url[0] == 'site' ? 'mm-active' : ''?>">
                        <i class="metismenu-icon fa fa-qrcode"></i>
                        Dashboard
                    </a>
                </li>

                <li class="app-sidebar__heading">Blog</li>
                <li>
                    <a href="<?= Url::to('categories', true) ?>" class="<?= $url[0] == 'categories' ? 'mm-active' : ''?>">
                        <i class="metismenu-icon fa fa-sitemap"></i>
                        Categories
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to('articles', true) ?>" class="<?= $url[0] == 'articles' ? 'mm-active' :  $url[0] == 'article' ? 'mm-active' : ''?>">
                        <i class="metismenu-icon fa fa-th-list"></i>
                        Articles
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to('comments', true) ?>" class="<?= $url[0] == 'comments' ? 'mm-active' : ''?>">
                        <i class="metismenu-icon fa fa-comments"></i>
                        Comments
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to('tags', true) ?>" class="<?= $url[0] == 'tags' ? 'mm-active' : ''?>">
                        <i class="metismenu-icon fa fa-tags"></i>
                        Tags
                    </a>
                </li>

                <li class="app-sidebar__heading">Administrations</li>
                <li>
                    <a href="<?= Url::to('gii', true) ?>">
                        <i class="metismenu-icon fa fa-puzzle-piece"></i>
                        GII
                    </a>
                </li>
                <li class="<?= $url[0] == 'rbac' ? 'mm-active' : ''?>">
                    <a href="#">
                        <i class="metismenu-icon fa fa-users"></i>
                        RBAC
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="<?= $url[0] == 'rbac' ? 'mm-show' : ''?>">
                        <li>
                            <a href="<?= Url::to('rbac/user', true) ?>" class="<?= $url[1] == 'user' ? 'mm-active' : ''?>">
                                <i class="metismenu-icon"></i>
                                User
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to('rbac/assignment', true) ?>" class="<?= $url[1] == 'assignment' ? 'mm-active' : ''?>">
                                <i class="metismenu-icon">
                                </i>Assignment
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to('rbac/role', true) ?>" class="<?= $url[1] == 'role' ? 'mm-active' : ''?>">
                                <i class="metismenu-icon">
                                </i>Role
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to('rbac/permission', true) ?>" class="<?= $url[1] == 'permission' ? 'mm-active' : ''?>">
                                <i class="metismenu-icon">
                                </i>Permission
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to('rbac/route', true) ?>" class="<?= $url[1] == 'route' ? 'mm-active' : ''?>">
                                <i class="metismenu-icon">
                                </i>Route
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to('rbac/rule', true) ?>" class="<?= $url[1] == 'rule' ? 'mm-active' : ''?>">
                                <i class="metismenu-icon">
                                </i>Rule
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to('rbac/menu', true) ?>" class="<?= $url[1] == 'menu' ? 'mm-active' : ''?>">
                                <i class="metismenu-icon">
                                </i>Menu
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>