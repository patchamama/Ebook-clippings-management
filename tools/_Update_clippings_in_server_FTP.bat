@echo off

set devicename=paperwhite
REM echo %devicename%>%devicename%

if exist KindleDX set devicename=KindleDX
if exist voyage set devicename=voyage
if exist paperwhite set devicename=paperwhite
if exist kindle4 set devicename=kindle4

set userserver=<server-ftp-username-here>
set pswdserver=<server-ftp-passwordname-here>
set hostserver=<server-ftp-hostname-here>
set perfil=My Clippings
set pathserver=/httpdocs/ebook-tools/%perfil%


echo ---------------------------
echo Servidor: %hostserver%
echo Dispositivo: %devicename%
echo Ruta: %pathserver%
echo.

REM Via FTP:
echo user %userserver%> ftpcmd.dat
echo %pswdserver%>> ftpcmd.dat
REM echo lcd /D "G:\Subfolder\">> ftpcmd.dat
echo mkd "%pathserver%">> ftpcmd.dat
echo cd "%pathserver%">> ftpcmd.dat
echo binary>> ftpcmd.dat
if exist "documents/My Clippings.txt" echo put "documents/My Clippings.txt" "%devicename%.txt">> ftpcmd.dat
if exist "documents/Mis recortes.txt" echo put "documents/Mis recortes.txt" "%devicename%.txt">> ftpcmd.dat
echo quit>> ftpcmd.dat
ftp -n -s:ftpcmd.dat %hostserver%
del ftpcmd.dat

explorer "http://%userserver%/clippings.php?&userclip=%perfil%"

pause