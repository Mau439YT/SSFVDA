@echo off
REM Cambia al directorio del proyecto (donde está este archivo)
cd /d "%~dp0"

REM Ejecuta el planificador de tareas de Laravel
"C:\xampp\php\php.exe" artisan schedule:run

REM Opcional: Para evitar que la ventana se cierre inmediatamente para ver errores

REM pause