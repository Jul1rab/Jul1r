<?php
if(isset($_GET['seite']))
{
    switch($_GET['seite'])
    {
        case 'rezeptZeitraumSuche':
            echo '
    <li><a href="?seite=home">Startseite</a></li>
    <li><a href="?seite=rezeptHinzufuegen">Rezept Hinzufügen</a></li>
    <li class="active"><a href="?seite=rezeptZeitraumSuche">Rezept Zeitraumsuchen</a></li>';
            break;
        case 'rezeptHinzufuegen':
            echo '
    <li><a href="?seite=home">Startseite</a></li>
    <li class="active"><a href="?seite=rezeptHinzufuegen">Rezept Hinzufügen</a></li>
    <li><a href="?seite=rezeptZeitraumSuche">Rezept Zeitraumsuchen</a></li>';
            break;
        default:
            echo '
    <li class="active"><a href="?seite=home">Startseite</a></li>
    <li ><a href="?seite=rezeptHinzufuegen">Rezept Hinzufügen</a></li>
    <li><a href="?seite=rezeptZeitraumSuche">Rezept Zeitraumsuchen</a></li>';
    }
} else
{
    echo '
    <li class="active"><a href="?seite=home">Startseite</a></li>
    <li ><a href="?seite=rezeptHinzufuegen">Rezept Hinzufügen</a></li>
    <li class="active"><a href="?seite=rezeptZeitraumSuche">Rezept Zeitraumsuchen</a></li>';
}