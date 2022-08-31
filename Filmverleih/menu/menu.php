<?php
if(isset($_GET['seite']))
{
    switch($_GET['seite'])
    {
        case 'searchSchauspieler':
            echo '
    <li><a href="?seite=home">Startseite</a></li>
    <li><a href="?seite=searchFilm">Film suchen</a></li>
    <li class="active"><a href="?seite=searchSchauspieler">Schauspieler suchen</a></li>';
            break;
        case 'searchFilm':
            echo '
    <li><a href="?seite=home">Startseite</a></li>
    <li class="active"><a href="?seite=searchFilm">Film suchen</a></li>
    <li><a href="?seite=searchSchauspieler">Schauspieler suchen</a></li>';
            break;
        default:
            echo '
    <li class="active"><a href="?seite=home">Startseite</a></li>
    <li><a href="?seite=searchFilm">Film suchen</a></li>
    <li><a href="?seite=searchSchauspieler">Schauspieler suchen</a></li>';
    }
} else
{
    echo '
    <li class="active"><a href="?seite=home">Startseite</a></li>
    <li><a href="?seite=searchFilm">Film suchen</a></li>
    <li><a href="?seite=searchSchauspieler">Schauspieler suchen</a></li>';
}