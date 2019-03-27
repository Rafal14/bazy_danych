CREATE TABLE jobs
(job_id number not null,
job_name varchar2(30) not null,
work_hours number not null,
CONSTRAINT jobs_pk PRIMARY KEY (job_id)
);