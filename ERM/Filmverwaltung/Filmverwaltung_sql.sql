use filmverwaltung;

select * from film;

select f.fim_titel as 'Titel', f.fim_erscheinungsdatum as 'Erscheinungs-Datum', 
p.prf_name as 'Produktionsfirma' from film f
natural left join produktionsfirma p
where p.prf_name like '%stone%'
order by f.fim_erscheinungsdatum;

select count(*) from film f
natural left join produktionsfirma p
where p.prf_name like '%jul%';

select distinct p.prf_name as 'Produktionsfirma' 
from film f
natural left join produktionsfirma p
where p.prf_name like '%stone%';

select count(*) 
from film f
natural left join film_schauspieler fsc
natural left join schauspieler s
where concat_ws(" ", s.sch_vname, s.sch_nname) like '%%';

select f.fim_titel as 'Titel', f.fim_erscheinungsdatum as 'Erscheinungs-Datum',
concat_ws(' ', s.sch_vname, s.sch_nname) as 'Schauspieler', p.prf_name as 'Produktionsfirma'
from schauspieler s
natural left join film_schauspieler fsc
natural left join film f
natural left join produktionsfirma p
where concat_ws(' ', s.sch_vname, s.sch_nname) like '%Julian%';

select count(*)
from schauspieler s
natural left join film_schauspieler fsc
natural left join film f
where concat_ws(" ", s.sch_vname, s.sch_nname) like '%Rabmer%';