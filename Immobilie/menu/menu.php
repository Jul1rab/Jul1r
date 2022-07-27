<?php
if(isset($_GET['seite']))
{
    switch($_GET['seite'])
    {
        case 'update':
            echo '
    <li><a href="?seite=home">Startseite</a></li>
    <li><a href="?seite=immobilie">Alle Immobilien</a></li>
    <li><a href="?seite=raum">Raum</a></li>
    <li><a href="?seite=search">Suche</a></li>
    <li class="active"><a href="?seite=update">Update Immobilie</a></li>';
            break;
        case 'search':
            echo '
    <li><a href="?seite=home">Startseite</a></li>
    <li><a href="?seite=immobilie">Alle Immobilien</a></li>
    <li><a href="?seite=raum">Raum</a></li>
    <li class="active"><a href="?seite=search">Suche</a></li>
    <li><a href="?seite=update">Update Immobilie</a></li>';
            break;
        case 'immobilie':
            echo '
    <li><a href="?seite=home">Startseite</a></li>
    <li class="active"><a href="?seite=immobilie">Alle Immobilien</a></li>
    <li><a href="?seite=raum">Raum</a></li>
     <li><a href="?seite=search">Suche</a></li>
     <li><a href="?seite=update">Update Immobilie</a></li>';
            break;
        case 'raum':
            echo '<li><a href="?seite=home">Startseite</a></li>
    <li ><a href="?seite=immobilie">Alle Immobilien</a></li>
    <li class="active"><a href="?seite=raum">Raum</a></li>
    <li><a href="?seite=search">Suche</a></li>
    <li><a href="?seite=update">Update Immobilie</a></li>';
            break;
        default:
            echo '
    <li class="active"><a href="?seite=home">Startseite</a></li>
    <li ><a href="?seite=immobilie">Alle Immobilien</a></li>
    <li><a href="?seite=raum">Raum</a></li>
    <li><a href="?seite=search">Suche</a></li>
    <li><a href="?seite=update">Update Immobilie</a></li>';
    }
} else
{
    echo '
    <li class="active"><a href="?seite=home">Startseite</a></li>
    <li ><a href="?seite=immobilie">Alle Immobilien</a></li>
    <li><a href="?seite=raum">Raum</a></li>
    <li><a href="?seite=search">Suche</a></li>
    <li><a href="?seite=update">Update Immobilie</a></li>';
}