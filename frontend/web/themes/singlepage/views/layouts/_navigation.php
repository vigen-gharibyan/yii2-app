<nav class="navbar-inverse navbar-fixed-top navbar" role="navigation" bs-navbar>
    <div class="container">
        <div class="navbar-header">
            <button ng-init="navCollapsed = true" ng-click="navCollapsed = !navCollapsed" type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="#/">My Company</a>
        </div>
        <div ng-class="!navCollapsed && 'in'" ng-click="navCollapsed=true" class="collapse navbar-collapse" >
            <ul class="navbar-nav navbar-right nav">
                <li data-match-route="/$">
                    <a href="#/">Home</a>
                </li>
                <li data-match-route="/about">
                    <a href="#/about">About</a>
                </li>
                <li data-match-route="/contact">
                    <a href="#/contact">Contact</a>
                </li>
                <li data-match-route="/dashboard" ng-show="loggedIn()" class="ng-hide">
                    <a href="#/dashboard">Dashboard</a>
                </li>
                <li ng-class="{active:isActive('/logout')}" ng-show="loggedIn()" ng-click="logout()"  class="ng-hide">
                    <a href="">Logout</a>
                </li>
                <li data-match-route="/login" ng-hide="loggedIn()">
                    <a href="#/login">Login</a>
                </li>
                <li data-match-route="/signup" ng-hide="loggedIn()">
                    <a href="#/signup">Signup</a>
                </li>
            </ul>
        </div>
    </div>
</nav>