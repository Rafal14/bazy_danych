CREATE TABLE employees
(emp_id number not null,
emp_name varchar2(30) not null,
emp_surname varchar2(30) not null,
pesel number(11) not null,
phone_name number(9) not null,
email varchar2(20) not null,
hiredate date not null,
street varchar2(20) not null,
no_build varchar2(10) not null,
zipcode varchar2(6) not null,
city varchar2(30) not null,
job_id number not null,
CONSTRAINT  employ_pk PRIMARY KEY (emp_id),
CONSTRAINT  employ_fk FOREIGN KEY (job_id) REFERENCES jobs (job_id)
);