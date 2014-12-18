import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.PrintWriter;
import java.net.URL;

import de.l3s.boilerpipe.BoilerpipeProcessingException;
import de.l3s.boilerpipe.extractors.ArticleExtractor;


class urlextractor 
 {
     void url() throws BoilerpipeProcessingException 
       {
	   	  
  	      System.out.println("Begins!!");
  		  String csvFile = "C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/headline_crimes.csv";
  		  BufferedReader br = null;
  		  String line = "";
  		  String cvsSplitBy = ",";
  		  locationarray a=new locationarray();
  		  String[] locarray= a.locarray();
  		    		 
  		  try 
  		    {
  			   PrintWriter wri = new PrintWriter(new File("C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/Final Url-0.csv") );
  			   br = new BufferedReader(new FileReader(csvFile));
  			   while ((line = br.readLine()) != null) 
  			     {
  	                if (line.length()>0 )
  	                   { 
  			     	    // use comma as separator
  				          String[] news = line.split(cvsSplitBy);
  	                      if(news.length==3)
  	                         {    
  	                    	   String newsurl=news[2].replaceAll("\"", "");
  	                    	   int i =newsurl.indexOf("http");
  	                    	   if (i==0)
  	                    	      {
  	                    		   System.out.println( newsurl);
  			 	                   wri.write(news[0]+','+newsurl+'\n');
  			             
  	                    		   
  			                       }
  	 
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
  	 
  		 System.out.println("Done");
  	 }
}