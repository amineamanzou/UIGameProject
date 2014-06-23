
<div class="container menu">
    <nav id="bt-menu" class="bt-menu">
        <a href="#" class="bt-menu-trigger" onclick="pause();"><span>Menu</span></a>
        <ul>
            <li><a href="#">Profil</a></li>
            <li><a href="#">Badges</a></li>
            <li><a href="#">Classement</a></li>
        </ul>
        <ul>
            <li><a href="http://www.twitter.com/" class="bt-icon icon-twitter">Twitter</a></li>
            <li><a href="https://plus.google.com/" class="bt-icon icon-gplus">Google+</a></li>
            <li><a href="http://www.facebook.com/pages/" class="bt-icon icon-facebook">Facebook</a></li>
            <li><a href="https://github.com/" class="bt-icon icon-github">icon-github</a></li>
        </ul>
    </nav>

    <button type="button" class="bt-sound btn btn-default btn-sm" onclick="musicGestion();">
        <span class="imgSound glyphicon glyphicon-volume-up"></span>
    </button>

    <button type="button" id="btGo" class="bt-go btn btn-default btn-sm" onclick="gameLoad(ctx); goChange();">
        <span id="spanGo" class="imgSound glyphicon glyphicon-play"></span>
    </button>
</div>