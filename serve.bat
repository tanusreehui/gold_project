If exist gold_angular\ (
  cd gold_angular/
  If exist "serve.bat" (
    start serve.bat
  )
)
cd..
If exist new_gold_api\ (
  cd "new_gold_api/"
  If exist "serve.bat" (
     start serve.bat
  )
)
cd..
If exist json-server\ (
  cd "json-server/"
  If exist "serve.bat" (
     start serve.bat
  )
)