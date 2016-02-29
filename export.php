<?  
header("Content-type: application/csv"); 
header("Content-Disposition: attachment; filename=REPORTS.csv");
header("Pragma: no-cache");
header("Expires: 0");


echo "Car Type,Car Model,Number of Cars\n";  
echo "Mazda,323,5\n";  
echo "Mazda,6,4\n";  
echo "Mazda,MPV,6\n";  
?>