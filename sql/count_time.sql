/**
Funkcja oblicza czas pracy pracowników 
pracownika.
**/
CREATE OR REPLACE FUNCTION count_time
(em_id NUMBER)
RETURN NUMBER
IS  
    c_in         TIMESTAMP;
    c_out        TIMESTAMP; 
    ci_date      DATE;
    co_date      DATE;
    rminute      NUMBER;
    rday         NUMBER;
    rhour        NUMBER;
    retval       NUMBER;
BEGIN
    select login_date, logout_date
    into c_in, c_out
    from occurrences 
    where employ_id=1 and login_date=(select max(login_date) from occurrences where employ_id=1 and logout_date is not null);

    rday   := (extract(day from c_out) - extract(day from c_in)) * 24 * 60;
    rhour  := (extract(hour from c_out) - extract(hour from c_in)) * 60;
    rminute:= (extract(minute from c_out) - extract(minute from c_in));
    
    retval:= rday + rhour + rminute;
    
    RETURN retval;
END;
/