CREATE TABLE occurrences
(employ_id number CONSTRAINT occur_fk REFERENCES employees(emp_id),
login_date timestamp,
logout_date timestamp
);