-- Julian Rabmer, 25.05.2022
-- Taxiunternehmen

use taxi;

-- Wieviel das Taxiunternehmen für den Fahrer für das Laden bezhalen muss
select t.txu_name as "Taxiunternehmen", concat_ws(' ', f.fah_vname, f.fah_nname) as "Taxifahrer", 
concat((al.aul_kw / lp.ldp_menge) * lp.ldp_preis, '€') as "Preis fürs Laden", 
concat_ws(' ', lp.ldp_preis, '€', lp.ldp_menge, 'W')  as "Preis pro W", 
al.aul_kw as "Gesamt W"
from fahrer f
natural join fahrer_auto fa
natural join auto a
natural join auto_ladestation al
natural join ladestation l
natural join abrechnungsfirma af
natural join ladepreis lp
natural join taxiunternehmen t;