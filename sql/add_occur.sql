/**
Procedura wpisuje stempel czasowy logowania lub wylogowania 
pracownika.
W procedurze wystêpuje obsluga wyjatku blednego wpisywania do tabeli.
**/
CREATE OR REPLACE PROCEDURE add_occur
(employee_id IN NUMBER, occur_type IN NUMBER, correct OUT NUMBER)
IS
    cursor f_curr is select * from occurrences 
    where login_date is not null and logout_date is null and employ_id=employee_id;
    
    ro occurrences%rowtype;
    
    rowc      NUMBER;
    li_excep  EXCEPTION;
    lo_excep  EXCEPTION;
    curr_time TIMESTAMP;
BEGIN
    curr_time := CURRENT_TIMESTAMP;
    correct   := 0;

    if occur_type = 0 then
    open f_curr;                          
    loop 
    fetch f_curr into ro;
    exit when f_curr%notfound;
    end loop;
    rowc := f_curr%rowcount;
    close f_curr;
    if rowc > 0
    then raise li_excep; 
    end if;
    insert into occurrences (employ_id, login_date)
    values (employee_id, curr_time); 
    elsif occur_type = 1 then 
    open f_curr;                          
    loop 
    fetch f_curr into ro;
    exit when f_curr%notfound;
    end loop;
    rowc := f_curr%rowcount;
    close f_curr;
    if rowc = 0
    then raise lo_excep; 
    end if;
    update occurrences set logout_date = curr_time where logout_date is null and employ_id=employee_id 
    and login_date=(select max(login_date) from occurrences where employ_id=employee_id);
    end if;
    
    
    exception
    when li_excep then
    insert into warnings (employ_id, time_warn, desc_warn)
    values (employee_id, curr_time, 'Problem z logowaniem. Pracownik jest niewylogowany');
    correct := 1;

    when lo_excep then
    insert into warnings (employ_id, time_warn, desc_warn)
    values (employee_id, curr_time, 'Problem z wylogowaniem. Pracownik jest niezalogowany');
    correct := 1;
    
END;
/