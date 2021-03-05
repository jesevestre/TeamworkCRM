
select * from somocap.opeprod where num_ordre='OF201319'
select * from somocap.opeprod where num_ordre='OF201320'


select * from somocap.OPELiensof where num_ordre='OF201319'
select * from somocap.OPELiensof where num_ordre='OF201320'

select * from somocap.OPELiensof where num_ordre='OF201319' and compose='C0870'

delete somocap.OPELiensof where num_ordre='OF201319' and compose='C0870'


SELECT NUM_CAMPAGNE FROM somocap.LCAMPAGNE WHERE NUM_ORDRE='OF201319'