@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist C:\Users\luissaavaz\Desktop\Servidor\hypersonic\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\server\hsql-sample-database\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\Servidor\ingres\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\ingres\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\Servidor\mysql\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\mysql\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\Servidor\postgresql\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\postgresql\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\Servidor\apache\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\apache\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\Servidor\openoffice\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\openoffice\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\Servidor\apache-tomcat\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\apache-tomcat\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\Servidor\resin\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\resin\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\Servidor\jetty\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\jetty\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\Servidor\subversion\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist C:\Users\luissaavaz\Desktop\Servidor\lucene\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\lucene\scripts\ctl.bat START)
if exist C:\Users\luissaavaz\Desktop\Servidor\third_application\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist C:\Users\luissaavaz\Desktop\Servidor\third_application\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\third_application\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\Servidor\lucene\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist C:\Users\luissaavaz\Desktop\Servidor\subversion\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\subversion\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\Servidor\jetty\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\jetty\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\Servidor\hypersonic\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\Servidor\resin\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\resin\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\Servidor\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT C:\Users\luissaavaz\Desktop\Servidor\apache-tomcat\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\Servidor\openoffice\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\openoffice\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\Servidor\apache\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\apache\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\Servidor\ingres\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\ingres\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\Servidor\mysql\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\mysql\scripts\ctl.bat STOP)
if exist C:\Users\luissaavaz\Desktop\Servidor\postgresql\scripts\ctl.bat (start /MIN /B C:\Users\luissaavaz\Desktop\Servidor\postgresql\scripts\ctl.bat STOP)

:end

