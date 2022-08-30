<?php
if(isset($_GET['seite']))
{
    switch($_GET['seite'])
    {
        case 'patient':
            echo '
    <li><a href="?seite=home">Startseite</a></li>
    <li><a href="?seite=diagnose">Diagnose Hinzufügen</a></li>
    <li class="active"><a href="?seite=patient">Patienten - Diagnosen</a></li>';
            break;
        case 'diagnose':
            echo '
    <li><a href="?seite=home">Startseite</a></li>
    <li class="active"><a href="?seite=diagnose">Diagnose Hinzufügen</a></li>
    <li><a href="?seite=patient">Patienten - Diagnosen</a></li>';
            break;
        default:
            echo '
    <li class="active"><a href="?seite=home">Startseite</a></li>
    <li><a href="?seite=diagnose">Diagnose Hinzufügen</a></li>
    <li><a href="?seite=patient">Patienten - Diagnosen</a></li>';
    }
} else
{
    echo '
    <li class="active"><a href="?seite=home">Startseite</a></li>
    <li><a href="?seite=diagnose">Diagnose Hinzufügen</a></li>
    <li><a href="?seite=patient">Patienten - Diagnosen</a></li>';
}