@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\hypersonic\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\server\hsql-sample-database\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\ingres\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\ingres\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\mysql\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\mysql\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\postgresql\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\postgresql\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\apache\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\apache\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\openoffice\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\openoffice\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\apache-tomcat\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\apache-tomcat\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\resin\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\resin\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\jetty\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\jetty\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\subversion\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\lucene\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\lucene\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\third_application\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\third_application\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\third_application\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\lucene\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\subversion\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\subversion\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\jetty\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\jetty\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\hypersonic\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\resin\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\resin\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\apache-tomcat\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\openoffice\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\openoffice\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\apache\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\apache\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\ingres\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\ingres\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\mysql\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\mysql\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\postgresql\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\efdesarrolloweb\Servidor\postgresql\scripts\ctl.bat STOP)

:end

