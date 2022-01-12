LOAD DATA INFILE 'C:/Workspaces/study/sql/text/supp.txt'
INTO TABLE supp
FIELDS TERMINATED BY '^';

LOAD DATA INFILE 'C:/Workspaces/study/sql/text/supplier.txt'
INTO TABLE supp
FIELDS TERMINATED BY '~';
