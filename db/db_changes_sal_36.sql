update vx_aln_data_defns set alias = 'accept'  where aln_data_typeID = 19 and aln_data_value = 'Accept & confirm';
update vx_aln_data_defns set alias = 'reject'  where aln_data_typeID = 19 and aln_data_value = 'Reject and send regrets'


 ALTER TABLE VX_aln_dtpf_ext DROP COLUMN bid_value;

 ALTER TABLE VX_aln_dtpf_ext DROP COLUMN cash;
 ALTER TABLE VX_aln_dtpf_ext DROP COLUMN miles;
ALTER TABLE VX_aln_dtpf_ext DROP COLUMN bid_submit_date;

