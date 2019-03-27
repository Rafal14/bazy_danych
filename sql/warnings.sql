CREATE TABLE warnings
(employ_id number CONSTRAINT warn_fk REFERENCES employees(emp_id),
time_warn timestamp,
desc_warn varchar2(60)
);