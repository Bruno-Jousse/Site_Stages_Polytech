
CREATE DATABASE mynewdb
   USER SYS IDENTIFIED BY passemoileselOracle
   USER SYSTEM IDENTIFIED BY unpt6vOuscHAnGles2mDp
   LOGFILE
     GROUP 1 ('/opt/oracle/oradata/mynewdb/redo01a.log',
              '/opt/oracle/oradata/mynewdb/redo01b.log',
              '/opt/oracle/oradata/mynewdb/redo01c.log') SIZE 128M,
     GROUP 2 ('/opt/oracle/oradata/mynewdb/redo02a.log',
              '/opt/oracle/oradata/mynewdb/redo02b.log',
              '/opt/oracle/oradata/mynewdb/redo02c.log') SIZE 128M,
   MAXLOGHISTORY 1
   MAXLOGFILES 16
   MAXLOGMEMBERS 4
   MAXDATAFILES 1024
   CHARACTER SET AL32UTF8
   NATIONAL CHARACTER SET AL16UTF16
   EXTENT MANAGEMENT LOCAL
   DATAFILE '/opt/oracle/oradata/mynewdb/system01.dbf'
     SIZE 700M REUSE AUTOEXTEND ON NEXT 10240K MAXSIZE UNLIMITED
   SYSAUX DATAFILE '/opt/oracle/oradata/mynewdb/sysaux01.dbf'
     SIZE 550M REUSE AUTOEXTEND ON NEXT 10240K MAXSIZE UNLIMITED
   DEFAULT TABLESPACE users
      DATAFILE '/opt/oracle/oradata/mynewdb/users01.dbf'
      SIZE 500M REUSE AUTOEXTEND ON MAXSIZE UNLIMITED
   DEFAULT TEMPORARY TABLESPACE tempts1
      TEMPFILE '/opt/oracle/oradata/mynewdb/temp01.dbf'
      SIZE 20M REUSE AUTOEXTEND ON NEXT 640K MAXSIZE UNLIMITED
   UNDO TABLESPACE undotbs1
      DATAFILE '/opt/oracle/oradata/mynewdb/undotbs01.dbf'
      SIZE 200M REUSE AUTOEXTEND ON NEXT 5120K MAXSIZE UNLIMITED
   USER_DATA TABLESPACE usertbs
      DATAFILE '/opt/oracle/oradata/mynewdb/usertbs01.dbf'
      SIZE 200M REUSE AUTOEXTEND ON MAXSIZE UNLIMITED;

