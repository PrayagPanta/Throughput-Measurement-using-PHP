#!/bin/bash
USAGE=$(free | grep Mem | awk ' {printf( "%.4f " ,$3/$2*100.0) } ' )
if [ $USAGE >  70.0 ]
then
   echo "Resource Usage Exceeded";
   sudo service mysql restart
else 
   echo "less";
fi
