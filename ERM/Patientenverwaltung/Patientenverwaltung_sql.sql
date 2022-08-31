use patientenverwaltung;

select concat_ws(' ', p.pat_vname, p.pat_nname) as 'Patient', p.pat_svnr as 'SVNr', 
azp.azp_name as 'Arztpraxis', b.bef_nummer as "Befundnummer", m.med_name as 'Medikament', 
r.rez_dosierung as 'Dosierung'
from patient p
natural left join arztpraxis azp
natural left join befund b
natural left join rezept r
natural left join medikament m;

select concat_ws(' ', p.pat_vname, p.pat_nname) as 'Patient', t.tmv_date as 'Termin', 
b.bef_nummer as 'Befundnummer', b.bef_erstellt as 'Bufund erstellt am'
from patient p
natural left join terminverlauf t
natural left join befund b
where t.tmv_date like '2022-08-31 08:30:00';

insert into terminverlauf (tmv_date, pat_id) values ('10-10-2022', 5);

select * from terminverlauf;