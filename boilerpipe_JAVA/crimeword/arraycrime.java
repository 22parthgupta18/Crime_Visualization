package crimeword;

import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;


 class arraycrime 
 {

	  public String[] crimearray( )
	  
	  {  String csvFile = "C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/crime_dict.csv";
		 BufferedReader br = null;
		 String line = "";
		 String cvsSplitBy = ",";
	     String[] crime =new String[524]; 
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
	                 if(location.length==2)
	                   {
	                          String a = location[1]; 
                              if(i<524 && !a.equals("Type") )	                         
                              { crime[i++]=" "+a+" ";} 
	                          
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
		 return crime;
		  
	  }
}
