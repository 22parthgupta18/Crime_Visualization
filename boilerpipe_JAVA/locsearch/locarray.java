package locsearch;

import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;


 class locationarray 
 {

	  public String[] locarray( )
	  
	  {  String csvFile = "C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/location.csv";
		 BufferedReader br = null;
		 String line = "";
		 String cvsSplitBy = ",";
	     String[] loc =new String[1689]; 
	     int i=0;
		 try 
		   {
			 
			 br = new BufferedReader(new FileReader(csvFile));
			 while ((line = br.readLine()) != null) 
			   {
	             if (line.length()>0 )
	               { 
			     	// use comma as separator
				     String[] location = line.split(cvsSplitBy);
	                 if(location.length>2)
	                   {
	                      	  String a = location[1].replaceAll("\"",""); 
                              if(i<1689&& !a.equals("Name") )	                         
                              { loc[i++]=" "+a+" ";} 
	                          
				       }
                   }
	         }

		   } 
		 catch (FileNotFoundException e) 
		   {
			 e.printStackTrace();
		   } 
		 catch (IOException e) 
		   {
			 e.printStackTrace();
		   } 
		 finally 
	       {
			 if (br != null) 
			   {
				 try 
				   {
					 br.close();
				   } 
				 catch (IOException e) 
				   {
					 e.printStackTrace();
				   }
			   }
		   }

		 System.out.println("Done loc");
		 return loc;
		  
	  }
}
