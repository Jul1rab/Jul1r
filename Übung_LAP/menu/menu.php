<?php
if(isset($_GET['seite']))
{
    switch($_GET['seite'])
    {
        case 'tabelle':
            echo '
    <li><a href="?seite=home">Startseite</a></li>
    <li class="active"><a href="?seite=tabelle">Tabelle</a></li>';
            break;
        default:
            echo '
    <li class="active"><a href="?seite=home">Startseite</a></li>
    <li ><a href="?seite=tabelle">Tabelle</a></li>';
    }
} else
{
    echo '
    <li class="active"><a href="?seite=home">Startseite</a></li>
    <li ><a href="?seite=tabelle">Tabelle</a></li>';
}